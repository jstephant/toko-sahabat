<script>
    $(document).ready(function () {
		$('#sub_category').select2();

		loadData($('#sub_category').val(), $('#search').val(), $('#start').val());

		$('#sub_category').on('change', function(){
            loadData($('#sub_category').val(), $('#search').val(), $('#start').val());
        });

		$('#search').on('input', function(){
			loadData($('#sub_category').val(), $('#search').val(), $('#start').val());
		});

		$('#btn_more').on('click', function(){
			loadData($('#sub_category').val(), $('#search').val(), ($('#next_start').val() * parseInt(20)));
		});
    });

    $(document).on('click', '.select-satuan', function(){
        var element = $(this);
        var attr_for = element.attr('for');
        var product_id = element.closest('.card-body').find('.input-product-id').val();
        var satuan_id = element.closest('.card-body').find('#'+ attr_for).val();
        var input_satuan = element.closest('.card-body').find('.input-satuan-id').val(satuan_id);

        $.ajax({
            type: "GET",
            url: APP_URL + '/pos/get-price-list',
            data: {
                product_id: product_id,
                satuan_id: satuan_id,
            },
            dataType: "json",
            success: function (response) {
                element.closest('.card-body').find('.text-price').text('Rp ' + response.price);
                element.closest('.card-body').find('.text-stock').text('Tersedia: ' + response.stock);
            }
        });
    });

    $(document).on('click', '.add-item', function() {
        var product_id = $(this).closest('.card-body').find('.input-product-id').val();
        var satuan_id = $(this).closest('.card-body').find('.input-satuan-id').val();
        var qty = $(this).closest('.card-body').find('.input-qty').val();
        var price = $(this).closest('.card-body').find('.input-price').val();

        var _token   = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "POST",
            url: APP_URL + '/pos/add-item',
            data: {
                cart_id: $('#cart_id').val(),
                product_id: product_id,
                satuan_id: satuan_id,
                qty: qty,
                price: price,
                _token: _token
            },
            success: function (response) {
                $('#cart_id').val(response['cart_id']);
                $('#total_item_cart').show();
                $('#btn_total_cart').data('id', response['cart_id']);
                if(response['total_item']>0)
                    $('#btn_total_cart').removeClass('no-modal');
                else $('#btn_total_cart').addClass('no-modal');

                $('#total_item_cart').text(response['total_item']);
            },
            complete: function()
            {
                location.reload();
            }
        });
    });

	function loadData(category, keyword, start){
		$.ajax({
			type: "GET",
			url: APP_URL + '/pos/list-product',
			data: {
				sub_category: category,
				keyword: keyword,
				start: start
			},
			success: function (response) {
				if(response['total_record']<=20) {
					$('#detail_product').html("");
					$('#btn_more').hide();
				} else {
					$('#btn_more').show();
				}

				if(response['total_record']>0)
				{
					$('#detail_product').show();
					$('#detail_product').append(response['content']);
					$('#errorMessage').hide();

					$('#start').val(response['start']);
					$('#next_start').val(response['next_start']);
				} else {
					$('#errorMessage').show();
					$('#errorMessage').text(response['message']);
					$('#detail_product').hide();

					$('#start').val(response['start']);
					$('#next_start').val(response['next_start']);
				}
			}
		});
    }
</script>
