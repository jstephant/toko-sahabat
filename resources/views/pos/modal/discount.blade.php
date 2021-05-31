<div class="modal fade" id="modal-set-discount" tabindex="-1" role="dialog" aria-labelledby="modal-set-diskon" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-sm" role="document">
		<div class="modal-content">
            <div class="modal-header justify-content-center bg-default">
                <h5 id="title" class="modal-title text-white">Set Discount</h5>
            </div>
            <div class="modal-body justify-content-center">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">(%)</span>
                            </div>
                            <input type="number" id="disc_pctg_item" name="disc_pctg_item" class="form-control text-right" style="width: 50%" autocomplete="off" value="0">
                        </div>

                        <div class="input-group mt-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="number" id="disc_price_item" name="disc_price_item" class="form-control text-right" autocomplete="off" value="0">
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mt-3">
                    <input type="hidden" id="cart_id_set_discount">
                    <input type="hidden" id="product_id_set_discount">
                    <input type="hidden" id="sub_total_set_discount">
                    <button type="button" class="btn btn-facebook" id="btn_set_discount" name="btn_set_discount">Set</button>
                </div>
            </div>
		</div>
	</div>
</div>
<script>
    $(document).ready(function () {
        $('#modal-set-discount').on('show.bs.modal', function(e){
            var cart_id = $(e.relatedTarget).data('cart_id');
            var product_id = $(e.relatedTarget).data('product_id');
            var sub_total = $(e.relatedTarget).data('sub_total');
            var disc_pctg = $(e.relatedTarget).data('disc_pctg');
            var disc_price = $(e.relatedTarget).data('disc_price');
            $('#cart_id_set_discount').val(cart_id);
            $('#product_id_set_discount').val(product_id);
            $('#sub_total_set_discount').val(sub_total);
            $('#disc_pctg_item').val(disc_pctg);
            $('#disc_price_item').val(disc_price);
            if(disc_pctg>0)
                $('#disc_price_item').attr('readonly', true);
            else $('#disc_price_item').attr('readonly', false);
        })
    });

    $(document).on('click', '.edit-discount', function(){
        var edit_discount = $(this).closest('.edit-discount').closest('.card')
        $(edit_discount).addClass('selected-item');
    });

    $(document).on('change', '#disc_pctg_item', function () {
        var sub_total = $('#sub_total_set_discount').val();

        var disc_pctg = $('#disc_pctg_item').val();
        if(disc_pctg>0)
            $('#disc_price_item').attr('readonly', true);
        else $('#disc_price_item').attr('readonly', false);

        var disc_rp = hitungDiscPctg(sub_total, disc_pctg);
        $('#disc_price_item').val(disc_rp);
    });

    $(document).on('click', '#btn_set_discount', function() {
        var _token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "POST",
            url: APP_URL + '/pos/set-discount',
            data: {
                cart_id: $('#cart_id_set_discount').val(),
                product_id: $('#product_id_set_discount').val(),
                disc_pctg: $('#disc_pctg_item').val(),
                disc_price: $('#disc_price_item').val(),
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
                        content_disc_price += `<small><del>Rp` + response.detail.disc_price + `</del></small>`;
                    }

                    var content_discount = content_disc_pctg + content_disc_price;
                    if(!content_discount)
                    {
                        content_discount = `<small><del>Discount</del></small>`;
                    }
                    $('#total_view').text(response.header.total);
                    var selected_item = $(document).find('.selected-item');
                    selected_item.find('.edit-discount').data('sub_total', response.detail.sub_total);
                    selected_item.find('.edit-discount').data('disc_pctg', response.detail.disc_pctg);
                    selected_item.find('.edit-discount').data('disc_price', response.detail.disc_price);
                    selected_item.find('.discount-text').html(content_discount);
                    selected_item.find('.item-total-text').text('Rp' + response.detail.total);
                    $(selected_item).removeClass('selected-item');
                }
            }
        });

        $('#modal-set-discount').modal('hide');
    });
</script>

