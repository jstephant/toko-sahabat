<script>
    $(document).ready(function () {
        $("#purchase_date").flatpickr({
			dateFormat: "Y-m-d",
			defaultDate: new Date(),
			maxDate: new Date(),
        });

        $('#supplier').select2({
			minimumResultsForSearch: -1,
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
                    var query = { q: params.term }
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

        $('#browse_product').on('select2:select', function () {
            var product_id = $('#browse_product').val();
            var product_name = $("#browse_product option:selected" ).text();
            if(product_id!='') {
                $('#modal-new-item').modal('show');
				$('#browse_product').val('');
                $('#browse_product').trigger('change')
			}
        });
    });

    $(document).on('click', '.edit-item', function(){
        var edit_item = $(this).closest('.edit-item')
        var row = $(edit_item).closest('tr');
        $(row).addClass('selected-item');
    })
</script>
