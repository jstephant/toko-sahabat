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
    });

    function storeData() {
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        var role_id = $('#role_id').val();
        var role_name = $('#name').val();
        var status = $('#status').val();
        var mode = $('#mode').val();

        $('#nameError').addClass('d-none');
        $('#statusError').addClass('d-none');

        $.ajax({
            type: "POST",
            url: "{{ route('role.save.post')}}",
            data: {
                _token: csrf_token,
                role_id: role_id,
                name: role_name,
                status: status,
                mode: mode
            },
            success: function (response) {
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
