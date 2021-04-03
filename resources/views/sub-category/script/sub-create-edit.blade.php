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

        $('#sub-name').on('input', function(){
            if($('#sub-name').val()==""){
                $('#check-sub-name').hide();
            } else {
                $.ajax({
                    type: "GET",
                    url: APP_URL + '/sub-kategori/check-name/' + $('#sub-name').val(),
                    success: function (response) {
                        console.log();
                        $('#check-sub-name').removeClass('text-success text-danger');
                        if(response==1) {
                            $('#check-sub-name').text('tersedia');
                            $('#check-sub-name').addClass('text-success');
                        } else {
                            $('#check-sub-name').text('tidak tersedia');
                            $('#check-sub-name').addClass('text-danger');
                        }
                    },
                    complete: function()
                    {
                        $('#check-sub-name').show();
                    }
                });
            }
        });
    });
</script>
