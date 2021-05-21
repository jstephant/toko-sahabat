<script>
    $(document).ready(function() {
        var role_table = $('#role_table').DataTable( {
			processing: true,
            serverSide: true,
            responsive: false,
            pageLength: 10,
            ajax: {
                type: "GET",
				url: APP_URL + '/role/list',
				data: function(d) {
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
                        return row.name;
					}
				},
                {
					orderable: false,
					render: function(data, type, row, meta) {
                        if(row.is_active==1)
                            var content = `<small class="badge badge-success badge-md">Aktif</small>`;
                        else var content = `<small class="badge badge-danger badge-md">Tidak Aktif</small>`;
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
                        var link_edit = "";
                        var link_inactive = "";
                        if(row.restricted==0)
                        {
                            link_edit = `href="{{url('/role/edit/` + row.id + `')}}"`;
                        } else {
                            link_edit = `href="#"`;
                        }
                        var delete_link = "";
                        if(row.is_active==1)
                        {
                            delete_link = `<a class="dropdown-item text-danger" href="#"
                                                data-toggle="modal"
                                                data-target="#modal-confirm-delete"
                                                data-id="` + row.id + `"
                                                data-link="/role/delete">Delete
                                            </a>`;
                        }
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
                                            data-name="` + row.name + `"
                                            data-status="` + row.is_active + `">Edit
                                        </a>
                                        ` + delete_link + `
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
            role_table.ajax.reload();
        })
    });
</script>
