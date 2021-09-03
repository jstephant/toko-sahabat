<script>
    $(document).ready(function(){
        $("#active_at").flatpickr({
			dateFormat: "Y-m-d",
			defaultDate: new Date(),
        });

        $('#status').select2({
            minimumResultsForSearch: -1
        });

        $('#category, #satuan').select2();

        $('#satuan').on('select2:select', function (e) {
            var data = e.params.data;
            var satuan_id = data.id;
            var satuan_name = data.text;
            var idx = $('#idx_price_list').val();
            var price_list_name = 'price_list.' + idx;
            if(satuan_id!='') {
                var content = "";
                content += `<tr>`;
                content += `<td><span class="x1">` + satuan_name + `</span></td>`;
                content += `<td>`
                content += `<input type="number" name="price_list[]" class="form-control price_list @error('` + price_list_name + `') 'is-invalid' @enderror" autocomplete="off" value="{{ old('` + price_list_name + `') }}" required>`;
                content += `</td>`;
                content += `<input type="hidden" name="satuan_id[]" class="satuan" value="` + satuan_id + `">`;
                content += `<input type="hidden" name="satuan_name[]" class="satuan_name" value="` + satuan_name + `">`;
                content += `</tr>`;

                add_row('#detail_price_list', content);
                $('#idx_price_list').val(parseInt(idx) + parseInt(1));
			}
        });

        $('#satuan').on('select2:unselect', function(e){
            var data = e.params.data;
            var satuan_id = data.id;

            remove_row(satuan_id, '#detail_price_list', '.satuan');
        })
    });
</script>
