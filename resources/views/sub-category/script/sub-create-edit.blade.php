<script>
    $(document).ready(function () {
        $.ajax({
            type: "GET",
            url: APP_URL + '/kategori/active',
            success: function (response) {
                $('#category2').find('option').remove();
                var content = '<option value=""></option>';
                $.each(response, function (indexInArray, valueOfElement) {
                    content += '<option value="' + valueOfElement['id'] + '">'+ valueOfElement['name'] + '</option>';
                });
                $('#category2').append(content);
            },
        });

        $('#data-loader').hide();
        $('.alert_error').hide();
		$('#modal-sub-create-edit').on('show.bs.modal', function(e) {
            $('#category2, #sub_status').select2({
                dropdownParent: $('#modal-sub-create-edit'),
                minimumResultsForSearch: -1
            });

			var mode = $(e.relatedTarget).data('mode');
            $('#sub_mode').val(mode);

            $('#sub_name').val('').trigger('change');
            $('#category2').val('').trigger('change');
            $('#sub_status').val('').trigger('change');
            if(mode == 'create')
            {
                $('h5#title').text('Create Sub Kategori');
                $('#sub-status-data').hide();
                $("#sub_status").removeAttr('required');
            } else if(mode=='edit')
            {
				$('h5#title').text('Edit Sub Kategori');
				var sub_category_id = $(e.relatedTarget).data('id');
                $('#sub_category_id').val(sub_category_id);

                var sub_category_name = $(e.relatedTarget).data('name');
                $('#sub_name').val(sub_category_name);

                var category_id = $(e.relatedTarget).data('category-id');
                $('#category2').val(category_id).trigger('change');

                var status = $(e.relatedTarget).data('status');
                $('#sub_status').val(status).trigger('change');

                $('#sub-status-data').show();
                $("#sub_status").prop('required', true);
			}
		});
    });

    function storeDataSubCategory() {
        $('#subnameError').addClass('d-none');
        $('#categoryError').addClass('d-none');
        $('#substatusError').addClass('d-none');

        $.ajax({
            type: "POST",
            url: "{{ route('subcategory.save.post') }}",
            data: {
                _token: CRSF_TOKEN,
                sub_category_id: $('#sub_category_id').val(),
                sub_name: $('#sub_name').val(),
                category2: $('#category2').val(),
                sub_status: $('#sub_status').val(),
                sub_mode: $('#sub_mode').val()
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
