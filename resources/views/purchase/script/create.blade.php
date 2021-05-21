<script>
    $(document).ready(function () {
        $("#purchase_date").flatpickr({
			dateFormat: "Y-m-d",
			defaultDate: new Date(),
			maxDate: new Date(),
        });

        $('#supplier').select2({
            ajax:{
                url: APP_URL + '/supplier/list-active',
                type: "GET",
                dataType: "json",
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item){
							return {
								text: item.name,
								id: item.id
							}
                        })
                    };
                },
            },
		});

        $("#browse_product").select2({
			placeholder: {
				id: '',
				text: '',
			},
			allowClear: true,
            closeOnSelect: true,
			ajax: {
                url: APP_URL + "/barang/list-active",
                dataType: 'json',
                type: 'GET',
				data: function(params) {
                    var query = { keyword: params.term }
                    return query;
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item){
							return {
								text: item.code + ' - ' +item.name,
								id: item.id
							}
                        })
                    };
                },
            },
		});

        $('#browse_product').on('select2:select', function (e) {
            var data = e.params.data;
            var product_id = data.id;
            if(product_id!='') {
                $('#modal-new-item').modal('show');
				$('#browse_product').val('');
                $('#browse_product').trigger('change')
			}
        });
    });

    $(document).on('click', '.edit-item', function(){
        var edit_item = $(this).closest('.edit-item').closest('tr')
        $(edit_item).addClass('selected-item');
    });

    $(document).on('click', '.remove-item', function(){
        var remove_item = $(this).closest('.remove-item').closest('tr').remove();
        var elements = ['.sub_total', '.disc_rp', '.total'];
        var hasil = hitungTotal('#detail_purchase', elements);

        $('#sub_total_all').val(hasil[0]);
        $('#sub_total_view').text(hasil[0]);

        $('#discount_all').val(hasil[1]);
        $('#discount_view').text(hasil[1]);

        $('#total_all').val(hasil[2]);
        $('#total_view').text(hasil[2]);
    });
</script>
