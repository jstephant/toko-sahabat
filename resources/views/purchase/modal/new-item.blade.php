<div class="modal fade" id="modal-new-item" tabindex="-1" role="dialog" aria-labelledby="modal-new-item" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-sm" role="document">
		<div class="modal-content">
            <div class="modal-header justify-content-center bg-primary">
                <h5 id="title" class="modal-title text-white text-uppercase">New Item</h5>
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
                        <table width="100%">
                            <tr>
                                <input type="hidden" id="product_id" name="product_id">
                                <input type="hidden" id="mode" name="mode">
                                <td class="p-2" width="110px"><span class="col-form-label-sm text-uppercase display-4">Nama Barang</span></td>
                                <td class="p-2"><span id="nama_barang" class="col-form-label-sm text-uppercase"></span></td>
                            </tr>
                            <tr>
                                <td class="p-2"><span class="col-form-label-sm text-uppercase display-4">Satuan</span></td>
                                <td class="p-2">
                                    <select id="satuan" name="satuan" class="form-control" required>
                                        @if ($mode=='edit')
                                            @foreach ($satuan as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-2"><span class="col-form-label-sm text-uppercase display-4">Kuantitas</span></td>
                                <td class="p-2"><input type="number" id="qty_item" name="qty_item" class="form-control height text-right" autocomplete="off" value="1" min="1" required></td>
                            </tr>
                            <tr>
                                <td class="p-2"><span class="col-form-label-sm text-uppercase display-4">Harga</span></td>
                                <td class="p-2"><input type="number" id="price_item" name="price_item" class="form-control text-right" autocomplete="off" value="0" min="0" required></td>
                            </tr>
                            <tr>
                                <td class="p-2"><span class="col-form-label-sm text-uppercase display-4">Sub Total</span></td>
                                <td class="p-2"><input type="number" id="sub_total_item" name="sub_total_item" class="form-control text-right" autocomplete="off" value="0" readonly></td>
                            </tr>
                            <tr>
                                <td class="p-2"><span class="col-form-label-sm text-uppercase display-4">Discount</span></td>
                                <td class="p-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">%</span>
                                        </div>
                                        <input type="number" id="disc_pctg_item" name="disc_pctg_item" class="form-control text-right" style="width: 50%" autocomplete="off" value="0">
                                    </div>

                                    <div class="input-group mt-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="number" id="disc_rp_item" name="disc_rp_item" class="form-control text-right" autocomplete="off" value="0">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-2"><span class="col-form-label-sm text-uppercase display-4">Total</span></td>
                                <td class="p-2"><input type="number" id="total_item" name="total_item" class="form-control text-right" autocomplete="off" value="0" readonly></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-link btn-sm" data-dismiss="modal" id="btn_close">Tutup</button>
                <button type="button" class="btn btn-facebook btn-sm" id="btn_add_item" name="btn_add_item"></button>
            </div>
		</div>
	</div>
</div>
