<div class="modal fade" id="modal-create-edit" tabindex="-1" role="dialog" aria-labelledby="modal-create-edit" aria-hidden="true">
	<div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
		<div class="modal-content">
			<form class="form-basic needs-validation" novalidate method="post" role="form" action="{{ route('satuan.save.post')}}" enctype="multipart/form-data" id="form-role">
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
                        <div class="col-lg-6 col-md-6 col-xs-12">
                            <div class="form-group">
                                <label for="code" class="form-control-label">Kode *</label>
                                <input type="text" id="code" name="code" class="form-control" autocomplete="off" required autofocus>
                                <span class="mb-0 text-sm" id="check-code"></span>
                            </div>
                        </div>
                    </div>
					<div class="row">
                        <div class="col-lg-12 col-md-12 col-xs-12">
                            <div class="form-group">
                                <label for="name" class="form-control-label">Nama *</label>
                                <input type="text" id="name" name="name" class="form-control" autocomplete="off" required>
                                <span class="mb-0 text-sm" id="check-name"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6" id="status-data">
                            <div class="form-group">
                                <label for="status" class="form-control-label">Status *</label>
                                <select id="status" name="status" class="form-control" required style="height: 50px !important;">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
				</div>
				<div class="modal-footer justify-content-center">
                    <input type="hidden" id="satuan_id" name="satuan_id">
					<input type="hidden" id="mode" name="mode">
                    <button type="button" class="btn btn-link" data-dismiss="modal" id="btn_cancel">Cancel</button>
					<button type="submit" class="btn btn-facebook" id="save" name="save">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>
