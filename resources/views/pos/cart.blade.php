@extends('layouts.app')

@section('content')
    <div class="header bg-primary pb-6"></div>
    <div class="container-fluid -fluid mt--7">
        <div class="row">
            <div class="col-12">
                <div class="card shadow mt-5 mb-5">
                    <form class="form-basic needs-validation" novalidate method="post" role="form" action="{{ route('pos.update-cart')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                    <div class="row text-right">
                                        <div class="col-12 text-md-left">
                                            <h3 class="text-warning">Rp <span id="total_view" class="money">0</span></h3>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 align-items-center">
                                            <span id="errorMessage" class="text-center"></span>
                                            <div class="row" id="detail_product"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
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

                            </div>
                        </div>
                        <div class="card-footer text-lg-left text-md-left text-sm-center text-center">
                            <input type="hidden" id="cart_id" name="cart_id" value="{{ $cart->id }}">
                            <a href="{{url('pos')}}" id="btn_back" name="action" class="btn btn-link btn-sm">Kembali</a>
                            <button type="submit" id="btn_save" name="action" class="btn btn-success btn-sm" value="beli">Beli</button>
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
