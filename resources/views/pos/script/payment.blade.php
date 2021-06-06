<script>
    $(document).ready(function () {
        $('.money').mask('#.##0', {reverse: true})

        $('#total_pay').on('input', function () {
            var total = $('#total').val()
            var total_pay = $(this).cleanVal()
            var total_change = parseInt(total_pay) - parseInt(total);
            $('#change_text').text(total_change);
        });
    });
</script>
