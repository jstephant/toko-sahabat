<script>
    $(document).ready(function() {
        var satuan_table = $('#satuan_table').DataTable({
			processing: true,
            serverSide: true,
            responsive: false,
            pageLength: 10,
            ajax: {
                type: "GET",
				url: APP_URL + '/satuan/list',
				data: function(d) {
					d.keyword = $('#searchactive').val();
				},
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
                        return row.code;
					}
				},
                {
					orderable: true,
					render: function(data, type, row, meta) {
                        return row.name;
					}
				},
                {
					orderable: true,
					render: function(data, type, row, meta) {
                        return row.qty;
					}
				},
                {
					orderable: false,
					render: function(data, type, row, meta) {
                        var is_active = "";
                        if(row.is_active==1) is_active = "checked";
                        var content = `
                            <label class="custom-toggle custom-toggle-success">
                                <input type="checkbox" disabled ` + is_active + `>
                                <span class="custom-toggle-slider rounded-circle data-label-off="No" data-label-on="Yes"></span>
                            </label>`;
						return content;
					}
				},
                {
					orderable: true,
					render: function(data, type, row, meta) {
                        return (row.updated_at) ? row.updated_at : row.created_at;
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
                                        <a class="dropdown-item" href="#"
                                            data-toggle="modal"
                                            data-target="#modal-create-edit"
                                            data-mode="edit"
                                            data-id="` + row.id + `"
                                            data-code="` + row.code + `"
                                            data-name="` + row.name + `"
                                            data-qty="` + row.qty + `"
                                            data-status="` + row.is_active + `">Edit
                                        </a>
                                        <a class="dropdown-item" href="{{url('/satuan/delete/` + row.id + `')}}">Delete</a>
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

        $('#searchactive').on('input', function () {
            satuan_table.ajax.reload();
        });
    });
</script>
