        <footer class="main-footer">
            <strong>Copyright &copy; 2022 <a href="{{ route('home') }}">{{ config('app.name', 'Ben Computer') }}</a>.</strong>
            <div class="float-right d-none d-sm-inline-block">
                <b>Template</b> AdminLTE 3.2.0
            </div>
        </footer>

        <aside class="control-sidebar control-sidebar-dark">

        </aside>

    </div>


    <script src="{{ asset('templates/adminlte/plugins/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('templates/adminlte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    <script src="{{ asset('templates/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('templates/adminlte/plugins/chart.js/Chart.min.js') }}"></script>

    <script src="{{ asset('templates/adminlte/plugins/sparklines/sparkline.js') }}"></script>

    <script src="{{ asset('templates/adminlte/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('templates/adminlte/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>

    <script src="{{ asset('templates/adminlte/plugins/jquery-knob/jquery.knob.min.js') }}"></script>

    <script src="{{ asset('templates/adminlte/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('templates/adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>

    <script src="{{ asset('templates/adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <script src="{{ asset('templates/adminlte/plugins/summernote/summernote-bs4.min.js') }}"></script>

    <script src="{{ asset('templates/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

    <script src="{{ asset('templates/adminlte/dist/js/adminlte.js?v=3.2.0') }}"></script>

    <script>
        $.widget.bridge('uibutton', $.ui.button);
        localStorage.setItem('AdminLTE:Demo:MessageShowed', (Date.now()) + (24 * 60 * 1000))
    </script>

    <script src="{{ asset('templates/adminlte/dist/js/demo.js') }}"></script>

    <script src="{{ asset('templates/adminlte/dist/js/pages/dashboard.js') }}"></script>

    @if(Session::has('success') || Session::has('info')
    || Session::has('warning') || Session::has('error'))
        <script>
            $(function(){
                @if(Session::has('success'))
                    toastr.success("{{ Session::get('success') }}");
                @endif

                @if(Session::has('info'))
                    toastr.info("{{ Session::get('info') }}");
                @endif

                @if(Session::has('warning'))
                    toastr.warning("{{ Session::get('warning') }}");
                @endif

                @if(Session::has('error'))
                    toastr.error("{{ Session::get('error') }}");
                @endif
            });
        </script>
    @endif
