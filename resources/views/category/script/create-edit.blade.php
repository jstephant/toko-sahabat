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
    });

    function storeData() {
        $('#nameError').addClass('d-none');
        $('#statusError').addClass('d-none');

        $.ajax({
            type: "POST",
            url: "{{ route('category.save.post') }}",
            data: {
                _token: CRSF_TOKEN,
                category_id: $('#category_id').val(),
                name: $('#name').val(),
                status: $('#status').val(),
                mode: $('#mode').val()
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
