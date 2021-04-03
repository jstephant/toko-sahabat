<div class="modal fade" id="modal-sub-create-edit" tabindex="-1" role="dialog" aria-labelledby="modal-sub-create-edit" aria-hidden="true">
	<div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
		<div class="modal-content">
			<form class="form-basic needs-validation" novalidate method="post" role="form" action="{{ route('subcategory.save.post')}}" enctype="multipart/form-data" id="form-role">
				@csrf
				<div class="modal-header justify-content-center bg-primary">
					<h5 id="title" class="modal-title text-white text-uppercase"></h5>
				</div>
				<div class="modal-body justify-content-center">
					<div id="data_loader" class="row">
						<div class="col-md-12">
							<div class="justify-content-center text-center">
								<div class="spinner-border text-primary " role="status" ></div>
							</div>
						</div>
					</div>
					<div class="row">
                        <div class="col-lg-12 col-md-12 col-xs-12">
                            <div class="form-group">
                                <label for="sub_name" class="form-control-label">Nama *</label>
                                <input type="text" id="sub_name" name="sub_name" class="form-control" autocomplete="off" required autofocus>
                                <span class="mb-0 text-sm" id="check-sub-name"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="category2" class="form-control-label">Category *</label>
                                <select id="category2" name="category2" class="form-control" data-toggle="select" required></select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6" id="sub-status-data">
                            <div class="form-group">
                                <label for="sub_status" class="form-control-label">Status *</label>
                                <select id="sub_status" name="sub_status" class="form-control" data-toggle="select" required>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
				</div>
				<div class="modal-footer justify-content-center">
                    <input type="hidden" id="sub_category_id" name="sub_category_id">
					<input type="hidden" id="sub_mode" name="sub_mode">
                    <button type="button" class="btn btn-link" data-dismiss="modal" id="btn_cancel">Cancel</button>
					<button type="submit" class="btn btn-facebook" id="save" name="save">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>
