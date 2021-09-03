@extends('layouts.app')

@section('content')
    <div class="header bg-primary pb-6"></div>
    <div class="container-fluid -fluid mt--7">
        <div class="row">
            <div class="col-12">
                <div class="card shadow mt-5 mb-0">
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-12 text-md-left">
                                <h3 class="text-warning m-0">Rp <span id="total_view" class="money">0</span></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card shadow mt-2 mb-5">
                    <form class="form-basic needs-validation" novalidate method="post" role="form" action="{{ route('pos.update-cart')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                                    <div class="row">
                                        <div class="col-12 align-items-center">
                                            <span id="errorMessage" class="text-center"></span>
                                            <div class="row" id="detail_product"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="customer" class="col-form-label-sm text-uppercase display-4">Pilih Pelanggan</label>
                                                <select id="customer" name="customer" class="form-control @error('customer') 'is-invalid' @enderror" data-toggle="select">
                                                    <option value=""></option>
                                                    @foreach ($customer as $item)
                                                        <option value="{{ $item->id }}" {{ ($item->id == old('customer')) ? 'selected' : '' }}>{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="customer_name" class="col-form-label-sm text-uppercase display-4">Nama Pelanggan</label>
                                                <input type="text" id="customer_name" name="customer_name" class="form-control @error('customer_name') 'is-invalid' @enderror" autocomplete="off" value="{{ (old('customer_name')) ? old('customer_name') : (($customer_name) ? $customer_name : (($cart->customer) ? $cart->customer->name : '')) }}">
                                                @error('customer_name')
                                                    <div class="alert alert-danger p-2 mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="customer_phone" class="col-form-label-sm text-uppercase display-4">No. Telp</label>
                                                <input type="tel" id="customer_phone" name="customer_phone" class="form-control @error('customer_phone') 'is-invalid' @enderror" autocomplete="off" value="{{ (old('customer_phone')) ? old('customer_phone') : (($customer_phone) ? $customer_phone : (($cart->customer) ? $cart->customer->mobile_phone : '')) }}">
                                                @error('customer_phone')
                                                    <div class="alert alert-danger p-2 mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="notes" class="col-form-label-sm text-uppercase display-4">Notes</label>
                                                <textarea class="form-control" id="notes" name="notes" rows="2">{{ $cart->notes }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card mb-2">
                                                <div class="card-body p-3">
                                                    <div class="row">
                                                        <div class="col mr-auto">
                                                            <small>Metode Pembayaran</small>
                                                        </div>
                                                        <div class="col-auto text-right">
                                                            <small>{{ $payment_method->name }}</small>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="payment_type_id" name="payment_type_id" class="form-control" autocomplete="off" value="{{ $payment_method->id }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card mb-2">
                                                <div class="card-body p-3">
                                                    <div class="row">
                                                        <div class="col mr-auto">
                                                            <small>Sub Total</small>
                                                        </div>
                                                        <div class="col-auto text-right">
                                                            <small>Rp <span class="money" id="payment_sub_total">{{ $cart->sub_total }}</span></small>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col mr-auto">
                                                            <small>Discount</small>
                                                        </div>
                                                        <div class="col-auto text-right">
                                                            <small>Rp <span class="money" id="payment_disc_price">{{ $cart->disc_price }}</span></small>
                                                        </div>
                                                    </div>
                                                    <hr class="mt-2 mb-2">
                                                    <div class="row">
                                                        <div class="col mr-auto">
                                                            <small class="font-weight-bold">Total Tagihan</small>
                                                        </div>
                                                        <div class="col-auto text-right">
                                                            <small class="font-weight-bold">Rp <span class="money" id="payment_total">{{ $cart->total }}</span></small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card mb-2">
                                                <div class="card-body p-3">
                                                    <div class="row align-items-center">
                                                        <div class="col mr-auto">
                                                            <small class="font-weight-bold">Total Bayar</small>
                                                        </div>
                                                        <div class="col-auto text-right">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">Rp</span>
                                                                </div>
                                                                <input type="text" id="total_pay" name="total_pay" class="money form-control text-right" style="width: 100px" autocomplete="off" autofocus value="{{ $cart->total }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col mr-auto">
                                                            <small>Total Kembalian</small>
                                                        </div>
                                                        <div class="col-auto text-right">
                                                            <small id="change">Rp <span class="money" id="change_text">0</span></small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card mb-2">
                                                <div class="card-body p-3">
                                                    <div class="row align-items-center">
                                                        <div class="col mr-auto">
                                                            <small>Print Struk</small>
                                                        </div>
                                                        <div class="col-auto text-right">
                                                            <label class="custom-toggle custom-toggle-success">
                                                                <input type="checkbox" id="is_print_struk" name="is_print_struk" checked>
                                                                <span class="custom-toggle-slider rounded-circle"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer text-lg-left text-md-left text-sm-center text-center">
                            <input type="hidden" id="cart_id" name="cart_id" value="{{ $cart->id }}">
                            <a href="{{url('pos')}}" id="btn_back" name="action" class="btn btn-link btn-sm">Kembali</a>
                            <button type="submit" id="btn_save" name="action" class="btn btn-success btn-sm" value="beli">Bayar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('pos.script.cart')
    @include('pos.modal.satuan')
    @include('pos.modal.discount')
@endsection
