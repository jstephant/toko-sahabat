@extends('layouts.app')

@section('content')
    <div class="header bg-primary pb-6"></div>
    <div class="container-fluid -fluid mt--7">
        <div class="row">
            <div class="col-12">
                <div class="card shadow mt-5 mb-5">
                    <form class="form-basic needs-validation" novalidate method="post" role="form" action="{{ route('pos.create.order')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-5 col-md-6 col-sm-6 col-xs-12">
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
                                                            <small>Rp <span class="money">{{ $cart->sub_total }}</span></small>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col mr-auto">
                                                            <small>Discount</small>
                                                        </div>
                                                        <div class="col-auto text-right">
                                                            <small>Rp <span class="money">{{ $cart->disc_price }}</span></small>
                                                        </div>
                                                    </div>
                                                    <hr class="mt-2 mb-2">
                                                    <div class="row">
                                                        <div class="col mr-auto">
                                                            <small class="font-weight-bold">Total Tagihan</small>
                                                        </div>
                                                        <div class="col-auto text-right">
                                                            <small class="font-weight-bold">Rp <span class="money">{{ $cart->total }}</span></small>
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
                            <input type="hidden" id="total" name="total" value="{{ $cart->total }}">
                            <a href="{{url('pos')}}" id="btn_back" name="action" class="btn btn-link btn-sm">Kembali</a>
                            <button type="submit" id="btn_save" name="action" class="btn btn-success btn-sm" value="bayar">Bayar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('pos.script.payment')
@endsection
