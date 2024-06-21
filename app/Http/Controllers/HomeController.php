<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Announcement;
use App\Models\Gallery;
use App\Models\News;
use App\Models\User;
use App\Models\User_Details;
use Illuminate\Http\Request;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ContactRequest;
class HomeController extends Controller
{
    //
    public function index()
    {
        return view('public.Home.index', [
            'announcements' => Announcement::limit(2)->orderBy('id', 'DESC')->get(),
            'galleries' => Gallery::limit(12)->orderBy('id', 'DESC')->get(),
            'news' => News::limit(10)->orderBy('id', 'DESC')->get(),
        ]);
    }

    public function search_record()
    {
        return view('public.Home.search-record');
    }

    public function search_record_submit(Request $request)
    {
        if($request->row_number == 1){
            $validated = $request->validate([
                'lastname' => 'required',
                'firstname' => 'required',
                'middlename' => 'required',
                'birthdate' => 'required',
            ]);
            $users = DB::table('users')
            ->leftJoin('user__details', 'users.user_id', '=', 'user__details.id')
            ->where('lastname',$request->lastname)
            ->where('firstname',$request->firstname)
            ->where('middlename',$request->middlename)
            ->where('birthdate',$request->birthdate)
            ->where('is_deleted',0)
            ->count();
        } else {
            $validated = $request->validate([
                'student_number' => 'required',
                'last_name' => 'required',
            ]);
            $users = DB::table('users')
            ->leftJoin('user__details', 'users.user_id', '=', 'user__details.id')
            ->where('lastname',$request->last_name)
            ->where('student_number',$request->student_number)
            ->where('is_deleted',0)
            ->count();
        }

        if($users == 0){
            return back()->with([
                'status' => 'warning',
                'message' => 'We apologize but your record is not on our database, kindly double check your data and try again. or you may input your data manually.',
                'count' => $users,
        ]);
        }else{
            return back()->with([
                'status' => 'success',
                'message' => 'You are already registered.',
                'count' => $users,
        ]);
        }
    }

    public function register_form()
    {
        return view('public.Home.register-form', [
            'announcements' => Announcement::limit(2)->orderBy('id', 'DESC')->get(),
            'galleries' => Gallery::limit(12)->orderBy('id', 'DESC')->get(),
            'news' => News::limit(10)->orderBy('id', 'DESC')->get(),
        ]);
    }

    public function register_form_submit(Request $request){
        $validated = $request->validate([
            'lastname' => 'required',
            'firstname' => 'required',
            'middlename' => 'required',
            // 'student_number' => 'required',
            'email' => 'required',
            'phone_number' => 'required|digits:11',
            'home_address' => 'required',
            'birthdate' => 'required',
            'degree' => 'required',
            'batch' => 'required',
            'involve_purpose' => 'required',
            'year_graduated' => 'required|before:today',
            'company_name' => 'required',
            'specialization' => 'required',
            'occupation' => 'required',
            'work_status' => 'required',
            'before_employed' => 'required',
        ]);
        $student_number = "";
        if($request->student_number != null){
            $student_number = $request->student_number;
        }
        User_Details::create([
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'student_number' => $student_number,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'home_address' => $request->home_address,
            'birthdate' => $request->birthdate,
            'degree' => $request->degree,
            'batch' => $request->batch,
            'involve_purpose' => $request->involve_purpose,
            'year_graduated' => $request->year_graduated,
            'company_name' => $request->company_name,
            'specialization' => $request->specialization,
            'occupation' => $request->occupation,
            'work_status' => $request->work_status,
            'before_employed' => $request->before_employed,

        ])->save();
        $data = User::create([
            'user_id' => User_Details::latest()->first()->id,
            'name' => $request->firstname.' '.$request->middlename.' '.$request->lastname,
            'username' => $request->email,
            'password' => bcrypt($request->lastname.$request->student_number),
            'usertype' => 2,
            'is_deleted' => 0,
        ]);
        $data->save();

        // return back()->with(['success_message' => 'Registered Successfully.']);
        return redirect('/');
    }

    public function send_email(ContactRequest $request){
        $data = $request->validated();
        Mail::send('public.email.contact', $data, function ($message) use ($data) {
            $message->to(env('ADMIN_EMAIL'))
                    ->subject($data['subject']);
        });

        // Send confirmation email to the contact
        Mail::send('public.email.contact_confirmation', $data, function ($message) use ($data) {
            $message->to($data['email'])
                    ->subject('Thank you for contacting us');
        });


        return redirect('/#contact')->with(['success' => 'Thank you for contacting us, '.$data['name'].'!']);
    //     Mail::to('johnrod.a.malsi@gmail.com')->send(new SendMail([
    //         'name' => 'Johnrod',
    //    ]));
    }

    
}
