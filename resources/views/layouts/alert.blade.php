@if (Session::has('error'))
    <script>
        var message = "{{ Session::get('error')}}"
        var title = "{{ Session::get('title') }}"
        Swal.fire({
            icon: 'error',
            title: title,
            text: message,
            showConfirmButton: false,
            timer: 3000
        })
    </script>
@endif

@if(Session::has('success'))
    <script>
        var message = "{{ Session::get('success') }}"
        var title = "{{ Session::get('title') }}"
        Swal.fire({
            icon: 'success',
            title: title,
            text: message,
            showConfirmButton: false,
            timer: 3000
        })
    </script>
@endif