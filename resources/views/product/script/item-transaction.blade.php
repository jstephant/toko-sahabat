<script>
    $(document).ready(function () {
        $('#modal-new-item').on('show.bs.modal', function(e){
            var data_source = $(e.relatedTarget).data('source-satuan');
            if(data_source=='satuan')
            {
                $('#satuan').select2({
                    dropdownParent: $('#modal-new-item'),
                    minimumResultsForSearch: -1,
                    ajax: {
                        url: APP_URL + '/satuan/list-active',
                        type: "GET",
                        dataType: 'json',
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
                    }
                });
            }

            var mode = $(e.relatedTarget).data('mode');
            if(mode!='edit')
            {
                var product_id = $('#browse_product').val();
                var product_name = $("#browse_product option:selected" ).text();
                $('#mode').val('create');
                $('#product_id').val(product_id);
                $('#nama_barang').text(product_name);
                $('#btn_add_item').text('Tambah');
            } else {
                var product_id = $(e.relatedTarget).data('product_id');
                var satuan_id = $(e.relatedTarget).data('satuan_id');
                var satuan_name = $(e.relatedTarget).data('satuan_name');
                if(data_source=='product_satuan')
                {
                    $('#satuan').select2({
                        dropdownParent: $('#modal-new-item'),
                        minimumResultsForSearch: -1,
                        ajax: {
                            url: APP_URL + '/barang/product-satuan/' + product_id,
                            type: "GET",
                            dataType: 'json',
                            processResults: function(data) {
                                return {
                                    results: $.map(data, function(item){
                                        return {
                                            text: item.name,
                                            id: item.satuan_id
                                        }
                                    })
                                };
                            },
                        }
                    });
                }
                $('#mode').val(mode);
                $('#product_id').val(product_id);
                $('#nama_barang').text($(e.relatedTarget).data('product_name'));
                $('#satuan').select2('data', {id:satuan_id, label:satuan_name});
                // $('#satuan').val(satuan_id).trigger('change');
                $('#qty_item').val($(e.relatedTarget).data('qty_item'));
                $('#price_item').val($(e.relatedTarget).data('price_item'));
                $('#sub_total_item').val($(e.relatedTarget).data('sub_total_item'));
                $('#disc_pctg_item').val($(e.relatedTarget).data('disc_pctg_item'));
                $('#disc_rp_item').val($(e.relatedTarget).data('disc_rp_item'));
                $('#total_item').val($(e.relatedTarget).data('total_item'));
                $('#btn_add_item').text('Update');
            }
        })
    });

    $(document).on('click', '#btn_add_item', function() {
        var mode = $('#mode').val();
        var product_id = $('#product_id').val();
        var product_name = $("#nama_barang").text();
        var satuan_id = $('#satuan').val();
        var satuan_name = $("#satuan option:selected" ).text();
        var qty = $('#qty_item').val();
        var price = $('#price_item').val();
        var sub_total = $('#sub_total_item').val();
        var disc_pctg = $('#disc_pctg_item').val();
        var disc_rp = $('#disc_rp_item').val();
        var total = $('#total_item').val();

        var link_edit =
            `<button type="button" class="btn btn-icon btn-link p-0 text-default edit-item" title="Edit Item" data-toggle="modal" data-target="#modal-new-item" data-mode="edit"
                data-product_id="` + product_id + `"
                data-product_name="` + product_name + `"
                data-satuan_id="` + satuan_id + `"
                data-satuan_name="` + satuan_name + `"
                data-qty_item="` + qty + `"
                data-price_item="` + price +`"
                data-sub_total_item="` + sub_total + `"
                data-disc_pctg_item="` + disc_pctg + `"
                data-disc_rp_item="` + disc_rp + `"
                data-total_item="` + total +`"
                data-source-satuan="satuan"
            ><span class="btn-inner--icon"><i class="far fa-edit"></i></span></button>`;
        var content = "";
        content += `<tr>`;
        content += `<td><span class="x1">` + product_name + `<br><span class="badge badge-default">`+ satuan_name +`</span></span></td>`;
        content += `<td><span class="x2">` + qty + `</span></td>`;
        content += `<td><span class="x3">` + price + `</span></td>`;
        content += `<td><span class="x4">` + sub_total + `</span></td>`;
        content += `<td><span class="x5">` + disc_rp +`</span></td>`;
        content += `<td><span class="x6">` + total + `</span></td>`;
        content += `<td>`;
	    content += link_edit;
        content += `<button class="btn btn-icon btn-link p-0 text-danger remove-item" type="button" data-toggle="tooltip" data-placement="bottom" title="Remove Item">`;
	    content += `<span class="btn-inner--icon"><i class="far fa-trash-alt"></i></span>`;
        content += `</button>`;
        content += `<input type="hidden" name="products[]" class="product_id" value="` + product_id + `">`;
        content += `<input type="hidden" name="satuan[]" class="satuan" value="` + satuan_id + `">`;
        content += `<input type="hidden" name="qty[]" class="qty" value="` + qty + `">`;
        content += `<input type="hidden" name="price[]" class="price" value="` + price + `">`;
        content += `<input type="hidden" name="sub_total[]" class="sub_total" value="` + sub_total + `">`;
        content += `<input type="hidden" name="disc_pctg[]" class="disc_pctg" value="` + disc_pctg + `">`;
        content += `<input type="hidden" name="disc_rp[]" class="disc_rp" value="` + disc_rp + `">`;
        content += `<input type="hidden" name="total[]" class="total" value="` + total + `">`;
        content += `</td>`;
        content += `</tr>`;

        if(mode=='create')
            $('#detail_purchase > tbody:last-child').append(content);
        else {
            var selected_item = $('table#detail_purchase > tbody > tr.selected-item');
            $(selected_item).find('.x1').html(product_name + `<br><span class="badge badge-default">` + satuan_name + `</span>`);
            $(selected_item).find('.x2').html(qty);
            $(selected_item).find('.x3').html(price);
            $(selected_item).find('.x4').html(sub_total);
            $(selected_item).find('.x5').html(disc_rp);
            $(selected_item).find('.x6').html(total);

            $(selected_item).find('.qty').val(qty);
            $(selected_item).find('.price').val(price);
            $(selected_item).find('.sub_total').val(sub_total);
            $(selected_item).find('.disc_pctg').val(disc_pctg);
            $(selected_item).find('.disc_rp').val(disc_rp);
            $(selected_item).find('.total').val(total);

            $(selected_item).removeClass('selected-item');
        }

        var elements = ['.sub_total', '.disc_rp', '.total'];
        var hasil = hitungTotal('#detail_purchase', elements);

        $('#sub_total_all').val(hasil[0]);
        $('#sub_total_view').text(hasil[0]);

        $('#discount_all').val(hasil[1]);
        $('#discount_view').text(hasil[1]);

        $('#total_all').val(hasil[2]);
        $('#total_view').text(hasil[2]);

        // clear all
        $('#nama_barang').val('');
        $('#nama_barang').trigger('change');
        $('#satuan').val('');
        $('#satuan').trigger('change');
        $('#qty_item').val('1');
        $('#price_item').val('0');
        $('#sub_total_item').val('0');
        $('#disc_pctg_item').val('0');
        $('#disc_rp_item').val('0');
        $('#disc_rp_item').attr('readonly', false);
        $('#total_item').val('0');
        $('#modal-new-item').modal('hide');
    });

    $(document).on('change', '#qty_item, #price_item, #disc_rp_item', function () {
        var sub_total = hitungSubTotalItem($('#qty_item').val(), $('#price_item').val());
        $('#sub_total_item').val(sub_total);

        var total = hitungTotalItem(sub_total, $('#disc_rp_item').val());
        $('#total_item').val(total);
    });

    $(document).on('change', '#disc_pctg_item', function () {
        var sub_total = hitungSubTotalItem($('#qty_item').val(), $('#price_item').val());
        $('#sub_total_item').val(sub_total);

        var disc_pctg = $('#disc_pctg_item').val();
        if(disc_pctg>0)
            $('#disc_rp_item').attr('readonly', true);
        else $('#disc_rp_item').attr('readonly', false);

        var disc_rp = hitungDiscPctg(sub_total, disc_pctg);
        $('#disc_rp_item').val(disc_rp);

        var total = hitungTotalItem(sub_total, disc_rp);
        $('#total_item').val(total);
    });
</script>
