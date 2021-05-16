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

        $('#supplier').select2({
			minimumResultsForSearch: -1,
		});

        var purchase_table = $('#purchase_table').DataTable( {
			processing: true,
            serverSide: true,
            responsive: false,
            pageLength: 10,
            ajax: {
                type: "GET",
				url: APP_URL + '/beli/list',
				data: function(d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
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
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
					orderable: true,
					render: function(data, type, row, meta) {
                        return row.purchase_number;
					}
				},
				{
					orderable: true,
					render: function(data, type, row, meta) {
						return row.purchase_date;
					}
				},
				{
					orderable: true,
					render: function(data, type, row, meta) {
                        return row.supplier.name;
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
					orderable: false,
					render: function(data, type, row, meta) {
						var content = `
							<ul class="navbar-nav ml-lg-auto">
								<li class="nav-item dropdown">
									<a class="text-gray" href="#" id="navbar-primary_dropdown_1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
									<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-primary_dropdown_1">
                                        <a class="dropdown-item" href="{{url('/beli/edit/` + row.id + `')}}">Edit</a>
                                        <a class="dropdown-item text-danger" href="#"
                                            data-toggle="modal"
                                            data-target="#modal-confirm-delete"
                                            data-id="` + row.id + `"
                                            data-link="/beli/delete">Delete
                                        </a>
									</div>
								</li>
							</ul>
						`;
						return content;
					}
				},
            ],
            error:setTimeout(1000),
			order: [0, 'asc'],
		});

        $('#searchactive').on('input', function(){
            purchase_table.ajax.reload()
        });

        $('#start_date, #end_date, #supplier').on('change', function(){
            purchase_table.ajax.reload();
        });
    });
</script>
