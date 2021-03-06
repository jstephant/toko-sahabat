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
						var content = ``;
						content += `<div class="media align-items-center">`
						content += `<a href="#" class="avatar avatar-xl rounded bg-white">`
						content += `<img alt="..." src="` + row.thumbnail + `" style="width: 70px; height:70px">`
						content += `</a>`
						content += `<div class="media-body">`
						content += `<span class="text-sm mb-0 ml-2">` + row.code + `</span><br>`
                        content += `<span class="h5 mb-0 ml-2 text-uppercase">` + row.name + `</span><br>`
                        content += `<span class="mb-0 ml-2 badge badge-pill badge-md badge-primary">` + row.product_category.name + `</span>`
						content += `</div>`;
						content += `</div>`;
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
                    orderable: false,
					render: function(data, type, row, meta) {
                        var content = '';
                        if(row.product_satuan!=null)
                        {
                            $.each(row.product_satuan, function (index, value) {
                                 content += `<span class="badge badge-default mr-1">`+ value.satuan.name + `</span>`
                            });
                        }
                        return content;
					}
                },
                {
					orderable: true,
					render: function(data, type, row, meta) {
                        var content = `<div class="form-group m-0">{!! DNS1D::getBarcodeHTML(`+ row.barcode + `, 'C39') !!}</div>`;
                            content += `<span>` + row.barcode + `</span>`;
                        return content;
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
                        var delete_link = "";
                        if(row.is_active==1)
                        {
                            delete_link = `<a class="dropdown-item text-danger" href="#"
                                                data-toggle="modal"
                                                data-target="#modal-confirm-delete"
                                                data-id="` + row.id + `"
                                                data-link="/barang/delete">Delete
                                            </a>`;
                        }
						var content = `
							<ul class="navbar-nav ml-lg-auto">
								<li class="nav-item dropdown">
									<a class="text-gray" href="#" id="navbar-primary_dropdown_1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
									<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-primary_dropdown_1">
                                        <a class="dropdown-item" href="{{url('/barang/edit/` + row.id + `')}}">Edit</a>
                                        ` + delete_link + `
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
