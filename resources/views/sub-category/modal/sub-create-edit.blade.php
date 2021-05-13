<div class="modal fade" id="modal-sub-create-edit" tabindex="-1" role="dialog" aria-labelledby="modal-sub-create-edit" aria-hidden="true">
	<div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
		<div class="modal-content">
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
                            <label for="sub_name" class="col-form-label-sm text-uppercase display-4">Nama *</label>
                            <input type="text" id="sub_name" name="sub_name" class="form-control" autocomplete="off" required autofocus>
                            <span class="text-danger text-sm" id="subnameError"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="category2" class="col-form-label-sm text-uppercase display-4">Kategori *</label>
                            <select id="category2" name="category2" class="form-control" data-toggle="select" required></select>
                            <span class="text-danger text-sm" id="categoryError"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6" id="sub-status-data">
                        <div class="form-group">
                            <label for="sub_status" class="col-form-label-sm text-uppercase display-4">Status *</label>
                            <select id="sub_status" name="sub_status" class="form-control" data-toggle="select" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            <span class="text-danger text-sm" id="substatusError"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <input type="hidden" id="sub_category_id" name="sub_category_id">
                <input type="hidden" id="sub_mode" name="sub_mode">
                <button type="button" class="btn btn-link" data-dismiss="modal" id="btn_cancel">Batal</button>
                <button type="button" class="btn btn-facebook" id="save" name="save" onclick="storeDataSubCategory()">Simpan</button>
            </div>
		</div>
	</div>
</div>
