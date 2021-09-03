@extends('layouts.app')

@section('content')
    <div class="header bg-primary pb-6"></div>
    <div class="container-fluid -fluid mt--7">
        <div class="row">
            <div class="col-12">
                <div class="card shadow mt-5 mb-5">
                    <form class="form-basic needs-validation" novalidate method="post" role="form" action="{{ route('purchase.create.post') }}" enctype="multipart/form-data" id="form-create">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="code" class="col-form-label-sm text-uppercase display-4">No. Pembelian *</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">PCH</span>
                                                    </div>
                                                    <input type="text" id="code" name="code" class="form-control" autocomplete="off" value="{{ $code }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="purchase_date" class="col-form-label-sm text-uppercase display-4">Tgl. Pembelian *</label>
                                                <input type="text" class="form-control flatpickr flatpickr-input @error('purchase_date') 'is-invalid' @enderror" id="purchase_date" name="purchase_date" value="{{ old('purchase_date') }}" required>
                                                @error('purchase_date')
                                                    <div class="alert alert-danger p-2 mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="supplier" class="col-form-label-sm text-uppercase display-4">Supplier *</label>
                                                <select id="supplier" name="supplier" class="form-control @error('supplier') 'is-invalid' @enderror" data-toggle="select" required>
                                                    <option value=""></option>
                                                    @foreach ($supplier as $item)
                                                        <option value="{{ $item->id }}" {{ ($item->id == old('supplier')) ? 'selected' : '' }}>{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('supplier')
                                                    <div class="alert alert-danger p-2 mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="notes" class="col-form-label-sm text-uppercase display-4">Notes</label>
                                                <textarea class="form-control" id="notes" name="notes" rows="5"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <a href="#" id="btn_detail_beli" name="btn_detail_beli" class="btn btn-facebook btn-block" data-toggle="modal" data-target="#modal-detail-item">Input Detail Pembelian</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="browse_product" class="col-form-label-sm text-uppercase display-4">Detail Pembelian</label>
                                                <select id="browse_product" name="browse_product" class="form-control"></select>
                                                @error('products')
                                                    <div class="alert alert-danger p-2 mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="table-responsive">
                                                <table class="table table-striped display align-items-center" id="detail_purchase" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Nama Barang</th>
                                                            <th scope="col">Qty</th>
                                                            <th scope="col">Harga</th>
                                                            <th scope="col">Sub Total</th>
                                                            <th scope="col">Discount</th>
                                                            <th scope="col">Total</th>
                                                            <th scope="col"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col text-right">
                                            <span class="col-form-label-sm text-uppercase display-4">Sub Total :</span>
                                        </div>
                                        <div class="col-3 mr-auto text-right">
                                            <span class="col-form-label-sm text-uppercase display-4 text-right" id="sub_total_view">0</span>
                                            <input type="hidden" id="sub_total_all" name="sub_total_all" value="0">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-right">
                                            <span class="col-form-label-sm text-uppercase display-4">Discount :</span>
                                        </div>
                                        <div class="col-3 mr-auto text-right">
                                            <span class="col-form-label-sm text-uppercase display-4 text-right" id="discount_view">0</span>
                                            <input type="hidden" id="discount_all" name="discount_all" value="0">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-right">
                                            <span class="col-form-label-sm text-uppercase display-4">Grand Total :</span>
                                        </div>
                                        <div class="col-3 mr-auto text-right">
                                            <span class="col-form-label-sm text-uppercase display-4 text-right" id="total_view">0</span>
                                            <input type="hidden" id="total_all" name="total_all" value="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-lg-left text-md-left text-sm-center text-center">
                            <a href="{{url('beli')}}" id="btn_cancel" name="action" class="btn btn-link btn-sm">Batal</a>
                            <button type="submit" id="btn_save" name="action" class="btn btn-facebook btn-sm" value="save">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('purchase.script.create')
    @include('purchase.modal.detail')
    {{-- @include('product.modal.item-transaction')
    @include('product.script.item-transaction') --}}
@endsection
