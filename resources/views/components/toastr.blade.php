<div>
    @if(session()->has('success'))
    <script>
        toastr.success("{{session()->get('success')}}");
    </script>
    @endif
    @if(session()->has('error'))
    <script>
        toastr.error("{{session()->get('error')}}");
    </script>
    @endif

    @if(session()->has('message'))
    <script>
        toastr.success("{{session()->get('message')}}");
    </script>
    @endif
    <!-- @if ($errors->any())
    @foreach ($errors->all() as $error)
    <script>
        toastr.error("{{$error}}");
    </script>
    @endforeach
    @endif -->
</div>