<div class="modal fade" id="modal-set-satuan" tabindex="-1" role="dialog" aria-labelledby="modal-set-satuan" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-sm" role="document">
		<div class="modal-content">
            <div class="modal-header justify-content-center bg-primary">
                <h5 id="title" class="modal-title text-white">Satuan</h5>
            </div>
            <div class="modal-body justify-content-center">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <select id="satuan_id_set_satuan" name="satuan_id_set_satuan" class="form-control" required></select>
                    </div>
                </div>
                <div class="row justify-content-center mt-3">
                    <input type="hidden" id="cart_id_set_satuan" name="cart_id_set_satuan">
                    <input type="hidden" id="product_id_set_satuan" name="product_id_set_satuan">
                    <button type="button" class="btn btn-success" id="btn_set_satuan" name="btn_set_satuan">Done</button>
                </div>
            </div>
		</div>
	</div>
</div>
<script>
    $(document).ready(function () {
        $('#modal-set-satuan').on('show.bs.modal', function(e){
            var data_source = $(e.relatedTarget).data('source-satuan');
            var cart_id = $(e.relatedTarget).data('cart_id');
            var product_id = $(e.relatedTarget).data('product_id');
            var satuan_id = $(e.relatedTarget).data('satuan_id');
            var satuan_name = $(e.relatedTarget).data('satuan_name');
            $('#cart_id_set_satuan').val(cart_id);
            $('#product_id_set_satuan').val(product_id);
            if(data_source=='product_satuan')
            {
                $('#satuan_id_set_satuan').select2({
                    dropdownParent: $('#modal-set-satuan'),
                    minimumResultsForSearch: -1,
                    ajax: {
                        url: APP_URL + '/barang/product-satuan/' + product_id,
                        type: "GET",
                        dataType: 'json',
                        processResults: function(data) {
                            return {
                                results: $.map(data, function(item){
                                    return {
                                        id: item.satuan_id,
                                        text: item.name,
                                    }
                                })
                            };
                        },
                    }
                });
            }
            $('#satuan_id_set_satuan').val(satuan_id);
        })
    });

    $(document).on('click', '.edit-satuan', function(){
        var edit_satuan = $(this).closest('.edit-satuan').closest('.card')
        $(edit_satuan).addClass('selected-item');
    });

    $(document).on('click', '#btn_set_satuan', function() {
        var _token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "POST",
            url: APP_URL + '/pos/set-satuan',
            data: {
                cart_id: $('#cart_id_set_satuan').val(),
                product_id: $('#product_id_set_satuan').val(),
                satuan_id: $('#satuan_id_set_satuan').val(),
                _token: _token,
            },
            dataType: "json",
            success: function (response) {
                if(response.detail)
                {
                    var content_disc_pctg = ``;
                    var content_disc_price = ``;
                    if(response.detail.disc_pctg>0)
                    {
                        content_disc_pctg += `<span class="badge badge-sm badge-danger mr-2">` + response.detail.disc_pctg + `%</span>`
                    }

                    if(response.detail.disc_price>0)
                    {
                        content_disc_price += `<small><del>Rp` + response.detail.text_disc_price + `</del></small>`;
                    }

                    var content_discount = content_disc_pctg + content_disc_price;
                    if(!content_discount)
                    {
                        content_discount = `<small class="text-danger"><del>Discount</del></small>`;
                    }

                    $('#total_view').text(response.header.text_total);
                    var selected_item = $(document).find('.selected-item');
                    selected_item.find('.edit-satuan').data('satuan_id', response.detail.satuan_id);
                    selected_item.find('.edit-satuan').data('satuan_name', response.detail.satuan.name);
                    selected_item.find('.satuan-text').text(response.detail.satuan.name);
                    selected_item.find('.text-price').text(response.detail.text_price);
                    selected_item.find('.item-total-text').text(response.detail.text_total);
                    selected_item.find('.input-qty').attr('max', response.detail.stock);

                    selected_item.find('.edit-discount').data('sub_total', response.detail.sub_total);
                    selected_item.find('.edit-discount').data('disc_pctg', response.detail.disc_pctg);
                    selected_item.find('.edit-discount').data('disc_price', response.detail.disc_price);
                    selected_item.find('.discount-text').html(content_discount);

                    selected_item.find('.text-stock').text('Tersedia: ' + response.detail.stock);
                    $(selected_item).removeClass('selected-item');

                    $('#payment_sub_total').text(response.header.text_sub_total);
                    $('#payment_disc_price').text(response.header.text_disc_price);
                    $('#payment_total').text(response.header.text_total);
                    $('#total_pay').val(response.header.total);
                }
            }
        });

        $('#modal-set-satuan').modal('hide');
    });
</script>

