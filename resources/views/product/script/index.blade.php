<script>
    $(document).ready(function() {
        var product_table = $('#product_table').DataTable( {
			processing: true,
            serverSide: true,
            responsive: false,
            pageLength: 10,
            ajax: {
                type: "GET",
				url: APP_URL + '/barang/list',
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
                    render: function (data, type, row, meta) {
                        return row.image_url
                    }
                },
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
                        var content = '';
                        if(row.product_sub_category!=null)
                        {
                            $.each(row.product_sub_category, function (index, value) {
                                 content += `<span class="badge badge-default">`+ value['sub_category']['name'] + `</span>`
                            });
                        }
                        return content;
					}
				},
                {
					orderable: true,
					render: function(data, type, row, meta) {
                        return row.hpp
					}
				},
                {
					orderable: true,
					render: function(data, type, row, meta) {
                        return row.barcode
					}
				},
                {
					orderable: true,
					render: function(data, type, row, meta) {
                        var is_active = "";
                        if(row.is_active==1) is_active = "checked";
                        var content = `
                            <label class="custom-toggle custom-toggle-success">
                                <input type="checkbox" disabled ` + is_active + `>
                                <span class="custom-toggle-slider rounded-circle"></span>
                            </label>`;
						return content;
					}
				},
                {
					orderable: true,
					render: function(data, type, row, meta) {
                        return row.created_at
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
                                        <a class="dropdown-item" href="{{url('/barang/edit/` + row.id + `')}}">Edit</a>
                                        <a class="dropdown-item" href="{{url('/barang/delete/` + row.id + `')}}">Delete</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{url('/barang/set-hpp/` + row.id + `')}}">Set HPP</a>
                                        <a class="dropdown-item" href="{{url('/barang/set-pricelist/` + row.id + `')}}">Set Price List</a>
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
            product_table.ajax.reload()
        });
    });
</script>
