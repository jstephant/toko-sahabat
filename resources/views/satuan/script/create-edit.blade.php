<script>
    $(document).ready(function () {
        $('#data-loader').hide();
        $('.alert_error').hide();
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

                var qty = $(e.relatedTarget).data('qty');
                $('#qty').val(qty);

                var status = $(e.relatedTarget).data('status');
                $('#status').val(status).trigger('change');

                $('#status-data').show();
                $("#status").prop('required', true);
			}
		});
    });

    function storeData() {
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        var satuan_id = $('#satuan_id').val();
        var satuan_code = $('#code').val();
        var satuan_name = $('#name').val();
        var qty = $('#qty').val();
        var status = $('#status').val();
        var mode = $('#mode').val();

        $('#codeError').addClass('d-none');
        $('#nameError').addClass('d-none');
        $('#qtyError').addClass('d-none');
        $('#statusError').addClass('d-none');

        $.ajax({
            type: "POST",
            url: "{{ route('satuan.save.post')}}",
            data: {
                _token: csrf_token,
                satuan_id: satuan_id,
                code: satuan_code,
                name: satuan_name,
                qty: qty,
                status: status,
                mode: mode
            },
            success: function (response) {
                if (response.status==false) {
                    $('.error-msg').text(response.message);
                    $('.alert_error').show();
                    window.setTimeout(function() {
                        $('.alert_error').hide();
                    }, 3000);
                } else
                    location.reload();
            },
            error: function (response) {
                var errors = response.responseJSON;
                if($.isEmptyObject(errors) == false)
                {
                    $.each(errors.errors, function (key, value) {
                         var errorID = '#' + key + 'Error';
                         $(errorID).removeClass('d-none');
                         $(errorID).text(value);
                    });
                }
            }
        });
    }
</script>
