<script>
    $(document).ready(function () {
        $('#modal-detail').on('show.bs.modal', function(e) {
            $('#status').select2({
                dropdownParent: $('#modal-create-edit'),
                minimumResultsForSearch: -1
            });

			var id = $(e.relatedTarget).data('id');

            $.ajax({
                type: "GET",
                url: APP_URL + "/order/detail/" + id,
                dataType: "json",
                success: function (response) {
                    if(response.order)
                    {
                        $('#order_code').text(response.order.order_code)
                        $('#order_date').text(response.order.created_at)
                        $('#customer_name').text(response.order.customer.name)

                        if(response.order_detail)
                        {
                            $("#detail_order > tbody > tr").remove();
                            $.each(response.order_detail, function (idx, value) {
                                var content = ``
                                content += `<tr>`
                                content += `<td><span>` + value.product.name + `</span></td>`
                                content += `<td><span>` + value.satuan.name + `</span></td>`
                                content += `<td class="text-right"><span>` + value.qty + `</span></td>`
                                content += `<td class="text-right"><span>` + value.text_price + `</span></td>`
                                content += `<td class="text-right"><span>` + value.text_sub_total + `</span></td>`
                                content += `<td class="text-right"><span>` + value.text_discount +`</span></td>`
                                content += `<td class="text-right"><span>` + value.text_total + `</span></td>`
                                content += `</tr>`;
                                $('#detail_order > tbody:last-child').append(content);
                            });
                        }

                        if(response.payment)
                        {
                            $('#payment_method').text(response.payment.payment_type.name)
                            $('#sub_total').text(response.payment.text_sub_total)
                            $('#discount').text(response.payment.text_discount)
                            $('#total').text(response.payment.text_total)
                            $('#total_pay').text(response.payment.text_pay_total)
                            $('#total_change').text(response.payment.text_pay_change)
                            var payment_status = (response.order.payment_status==1) ? 'Belum Lunas' : 'Lunas';
                            $('#status_bayar').text(payment_status)
                        }
                    }

                }
            });
		});
    });
</script>
