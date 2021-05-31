@extends('layouts.app')

@section('content')
    <div class="header bg-primary pb-6"></div>
    <div class="container-fluid -fluid mt--7">
        <div class="row">
            <div class="col-12">
                <div class="card shadow mt-5 mb-5">
                    <form class="form-basic needs-validation" novalidate method="post" role="form" action="{{ route('customer.create.post') }}" enctype="multipart/form-data" id="form-create">
                        @csrf
                        <div class="card-body">
                            <div class="pl-lg-2">
                                <div class="row">
                                    <div class="col-lg-5 col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="name" class="col-form-label-sm text-uppercase display-4">Nama *</label>
                                            <input type="text" id="name" name="name" class="form-control @error('name') 'is-invalid' @enderror" autocomplete="off" value="{{ old('name') }}" required autofocus>
                                            @error('name')
                                                <div class="alert alert-danger p-2 mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5 col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="phone" class="col-form-label-sm text-uppercase display-4">Mobile Phone</label>
                                            <input type="tel" id="phone" name="phone" class="form-control @error('phone') 'is-invalid' @enderror" autocomplete="off" value="{{ old('phone') }}">
                                            @error('phone')
                                                <div class="alert alert-danger p-2 mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5 col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="address" class="col-form-label-sm text-uppercase display-4">Alamat</label>
                                            <textarea class="form-control" id="address" name="address" rows="5">{{old('address')}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <div class="d-flex">
                                <a href="{{url('pelanggan')}}" id="btn_cancel" name="action" class="btn btn-link">Batal</a>
                                <button type="submit" id="btn_save" name="action" class="btn btn-facebook" value="save">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
