<div>
    @if(session()->has('thanks'))
    <script>
        Swal.fire({
            icon: "success",
            title: "Thank you!",
            text: "{{ session()->get('thanks') }}",
        })
    </script>
    @elseif(session()->has('sorry'))
    <script>
        Swal.fire({
            icon: "error",
            title: "Sorry",
            text: "{{ session()->get('sorry') }}",
        })
    </script>
    @endif
</div>