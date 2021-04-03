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
                $('h5#title').text('Create Satuan');
                $('#status-data').hide();
                $("#status").removeAttr('required');
            } else if(mode=='edit')
            {
				$('h5#title').text('Edit Satuan');
				var satuan_id = $(e.relatedTarget).data('id');
                $('#satuan_id').val(satuan_id);

                var satuan_code = $(e.relatedTarget).data('code');
                $('#code').val(satuan_code);

                var satuan_name = $(e.relatedTarget).data('name');
                $('#name').val(satuan_name);

                var status = $(e.relatedTarget).data('status');
                $('#status').val(status).trigger('change');

                $('#status-data').show();
                $("#status").prop('required', true);
			}
		});

        // $('#check-name, #check-code').hide();
        $('#code').on('input', function(){
            if($('#code').val()==""){
                $('#check-code').hide();
            } else {
                $.ajax({
                    type: "GET",
                    url: APP_URL + '/satuan/check-code/' + $('#code').val(),
                    success: function (response) {
                        console.log();
                        $('#check-code').removeClass('text-success text-danger');
                        if(response==1) {
                            $('#check-code').text('tersedia');
                            $('#check-code').addClass('text-success');
                        } else {
                            $('#check-code').text('tidak tersedia');
                            $('#check-code').addClass('text-danger');
                        }
                    },
                    complete: function()
                    {
                        $('#check-code').show();
                    }
                });
            }
        });
        $('#name').on('input', function(){
            if($('#name').val()==""){
                $('#check-name').hide();
            } else {
                $.ajax({
                    type: "GET",
                    url: APP_URL + '/satuan/check-name/' + $('#name').val(),
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
