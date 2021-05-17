<div class="modal fade" id="modal-create-edit" tabindex="-1" role="dialog" aria-labelledby="modal-create-edit" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-sm" role="document">
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
                <div class="row alert_error">
                    <div class="col-md-12">
                        @include('alert.alert-modal')
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-xs-12">
                        <div class="form-group">
                            <label for="code" class="col-form-label-sm text-uppercase display-4">Kode *</label>
                            <input type="text" id="code" name="code" class="form-control" autocomplete="off" required autofocus>
                            <span class="text-danger text-sm" id="codeError"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <div class="form-group">
                            <label for="name" class="col-form-label-sm text-uppercase display-4">Nama *</label>
                            <input type="text" id="name" name="name" class="form-control" autocomplete="off" required>
                            <span class="text-danger text-sm" id="nameError"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-xs-12">
                        <div class="form-group">
                            <label for="qty" class="col-form-label-sm text-uppercase display-4">Kuantitas Std (pcs)*</label>
                            <input type="number" id="qty" name="qty" class="form-control" autocomplete="off" value="1" min="1" required>
                            <span class="text-danger text-sm" id="qtyError"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6" id="status-data">
                        <div class="form-group">
                            <label for="status" class="col-form-label-sm text-uppercase display-4">Status *</label>
                            <select id="status" name="status" class="form-control" required style="height: 50px !important;">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            <span class="text-danger text-sm" id="statusError"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <input type="hidden" id="satuan_id" name="satuan_id">
                <input type="hidden" id="mode" name="mode">
                <button type="button" class="btn btn-link btn-sm" data-dismiss="modal" id="btn_cancel">Batal</button>
                <button type="button" class="btn btn-facebook btn-sm" id="save" name="save" onclick="storeData()">Simpan</button>
            </div>
		</div>
	</div>
</div>
