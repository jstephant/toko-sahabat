<script>
    $(document).ready(function () {
        $("#purchase_date").flatpickr({
			dateFormat: "Y-m-d",
			maxDate: new Date(),
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

        $.ajax({
            type: "GET",
            url: APP_URL + '/beli/list-detail/' + $('#purchase_id').val(),
            dataType: "json",
            success: function (response) {
                $.each(response, function (index, value) {
                    var link_edit =
                        `<button type="button" class="btn btn-icon btn-link p-0 text-default edit-item" title="Edit Item" data-toggle="modal" data-target="#modal-new-item" data-mode="edit"
                            data-product_id="` + value.product_id + `"
                            data-product_name="` + value.product.code + ' - ' + value.product.name + `"
                            data-satuan_id="` + value.satuan_id + `"
                            data-qty_item="` + value.qty + `"
                            data-price_item="` + value.price +`"
                            data-sub_total_item="` + value.sub_total + `"
                            data-disc_pctg_item="` + value.disc_pctg + `"
                            data-disc_rp_item="` + value.disc_price + `"
                            data-total_item="` + value.total +`"
                        ><span class="btn-inner--icon"><i class="far fa-edit"></i></span></button>`;

                    var content = "";
                    content += `<tr>`;
                    content += `<td><span class="x1">` + value.product.code +' - ' + value.product.name + `<br>Satuan: ` + value.satuan.name + `</span></td>`;
                    content += `<td><span class="x2">` + value.qty + `</span></td>`;
                    content += `<td><span class="x3">` + value.price + `</span></td>`;
                    content += `<td><span class="x4">` + value.sub_total + `</span></td>`;
                    content += `<td><span class="x5">(%): ` + value.disc_pctg + `<br>Rp: ` + value.disc_price +`</span></td>`;
                    content += `<td><span class="x6">` + value.total + `</span></td>`;
                    content += `<td>`;
                    content += link_edit;
                    content += `<button class="btn btn-icon btn-link p-0 text-danger remove-item" type="button" data-toggle="tooltip" data-placement="bottom" title="Remove Item">`;
                    content += `<span class="btn-inner--icon"><i class="far fa-trash-alt"></i></span>`;
                    content += `</button>`;
                    content += `<input type="hidden" name="products[]" class="product_id" value="` + value.product_id + `">`;
                    content += `<input type="hidden" name="satuan[]" class="satuan" value="` + value.satuan_id + `">`;
                    content += `<input type="hidden" name="qty[]" class="qty" value="` + value.qty + `">`;
                    content += `<input type="hidden" name="price[]" class="price" value="` + value.price + `">`;
                    content += `<input type="hidden" name="sub_total[]" class="sub_total" value="` + value.sub_total + `">`;
                    content += `<input type="hidden" name="disc_pctg[]" class="disc_pctg" value="` + value.disc_pctg + `">`;
                    content += `<input type="hidden" name="disc_rp[]" class="disc_rp" value="` + value.disc_rp + `">`;
                    content += `<input type="hidden" name="total[]" class="total" value="` + value.total + `">`;
                    content += `</td>`;
                    content += `</tr>`;

                    $('#detail_purchase > tbody:last-child').append(content);
                });
            }
        });

        $(document).on('click', '.edit-item', function(){
            var edit_item = $(this).closest('.edit-item')
            var row = $(edit_item).closest('tr');
            $(row).addClass('selected-item');
        });

        $(document).on('click', '.remove-item', function(){
            var remove_item = $(this).closest('.remove-item')
            var row = $(remove_item).closest('tr').remove();
            hitungTotal();
        });
    });
</script>
