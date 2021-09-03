<script>
    $(document).ready(function () {
        $('.money').mask('000.000.000.000', {reverse: true})
		$('#category').select2()

		loadData($('#category').val(), $('#searchactive').val(), $('#last_id').val())

		$('#category').on('change', function(){
            $('#last_id').val(0)
            loadData($('#category').val(), $('#searchactive').val(), $('#last_id').val())
        })

		$('#searchactive').on('input', function(){
            $('#last_id').val(0)
			loadData($('#category').val(), $('#searchactive').val(), $('#last_id').val())
		})

		$('#btn_more').on('click', function(){
            $('#last_id').val(0)
			loadData($('#category').val(), $('#searchactive').val(), ($('#last_id').val()))
		})
    })

    $(document).on('click', '.select-satuan', function(){
        var element = $(this)
        var attr_for = element.attr('for')
        var product_id = element.closest('.card-body').find('.input-product-id').val()
        var satuan_id = element.closest('.card-body').find('#'+ attr_for).val()
        var input_satuan = element.closest('.card-body').find('.input-satuan-id').val(satuan_id)

        $.ajax({
            type: "GET",
            url: APP_URL + '/pos/get-price-list',
            data: {
                product_id: product_id,
                satuan_id: satuan_id,
            },
            dataType: "json",
            success: function (response) {
                element.closest('.card-body').find('.text-price').text(response.text_price)
                element.closest('.card-body').find('.text-stock').text('Tersedia: ' + response.stock)
                element.closest('.card-body').find('.input-price').val(response.price)
            }
        })
    })

    $(document).on('click', '.add-item', function() {
        var product_id = $(this).closest('.card-body').find('.input-product-id').val()
        var satuan_id = $(this).closest('.card-body').find('.input-satuan-id').val()
        var qty = $(this).closest('.card-body').find('.input-qty').val()
        var price = $(this).closest('.card-body').find('.input-price').val()

        var _token   = $('meta[name="csrf-token"]').attr('content')
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
                $('#cart_id').val(response.cart_id)
                $('#btn_total_cart').data('id', response.cart_id)
                var url = '#'
                if(response.total_item>0) url = APP_URL + '/pos/view-cart'
                $('#btn_total_cart').attr('href', url)

                $('#item_cart_text').remove();
                var content_cart = `<span class="badge badge-sm badge-circle badge-floating badge-default border-white" id="item_cart_text" style="top: -70%; left: 10px !important">` + response.total_item + `</span>`
                $('#btn_total_cart').append(content_cart);
            },
        })
    })

	function loadData(category, keyword, last_id){
		$.ajax({
			type: "GET",
			url: APP_URL + '/pos/list-product',
			data: {
				category: category,
				keyword: keyword,
				last_id: last_id
			},
			success: function (response) {
                $('#last_id').val(response.last_id)
                $('#detail_product').html("")
				if(response.total_record<=20) {
					$('#btn_more').hide()
				} else {
					$('#btn_more').show()
				}

				if(response.total_record>0)
				{
					$('#detail_product').show()
					$('#detail_product').append(response.content)
					$('#errorMessage').hide()
				} else {
					$('#errorMessage').show()
					$('#errorMessage').text(response.message)
					$('#detail_product').hide()
				}
			}
		})
    }
</script>
