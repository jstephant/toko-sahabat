<script>
    $(document).ready(function () {
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

        $('#modal-new-item').on('show.bs.modal', function(e){
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
                $('#mode').val(mode);
                $('#product_id').val($(e.relatedTarget).data('product_id'));
                $('#nama_barang').text($(e.relatedTarget).data('product_name'));
                $('#satuan').val($(e.relatedTarget).data('satuan_id'));
                $('#satuan').trigger('change');
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
                data-qty_item="` + qty + `"
                data-price_item="` + price +`"
                data-sub_total_item="` + sub_total + `"
                data-disc_pctg_item="` + disc_pctg + `"
                data-disc_rp_item="` + disc_rp + `"
                data-total_item="` + total +`"
            ><span class="btn-inner--icon"><i class="far fa-edit"></i></span></button>`;
        var content = "";
        content += `<tr>`;
        content += `<td><span class="x1">` + product_name + `<br>Satuan: ` + satuan_name + `</span></td>`;
        content += `<td><span class="x2">` + qty + `</span></td>`;
        content += `<td><span class="x3">` + price + `</span></td>`;
        content += `<td><span class="x4">` + sub_total + `</span></td>`;
        content += `<td><span class="x5">(%): ` + disc_pctg + `<br>Rp: ` + disc_rp +`</span></td>`;
        content += `<td><span class="x6">` + total + `</span></td>`;
        content += `<td>`;
	    content += link_edit;
        content += `<button class="btn btn-icon btn-link p-0 text-danger remove-item" type="button" data-toggle="tooltip" data-placement="bottom" title="Remove Item">`;
	    content += `<span class="btn-inner--icon"><i class="far fa-trash-alt"></i></span>`;
        content += `</button>`;
        content += `</td>`;
        content += `</tr>`;
        content += `<input type="hidden" name="products[]" value="` + product_id + `">`;
        content += `<input type="hidden" name="satuan[]" value="` + satuan_id + `">`;
        content += `<input type="hidden" name="qty[]" value="` + qty + `">`;
        content += `<input type="hidden" name="price[]" value="` + price + `">`;
        content += `<input type="hidden" name="sub_total[]" value="` + sub_total + `">`;
        content += `<input type="hidden" name="disc_pctg[]" value="` + disc_pctg + `">`;
        content += `<input type="hidden" name="disc_rp[]" value="` + disc_rp + `">`;
        content += `<input type="hidden" name="total[]" value="` + total + `">`;

        if(mode=='create')
            $('#detail_purchase > tbody:last-child').append(content);
        else {
            var selected_item = $('table#detail_purchase > tbody > tr.selected-item');
            $(selected_item).find('.x1').html(product_name + `<br>Satuan: ` + satuan_name);
            $(selected_item).find('.x2').html(qty);
            $(selected_item).find('.x3').html(price);
            $(selected_item).find('.x4').html(sub_total);
            $(selected_item).find('.x5').html(`(%): ` + disc_pctg + `<br>Rp: ` + disc_rp);
            $(selected_item).find('.x6').html(total);
            $(selected_item).removeClass('selected-item');
        }

        var sub_total_all = parseInt($('#sub_total').val(), 10) + parseInt(sub_total, 10);
        $('#sub_total').val(sub_total_all);
        $('#sub_total_view').text(sub_total_all);

        var discount = parseInt($('#discount').val(), 10) + parseInt(disc_rp, 10);
        $('#discount').val(discount);
        $('#discount_view').text(discount);

        var total_all = parseInt($('#total').val(), 10) + parseInt(total, 10);
        $('#total').val(total_all);
        $('#total_view').text(total_all);

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
        var qty = $('#qty_item').val();
        var price = $('#price_item').val();
        var sub_total = qty * price;
        $('#sub_total_item').val(sub_total);
        var disc_rp = $('#disc_rp_item').val();
        var total = sub_total - disc_rp;
        $('#total_item').val(total);
    });

    $(document).on('change', '#disc_pctg_item', function () {
        var qty = $('#qty_item').val();
        var price = $('#price_item').val();
        var sub_total = qty * price;
        $('#sub_total_item').val(sub_total);
        var disc_pctg = $('#disc_pctg_item').val();
        if(disc_pctg>0)
            $('#disc_rp_item').attr('readonly', true);
        else $('#disc_rp_item').attr('readonly', false);
        var disc_rp = (disc_pctg / 100) * sub_total;
        $('#disc_rp_item').val(disc_rp);
        var total = sub_total - disc_rp;
        $('#total_item').val(total);
    });
</script>
