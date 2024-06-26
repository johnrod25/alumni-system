</div>
<!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- Main Footer -->
<footer class="main-footer text-center">
    <strong>Copyright &copy; 2024 <a href="https://adminlte.io">SPUP</a>.</strong>
    All rights reserved.
</footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
    integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
</script> -->
<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
    integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
</script> -->
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<!-- Bootstrap -->
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('assets/dist/js/adminlte.js') }}"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="{{ asset('assets/plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
<script src="{{ asset('assets/plugins/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-mapael/maps/usa_states.min.js') }}"></script>

<!-- DataTables  & Plugins -->
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#example').DataTable();
        let notif = JSON.parse(localStorage.getItem('Notif'));
        if (notif != null) {
            Command: toastr[notif.response](notif.message)
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            localStorage.clear();
        }

        $(".nav-list").click(function() {
            $(this).addClass('active');
            let text = $(this).find('p').text();
            localStorage.setItem('selectedTab', text);
            $('.nav-list').find('p').each(function() {
                if ($(this).text() !== text) {
                    $(this).parent().removeClass('active');
                }
            })
        });
        let selectedTab = localStorage.getItem('selectedTab');
        $('.nav-list').find('p').each(function() {
            if ($(this).text() === selectedTab) {
                $(this).parent().addClass('active');
            }
        })
    });

    function successToast(message) {
        Command: toastr["success"](message)
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    }

    function errorToast(message) {
        Command: toastr["error"](message)
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    }


    function notif(data) {
        localStorage.setItem("Notif", JSON.stringify(data))
    }

    $(document).on("click", "#opendtr", function(e) {
        e.preventDefault();
        var rfid = $(this).attr("value");
        var month = document.getElementById('monthdate').value;
        var mymonth = document.getElementById('monthdate');
        var year = document.getElementById('yeardate').value;
        document.getElementById('monthtext').value = mymonth.options[mymonth.selectedIndex].text;
        if (month == "" || year == "") {
            errorToast('Set Date First.');
        } else {
            document.getElementById('myrfid').value = rfid;
            document.getElementById('form').submit();
        }
    });

    function openDtr() {
        var month = document.getElementById('monthdate').value;
        var mymonth = document.getElementById('monthdate');
        var year = document.getElementById('yeardate').value;
        // document.getElementById('choice').value = 1;
        document.getElementById('monthtext').value = mymonth.options[mymonth.selectedIndex].text;
        if (month == "" || year == "") {
            errorToast('Set Date First.');
        } else {
            document.getElementById('form').submit();
        }
    }
    $(document).on("click", "#opendtratd", function(e) {
        e.preventDefault();
        var month = document.getElementById('monthdate').value;
        var mymonth = document.getElementById('monthdate');
        var year = document.getElementById('yeardate').value;
        document.getElementById('choice').value = choice;
        document.getElementById('monthtext').value = mymonth.options[mymonth.selectedIndex].text;
        if (month == "" || year == "") {
            errorToast('Set Date First.');
        } else {
            document.getElementById('form').submit();
        }
    });
</script>
</body>

</html>
