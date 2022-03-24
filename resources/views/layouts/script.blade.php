<!-- jQuery -->
<script src="{{asset('Adminlte/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('Adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap -->
<script src="{{asset('Adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- toastr -->
<script src="{{ asset('Adminlte/plugins/toastr/toastr.min.js') }}"></script>
<x-toastr />
<!-- aos script -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init();
  //  loading
  $(function() {
    $('#loading').hide();
  });
</script>