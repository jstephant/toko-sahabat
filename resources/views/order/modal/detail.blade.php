<div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="modal-detail" aria-hidden="true">
	<div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
            <div class="modal-header justify-content-center bg-primary">
                <h5 id="title" class="modal-title text-white text-uppercase"> Order Detail</h5>
            </div>
            <div class="modal-body justify-content-center pb-0">
                <div class="row form-group my-2">
                    <small class="py-0 col-md-3">No Order</small>
                    <div class="col-md-9">
                        <small><span id="order_code" class="py-0">#1234567</span></small>
                    </div>
                </div>
                <div class="row form-group my-2">
                    <small class="py-0 col-md-3">Tanggal</small>
                    <div class="col-md-9">
                        <small><span id="order_date" class="py-0">22-06-2021 11:00:00</span></small>
                    </div>
                </div>
                <div class="row form-group my-2">
                    <small class="py-0 col-md-3">Nama Pelanggan</small>
                    <div class="col-md-9">
                        <small><span id="customer_name" class="py-0"></span></small>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-striped display align-items-center" id="detail_order" width="100%">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Nama Barang</th>
                                        <th scope="col">Satuan</th>
                                        <th scope="col" class="text-right">Qty</th>
                                        <th scope="col" class="text-right">Price</th>
                                        <th scope="col" class="text-right">Sub Total</th>
                                        <th scope="col" class="text-right">Discount</th>
                                        <th scope="col" class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <hr class="my-0">
                <div class="row form-group my-2">
                    <div class="col-7">

                    </div>
                    <div class="col-5">
                        <div class="row">
                            <div class="col mr-auto">
                                <small class="py-0">Sub Total</small>
                            </div>
                            <div class="col-auto text-right">
                                <small>Rp <span id="sub_total" class="py-0"></span></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mr-auto">
                                <small class="py-0">Discount</small>
                            </div>
                            <div class="col-auto text-right">
                                <small>Rp <span id="discount" class="py-0"></span></small>
                            </div>
                        </div>
                        <hr class="mt-2 mb-2">
                        <div class="row">
                            <div class="col mr-auto">
                                <small class="py-0 font-weight-bold">Total Tagihan</small>
                            </div>
                            <div class="col-auto text-right">
                                <small class="font-weight-bold">Rp <span id="total" class="py-0"></span></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mr-auto">
                                <small class="py-0">Total Bayar</small>
                            </div>
                            <div class="col-auto text-right">
                                <small>Rp <span id="total_pay" class="py-0"></span></small>
                            </div>
                        </div>
                        <hr class="mt-2 mb-2">
                        <div class="row">
                            <div class="col mr-auto">
                                <small class="py-0">Kembalian</small>
                            </div>
                            <div class="col-auto text-right">
                                <small>Rp <span id="total_change" class="py-0"></span></small>
                            </div>
                        </div>
                        <hr class="mt-2 mb-2">
                        <div class="row">
                            <div class="col mr-auto">
                                <small class="py-0">Metode Pembayaran</small>
                            </div>
                            <div class="col-auto text-right">
                                <small><span id="payment_method" class="py-0"></span></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mr-auto">
                                <small class="py-0">Status</small>
                            </div>
                            <div class="col-auto text-right">
                                <span id="status_bayar" class="badge badge-default"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-link btn-sm" data-dismiss="modal" id="btn_close">Tutup</button>
            </div>
		</div>
	</div>
</div>
