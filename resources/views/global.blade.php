<script>
    var APP_URL = {!! json_encode(url('/')) !!}
    var CRSF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    // fungsi untuk remove row dari tabel
    // ex: dipake saat unselecting satuan, secara otomatis remove pricelistnya
    // params:
    // value        -> nilai acuan dalam mencari
    // table_id     -> id tabel
    // find_element -> element apa yang dicari
    function remove_row(value, table_id, find_element)
    {
        var table=$('table' + table_id + ' > tbody > tr');
        table.each(function (i, element) {
            var row = $(element);
            var find_value = row.find(find_element).val();
            if(value==find_value)
            {
                row.remove();
            }
        });
    }

    // untuk menambah row pada tabel
    // params: table_id, content
    function add_row(table_id, content)
    {
        $(table_id + ' > tbody:last-child').append(content);
    }

    // initialisasi select2 berdasarkan tipe
    function init_select2(element, type)
    {
        switch (type) {
            case 1:
                $(element).select2();
                break;
            case 2:
                $(element).select2({
                    minimumResultsForSearch: -1,
                });
                break;
            default:
                break;
        }
    }

    function hitungTotal(table_id, elements)
    {
        var sub_total = 0;
        var discount = 0;
        var total = 0;
        var table = $('table' + table_id + '> tbody > tr');
        table.each(function (i, element) {
            var row = $(element);
            sub_total = parseInt(sub_total, 10) + parseInt(row.find(elements[0]).val(), 10);
            discount = parseInt(discount, 10) + parseInt(row.find(elements[1]).val(), 10);
            total = parseInt(total, 10) + parseInt(row.find(elements[2]).val(), 10);
        });

        return [sub_total, discount, total]
    }

    function hitungSubTotalItem(qty, price)
    {
        return qty * price;
    }

    function hitungTotalItem(sub_total, disc_rp)
    {
        return sub_total - disc_rp;
    }

    function hitungDiscPctg(sub_total, disc_rp)
    {
        return (disc_rp/100) * sub_total;
    }

</script>
