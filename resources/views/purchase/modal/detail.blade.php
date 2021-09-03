<div class="modal fade" id="modal-detail-item" tabindex="-1" role="dialog" aria-labelledby="modal-detail-item" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-sm" role="document">
		<div class="modal-content">
            <div class="modal-header justify-content-center bg-primary">
                <h5 id="title" class="modal-title text-white text-uppercase">Input Detail Barang</h5>
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
                        <div class="nav-wrapper">
                            <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-detail-beli" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-detail-barang-tab" data-toggle="tab" href="#tabs-detail-barang" role="tab" aria-controls="tabs-detail-barang" aria-selected="true"><i class="ni ni-cloud-upload-96 mr-2"></i>Detail Barang</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-sm-3 mb-md-0" id="tabs-detail-harga-jual-tab" data-toggle="tab" href="#tabs-detail-harga-jual" role="tab" aria-controls="tabs-detail-harga-jual" aria-selected="false"><i class="ni ni-bell-55 mr-2"></i>Detail Harga Jual</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="tab-content" id="tab-beli">
                                    <div class="tab-pane fade show active" id="tabs-detail-barang" role="tabpanel" aria-labelledby="tabs-detail-barang-tab">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="product" class="col-form-label-sm text-uppercase display-4">Pilih Barang</label>
                                                    <select id="product" name="product" class="form-control"></select>
                                                    @error('product')
                                                        <div class="alert alert-danger p-2 mt-2">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label for="qty_item" class="col-form-label-sm text-uppercase display-4">Kuantitas</label>
                                                    <input type="number" id="qty_item" name="qty_item" class="form-control height text-right" autocomplete="off" value="1" min="1" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label for="satuan" class="col-form-label-sm text-uppercase display-4">Pilih Satuan</label>
                                                    <select id="satuan" name="satuan" class="form-control" required></select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label for="price_item" class="col-form-label-sm text-uppercase display-4">Harga Beli</label>
                                                    <input type="number" id="price_item" name="price_item" class="form-control text-right" autocomplete="off" value="0" min="0" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label for="disc_price_item" class="col-form-label-sm text-uppercase display-4">Discount (Rp)</label>
                                                    <input type="number" id="disc_price_item" name="disc_price_item" class="form-control text-right" autocomplete="off" value="0" min="0" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="total_item" class="col-form-label-sm text-uppercase display-4">Total</label>
                                                    <input type="number" id="total_item" name="total_item" class="form-control text-right" autocomplete="off" value="0" min="0" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="hpp" class="col-form-label-sm text-uppercase display-4">Harga Pokok Pembelian (HPP)</label>
                                                    <input type="number" id="hpp" name="hpp" class="form-control text-right" autocomplete="off" value="0" min="0" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tabs-detail-harga-jual" role="tabpanel" aria-labelledby="tabs-detail-harga-jual-tab">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-xs-12">
                                                <div class="form-group">
                                                    <label for="product_satuan" class="col-form-label-sm text-uppercase display-4">Satuan Harga Jual *</label>
                                                    <select id="product_satuan" name="product_satuan[]" class="form-control @error('product_satuan') 'is-invalid' @enderror" multiple required>
                                                        <option value=""></option>
                                                        {{-- @foreach ($satuan as $item )
                                                            <option value="{{ $item->id }}" {{ in_array($item->id, old('product_satuan', [])) ? 'selected' : '' }}>{{ $item->name . ' ('.$item->code.')' }}</option>
                                                        @endforeach --}}
                                                    </select>
                                                    @error('product_satuan')
                                                        <div class="alert alert-danger p-2 mt-2">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card shadow">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label for="active_at" class="col-form-label-sm text-uppercase display-4">Tgl. Berlaku *</label>
                                                                    <input type="text" class="form-control flatpickr flatpickr-input @error('active_at') 'is-invalid' @enderror" id="active_at" name="active_at" value="{{ old('active_at') }}" required>
                                                                    @error('active_at')
                                                                        <div class="alert alert-danger p-2 mt-2">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered align-items-center" id="detail_price_list" width="100%">
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col">Satuan</th>
                                                                                <th scope="col">Harga</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @if(!is_null(old('product_satuan')))
                                                                                @foreach (old('product_satuan') as $i => $item)
                                                                                    <tr>
                                                                                        <td><span class="x1">{{ old('satuan_name.'.$i) }}</span></td>
                                                                                        <td>
                                                                                            <div class="form-group">
                                                                                                <input type="number" name="product_price_list[]" class="form-control price_list @error('product_price_list.'.$i) 'is-invalid' @enderror" autocomplete="off" value="{{ old('product_price_list.'.$i) }}" required>
                                                                                                @error('product_price_list.'.$i) <div class="alert alert-danger p-2 mt-2">{{ $message }}</div> @enderror
                                                                                            </div>
                                                                                        </td>
                                                                                        <input type="hidden" name="satuan_id[]" class="satuan" value="{{ old('satuan_id.'.$i) }}">
                                                                                        <input type="hidden" name="satuan_name[]" class="satuan" value="{{ old('satuan_name.'.$i) }}">
                                                                                    </tr>
                                                                                @endforeach

                                                                                <input type="hidden" id="idx_price_list" value="{{ $i+1 }}">
                                                                            @else
                                                                                <input type="hidden" id="idx_price_list" value="0">
                                                                            @endif
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-link btn-sm" data-dismiss="modal" id="btn_close">Tutup</button>
                <button type="button" class="btn btn-facebook btn-sm" id="btn_add_item" name="btn_add_item">Add Item</button>
            </div>
		</div>
	</div>
</div>
