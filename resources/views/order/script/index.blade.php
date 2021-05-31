<script>
    $(document).ready(function() {
        var date = new Date();
        var start_date = date.setDate(date.getDate() - 7);
        $("#start_date").flatpickr({
			dateFormat: "Y-m-d",
			defaultDate: start_date,
			maxDate: new Date(),
        });

        $("#end_date").flatpickr({
			dateFormat: "Y-m-d",
			defaultDate: new Date(),
			maxDate: new Date(),
        });

        $('#customer').select2();
        $('#payment_status').select2({
			minimumResultsForSearch: -1,
		});

        var purchase_table = $('#order_table').DataTable( {
			processing: true,
            serverSide: true,
            responsive: false,
            pageLength: 10,
            ajax: {
                type: "GET",
				url: APP_URL + '/order/list',
				data: function(d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                    d.status = $('#status').val();
					d.keyword = $('#searchactive').val();
				}
			},
			dom:
				"<'row'<'col-sm-12 col-md-6'l>>" +
				"<'row'<'col-sm-12'tr>>" +
				"<'row py-3'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
			lengthChange: true,
			language: {
				lengthMenu: "Show _MENU_ entries",
				paginate: {
					first: "<i class='fa fa-angle-double-left'></i>",
					previous: "<i class='fa fa-angle-left'></i>",
					next: "<i class='fa fa-angle-right'></i>",
					last: "<i class='fa fa-angle-double-right'></i>",
				}
			},
			pagingType: "simple_numbers",
			columns : [
                {
					orderable: true,
					render: function(data, type, row, meta) {
                        return row.order_code;
					}
				},
				{
					orderable: true,
					render: function(data, type, row, meta) {
						return row.order_date;
					}
				},
				{
					orderable: true,
					render: function(data, type, row, meta) {
                        return row.customer.name;
					}
				},
                {
					orderable: true,
					render: function(data, type, row, meta) {
                        return row.customer.mobile_phone;
					}
				},
                {
					orderable: true,
					render: function(data, type, row, meta) {
                        return row.sub_total
					}
				},
                {
					orderable: true,
					render: function(data, type, row, meta) {
                        return row.disc_price
					}
				},
                {
					orderable: true,
					render: function(data, type, row, meta) {
                        return row.total
					}
				},
                {
					orderable: true,
					render: function(data, type, row, meta) {
                        var content = '';
                        if(row.updated_by==null){
                            content += row.created_at;
                            content += `<br>`;
                            content += `By <span>` + row.created_user.name + `</span>`
                        } else {
                            content += row.updated_at;
                            content += `<br>`;
                            content += `By <span>` + row.updated_user.name + `</span>`
                        }
                        return content
					}
				},
                {
					orderable: true,
					render: function(data, type, row, meta) {
                        var content = `<a class="dropdown-item text-success" href="#"
                                            data-toggle="modal"
                                            data-target="#modal-payment"
                                            data-id="` + row.id + `"
                                            data-link="/order/pay">Bayar
                                        </a>`
                        return content
					}
				},
                {
					orderable: true,
					render: function(data, type, row, meta) {
                        var content = `<a class="dropdown-item text-danger" href="#"
                                            data-toggle="modal"
                                            data-target="#modal-confirm-cancel"
                                            data-id="` + row.id + `"
                                            data-link="/order/cancel">Batal
                                        </a>`
                        return content
					}
				},
            ],
            error:setTimeout(1000),
			order: [0, 'asc'],
		});

        $('#searchactive').on('input', function(){
            order_table.ajax.reload()
        });

        $('#start_date, #end_date, #customer').on('change', function(){
            order_table.ajax.reload();
        });
    });
</script>
