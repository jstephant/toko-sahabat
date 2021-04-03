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
                $('h5#title').text('Create Kategori');
                $('#status-data').hide();
                $("#status").removeAttr('required');
            } else if(mode=='edit')
            {
				$('h5#title').text('Edit Kategori');
				var category_id = $(e.relatedTarget).data('id');
                $('#category_id').val(category_id);

                var category_name = $(e.relatedTarget).data('name');
                $('#name').val(category_name);

                var status = $(e.relatedTarget).data('status');
                $('#status').val(status).trigger('change');

                $('#status-data').show();
                $("#status").prop('required', true);
			}
		});

        $('#name').on('input', function(){
            if($('#name').val()==""){
                $('#check-name').hide();
            } else {
                $.ajax({
                    type: "GET",
                    url: APP_URL + '/kategori/check-name/' + $('#name').val(),
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
