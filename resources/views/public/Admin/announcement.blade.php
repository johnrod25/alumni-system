@include('public.Admin.header')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h3>Manage Announcements</h3>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#modal-schedule"><i class="fa fa-plus"
                            aria-hidden="true"></i> Add Announcement</button>
                </div>
                <hr class="hr">
                <table id="example" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Content</th>
                            <th>Date Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; ?>
                        @foreach ($datas as $data)
                            <tr class="text-capitalize">
                                <td>{{$i++}}</td>
                                <td class="d-flex justify-content-center"><img
                                        src="{{ asset('images/announcements/' . $data->image_path) }}" alt=""
                                        style="height: 70px;width:100px">
                                </td>
                                <td>{{ $data->title }}</td>
                                <td>{{ $data->content }}</td>
                                <td>{{ $data->created_at }}</td>
                                <td class="text-center">
                                    <a data-toggle="tooltip" title="Edit" class="btn btn-primary btn-sm"
                                        id="edit-announcement" value="{{ $data->id }}"><i class="fa fa-edit"
                                            aria-hidden="true"></i></a>
                                    <a data-toggle="tooltip" title="Delete" class="btn btn-danger btn-sm"
                                        id="delete-announcement" value="{{ $data->id }}"><i class="fa fa-trash"
                                            aria-hidden="true"></i></a>
                                    <form action="{{ route('delete-announcement', $data->id) }}" method="post"
                                        class="form-hidden" id="delete-form">
                                        {{-- <button class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></button> --}}
                                        @csrf
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

<div class="modal fade" id="modal-schedule">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Announcement</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation px-3" id="form-sched" runat="server" novalidate>
                    <!-- First Row -->
                    <div class="col-md-12">
                        <img src="#" alt="..." id="preview" class="card img-preview" />
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Image</label>
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <input type="file" accept="image/*" name="image" id="image" class="form-control"
                                onchange="img_preview(event,'preview')">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" id="title" class="form-control"
                                placeholder="Enter title">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Content</label>
                            <textarea name="content" id="content" class="form-control"
                                placeholder="Enter content" rows="4" cols="50"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="add-announcement">Add Announcement</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal-edit">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Announcement</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation px-3" id="form-sched-edit" novalidate>
                    <!-- First Row -->
                    <div class="col-md-12">
                        <img src="{{ asset('images/qsu-logo.jpg') }}" alt="..." id="edit_preview"
                            class="card img-preview" />
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Image</label>
                            <input type="hidden" name="edit_id" id="edit_id" class="form-control">
                            <input type="file" name="image" accept="image/*" id="edit_image"
                                class="form-control" onchange="img_preview(event,'edit_preview')">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" id="edit_title" class="form-control"
                                placeholder="Enter title">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Content</label>
                            <textarea name="content" id="edit_content" class="form-control"
                                placeholder="Enter content" rows="4" cols="50"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="update-announcement">Update Announcement</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@include('public.Admin.footer')

<script>
    var img_preview = function(event, myId) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById(myId);
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    };
    $(document).on("click", "#add-announcement", function(e) {
        e.preventDefault();
        let image = document.getElementById('image');
        let title = $("#title").val();
        let content = $("#content").val();
        if (image.files.length == 0) {
            errorToast("Image field is required");
        } else {
            let formData = new FormData();
            formData.append('_token', $('#token').val());
            formData.append('image', image.files[0]);
            formData.append('title', title);
            formData.append('content', content);
            $.ajax({
                url: '{{ route('add-announcement') }}',
                type: "post",
                dataType: "json",
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    // let data = JSON.stringify(response);
                    if (data.response == "success") {
                        $('#modal-schedule').modal('hide')
                        $("#form-sched")[0].reset();
                        // successToast(data.message);
                        localStorage.setItem("Notif", JSON.stringify(data));
                        window.location.reload();
                    } else {
                        errorToast(data.message);
                    }
                },
                error: function(response) {
                    // console.log(response)
                    errorToast(response.responseJSON.message);
                }
            });
        }
    });

    $(document).on("click", "#edit-announcement", function(e) {
        e.preventDefault();
        var id = $(this).attr("value");
        $.ajax({
            url: "{{ route('edit-announcement') }}",
            type: "post",
            dataType: "json",
            data: {
                "_token": $('#token').val(),
                id: id
            },
            success: function(data) {
                if (data.response === 'success') {
                    $('#modal-edit').modal('show');
                    $("#edit_id").val(data.announcement[0].id);
                    $("#edit_title").val(data.announcement[0].title);
                    $("#edit_content").val(data.announcement[0].content);
                    // $("#edit_image").val(data.announcement[0].image_path);
                    let image_path = data.announcement[0].image_path;
                    let edit_preview = document.getElementById('edit_preview');
                    let assetImg = "{{ asset('images/announcements/picmo') }}";
                    edit_preview.src = assetImg.replace('picmo', `${image_path}`);
                    console.log(image_path)
                } else {
                    errorToast(data.message);
                }
            }
        });

    });

    $(document).on("click", "#update-announcement", function(e) {
        e.preventDefault();
        let edit_id = $("#edit_id").val();
        let edit_title = $("#edit_title").val();
        let edit_content = $("#edit_content").val();
        let edit_image = document.getElementById('edit_image');


        let formData = new FormData();
        formData.append('_token', $('#token').val());
        formData.append('id', edit_id);
        if (edit_image.files.length != 0) {
            formData.append('image', edit_image.files[0]);
        } else {
            formData.append('image', null);
        }
        formData.append('title', edit_title);
        formData.append('content', edit_content);
        $.ajax({
            url: "{{ route('update-announcement') }}",
            type: "post",
            dataType: "json",
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                if (data.response === 'success') {
                    $('#modal-edit').modal('hide');
                    localStorage.setItem("Notif", JSON.stringify(data));
                    window.location.reload();
                } else {
                    errorToast(data.message);
                }
            }
        });
    });

    $(document).on("click", "#delete-announcement", function(e) {
        e.preventDefault();
        var save = window.confirm('Are you sure you want to delete this?')
        if (save == true) {
            $('#delete-form').submit();
            successToast('Deleted successfully.');
        } else {
            return false;
        }
    });
</script>
