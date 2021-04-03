<script>
    $(document).ready(function(){
        $('#role').select2({
            placeholder: 'Select Role',
            minimumInputLength: -1
        });

        $('#check-username').hide();
        $('#username').on('input', function(){
            if($('#username').val()==""){
                $('#check-username').hide();
            } else {
                $.ajax({
                    type: "GET",
                    url: APP_URL + '/user/check-user_name/' + $('#username').val(),
                    success: function (response) {
                        console.log();
                        $('#check-username').removeClass('text-success text-danger');
                        if(response==1) {
                            $('#check-username').text('tersedia');
                            $('#check-username').addClass('text-success');
                        } else {
                            $('#check-username').text('tidak tersedia');
                            $('#check-username').addClass('text-danger');
                        }
                    },
                    complete: function()
                    {
                        $('#check-username').show();
                    }
                });
            }
        });
    })
</script>
