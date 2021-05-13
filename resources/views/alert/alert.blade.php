@if ($message = Session::get('success'))
    <div class="alert alert-default m-2" role="alert">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Success!</strong><span class="ml-2">{{ $message }}</span>
    </div>
@endif

@if ($message = Session::get('error'))
    <div class="alert alert-default m-2" role="alert">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Error!</strong><span class="ml-2">{{ $message }}</span>
    </div>
@endif

<script>
    $(document).ready(function () {
        $(document).ready(function() {
            window.setTimeout(function() {
                $(".alert").fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove();
                });
            }, 3000);
        });
    });
</script>
