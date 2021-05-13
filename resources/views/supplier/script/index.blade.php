<script>
    $(document).ready(function() {
        var supplier_table = $('#supplier_table').DataTable( {
			processing: true,
            serverSide: true,
            responsive: false,
            pageLength: 10,
            ajax: {
                type: "GET",
				url: APP_URL + '/supplier/list',
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
					orderable: true,
					render: function(data, type, row, meta) {
						return (row.mobile_phone) ? row.mobile_phone : '-';
					}
				},
                {
					orderable: true,
					render: function(data, type, row, meta) {
						return (row.email) ? row.email : '-';
					}
				},
				{
					orderable: true,
					render: function(data, type, row, meta) {
                        return (row.address) ? row.address : '-';
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
                                <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                            </label>`;
						return content;
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
                                        <a class="dropdown-item" href="{{url('/supplier/edit/` + row.id + `')}}">Edit</a>
                                        <a class="dropdown-item" href="{{url('/supplier/delete/` + row.id + `')}}">Delete</a>
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
            supplier_table.ajax.reload()
        });
    });
</script>
