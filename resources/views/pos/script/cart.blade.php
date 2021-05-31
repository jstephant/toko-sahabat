<script>
    $(document).ready(function () {
        $("#order_date").flatpickr({
			dateFormat: "Y-m-d",
			maxDate: new Date(),
        })

        $.ajax({
            type: "GET",
            url: APP_URL + '/pos/detail-cart/' + $('#cart_id').val(),
            dataType: "json",
            success: function (response) {
                $('#total_view').text('Rp' + response.header.total)
                $('#btn_save').text('Beli (' + Object.keys(response.detail).length + ')')
                $('#detail_product').append(response.content)
            }
        })

        $(document).on('input', '.input-qty', function(){
            var edit_qty = $(this).closest('.input-qty').closest('.card')
            $(edit_qty).addClass('selected-item')

            var selected_item = $(document).find('.selected-item')
            var cart_id = $('#cart_id').val()
            var product_id = selected_item.find('.input-product-id').val()
            var qty = $(this).val()

            var min = selected_item.find('.input-qty').attr('min')
            var max = selected_item.find('.input-qty').attr('max')
            var input_qty = selected_item.find('.input-qty')
            if(parseInt(qty)>=parseInt(max))
            {
                qty = max
                input_qty.val(max)
            } else if(parseInt(qty)<=parseInt(min))
            {
                qty = min
                input_qty.val(min)
            }
            updateQty(cart_id, product_id, qty)
        })
    })

    $(document).on('click', '.plus-item', function(){
        var edit_qty = $(this).closest('.card')
        $(edit_qty).addClass('selected-item')

        var selected_item = $(document).find('.selected-item')
        var cart_id = $('#cart_id').val()
        var product_id = selected_item.find('.input-product-id').val()

        var max = selected_item.find('.input-qty').attr('max')
        var input_qty = selected_item.find('.input-qty')
        var new_qty = max
        if(parseInt(input_qty.val()) < parseInt(max))
        {
            new_qty = parseInt(input_qty.val()) + 1
            input_qty.val(new_qty)
        } else {
            input_qty.val(max)
        }

        updateQty(cart_id, product_id, new_qty)
    })

    $(document).on('click', '.min-item', function(){
        var edit_qty = $(this).closest('.card')
        $(edit_qty).addClass('selected-item')

        var selected_item = $(document).find('.selected-item')
        var cart_id = $('#cart_id').val()
        var product_id = selected_item.find('.input-product-id').val()

        var min = selected_item.find('.input-qty').attr('min')
        var input_qty = selected_item.find('.input-qty')
        var new_qty = 1
        if(parseInt(input_qty.val()) > parseInt(min))
        {
            new_qty = parseInt(input_qty.val()) - 1
            input_qty.val(new_qty)
        } else {
            input_qty.val(1)
        }

        updateQty(cart_id, product_id, new_qty)
    })

    $(document).on('click', '.remove-item', function(){
        var _token = $('meta[name="csrf-token"]').attr('content')
        var cart_id = $('#cart_id').val()
        var selected_item = $(this).closest('.card')
        var product_id = selected_item.find('.input-product-id').val()

        $.ajax({
            type: "POST",
            url: APP_URL + '/pos/remove-item',
            data: {
                cart_id: cart_id,
                product_id: product_id,
                _token: _token,
            },
            dataType: "json",
            success: function (response) {
                if(response.header)
                {
                    $('#total_view').text('Rp' + response.header.total)
                    $('#btn_save').text('Beli (' + response.total_item + ')')
                }
            },
        })
    })

    function updateQty(cart_id, product_id, qty)
    {
        var _token = $('meta[name="csrf-token"]').attr('content')

        $.ajax({
            type: "POST",
            url: APP_URL + '/pos/set-qty',
            data: {
                cart_id: cart_id,
                product_id: product_id,
                qty: qty,
                _token: _token,
            },
            dataType: "json",
            success: function (response) {
                if(response.detail)
                {
                    $('#total_view').text('Rp' + response.header.total)
                    var content_disc_pctg = ``
                    var content_disc_price = ``
                    if(response.detail.disc_pctg>0)
                    {
                        content_disc_pctg += `<span class="badge badge-sm badge-danger mr-2">` + response.detail.disc_pctg + `%</span>`
                    }

                    if(response.detail.disc_price>0)
                    {
                        content_disc_price += `<small><del>Rp` + response.detail.disc_price + `</del></small>`
                    }

                    var content_discount = content_disc_pctg + content_disc_price
                    if(!content_discount)
                    {
                        content_discount = `<small><del>Discount</del></small>`
                    }
                    var selected_item = $(document).find('.selected-item')
                    selected_item.find('.edit-discount').data('sub_total', response.detail.sub_total)
                    selected_item.find('.edit-discount').data('disc_pctg', response.detail.disc_pctg)
                    selected_item.find('.edit-discount').data('disc_price', response.detail.disc_price)
                    selected_item.find('.discount-text').html(content_discount)
                    selected_item.find('.item-total-text').text('Rp' + response.detail.total)

                    var btn_min = selected_item.find('.min-item')
                    var value_min = selected_item.find('.input-qty').attr('min')
                    var btn_plus = selected_item.find('.plus-item')
                    var value_max = selected_item.find('.input-qty').attr('max')
                    if(parseInt(qty)<=parseInt(value_min))
                    {
                        btn_min.attr('disabled', true)
                        btn_min.removeClass('text-success')
                        btn_min.addClass('text-muted')
                    } else {
                        btn_min.attr('disabled', false)
                        btn_min.removeClass('text-muted')
                        btn_min.addClass('text-success')
                    }

                    if(parseInt(qty)>=parseInt(value_max))
                    {
                        btn_plus.attr('disabled', true)
                        btn_plus.removeClass('text-success')
                        btn_plus.addClass('text-muted')
                    } else {
                        btn_plus.attr('disabled', false)
                        btn_plus.removeClass('text-muted')
                        btn_plus.addClass('text-success')
                    }

                    $(selected_item).removeClass('selected-item')
                }
            }
        })
    }
</script>
