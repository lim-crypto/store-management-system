<!-- jQuery -->
<script src="{{asset('Adminlte/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('Adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>

<!-- Bootstrap 4 -->
<script src="{{asset('Adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('Adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('Adminlte/dist/js/adminlte.min.js')}}"></script>
<!-- toastr -->
<script src="{{ asset('Adminlte/plugins/toastr/toastr.min.js') }}"></script>
<x-toastr />

<!-- sidebar add active class -->
 <script src="{{asset('js/navActiveClass.js')}}"></script>
