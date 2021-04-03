<script>
    $(document).ready(function () {
        $('#data-loader').hide();
		$('#modal-create-edit').on('show.bs.modal', function(e) {
            $('#status').select2({
                dropdownParent: $('#modal-create-edit'),
                minimumResultsForSearch: -1
            });

			var mode = $(e.relatedTarget).data('mode');
            $('#mode').val(mode);

            $('#name').val('').trigger('change');
            $('#status').val('').trigger('change');
            if(mode == 'create')
            {
                $('h5#title').text('Create Role');
                $('#status-data').hide();
                $("#status").removeAttr('required');
            } else if(mode=='edit')
            {
				$('h5#title').text('Edit Role');
				var role_id = $(e.relatedTarget).data('id');
                $('#role_id').val(role_id);

                var role_name = $(e.relatedTarget).data('name');
                $('#name').val(role_name);

                var status = $(e.relatedTarget).data('status');
                $('#status').val(status).trigger('change');

                $('#status-data').show();
                $("#status").prop('required', true);
			}
		});

        $('#check-name').hide();
        $('#name').on('input', function(){
            if($('#name').val()==""){
                $('#check-name').hide();
            } else {
                $.ajax({
                    type: "GET",
                    url: APP_URL + '/role/check-name/' + $('#name').val(),
                    success: function (response) {
                        console.log();
                        $('#check-name').removeClass('text-success text-danger');
                        if(response==1) {
                            $('#check-name').text('tersedia');
                            $('#check-name').addClass('text-success');
                        } else {
                            $('#check-name').text('tidak tersedia');
                            $('#check-name').addClass('text-danger');
                        }
                    },
                    complete: function()
                    {
                        $('#check-name').show();
                    }
                });
            }
        });
    });
</script>
