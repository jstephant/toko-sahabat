<div class="modal fade" id="modal-set-satuan" tabindex="-1" role="dialog" aria-labelledby="modal-set-satuan" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-sm" role="document">
		<div class="modal-content">
            <div class="modal-header justify-content-center bg-default">
                <h5 id="title" class="modal-title text-white">Ganti Satuan</h5>
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
                    <button type="button" class="btn btn-facebook" id="btn_set_satuan" name="btn_set_satuan">Pilih</button>
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
                    $('#total_view').text(response.header.total);
                    var selected_item = $(document).find('.selected-item');
                    selected_item.find('.edit-satuan').data('satuan_id', response.detail.satuan_id);
                    selected_item.find('.edit-satuan').data('satuan_name', response.detail.satuan.name);
                    selected_item.find('.satuan-text').text(response.detail.satuan.name);
                    selected_item.find('.text-price').text('Rp' + response.detail.price);
                    selected_item.find('.item-total-text').text('Rp' + response.detail.total);
                    selected_item.find('.input-qty').attr('max', response.detail.stock);

                    selected_item.find('.text-stock').text('Tersedia: ' + response.detail.stock);
                    $(selected_item).removeClass('selected-item');
                }
            }
        });

        $('#modal-set-satuan').modal('hide');
    });
</script>

