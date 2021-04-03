@extends('layouts.app')

@section('content')
    <div class="header bg-primary pb-6"></div>
    <div class="container-fluid -fluid mt--7">
        <div class="row">
            <div class="col-12">
                <div class="card shadow mt-5 mb-5">
                    <form class="form-basic needs-validation" novalidate method="post" role="form" action="{{ route('customer.edit.post') }}" enctype="multipart/form-data" id="form-create-lead">
                        @csrf
                        <div class="card-body">
                            <div class="pl-lg-2">
                                <div class="row">
                                    <div class="col-lg-5 col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="name" class="form-control-label">Nama *</label>
                                            <input type="text" id="name" name="name" class="form-control" autocomplete="off" value="{{ $customer->name }}" required autofocus>
                                            @if ($errors->has('name'))
                                                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5 col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="phone" class="form-control-label">Mobile Phone</label>
                                            <input type="tel" id="phone" name="phone" class="form-control" autocomplete="off" value="{{ $customer->mobile_phone }}">
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5 col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="address" class="form-control-label">Alamat</label>
                                            <textarea class="form-control" id="address" name="address" rows="5">{{ $customer->address }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4" id="status-data">
                                        <div class="form-group">
                                            <label for="status" class="form-control-label">Status *</label>
                                            <select id="status" name="status" class="" required>
                                                <option value="1" {{ ($customer->is_active==1) ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ ($customer->is_active==0) ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <div class="d-flex">
                                <input type="hidden" id="customer_id" name="customer_id" value="{{ $customer->id }}">
                                <a href="{{url('pelanggan')}}" id="btn_cancel" name="action" class="btn btn-link">Cancel</a>
                                <button type="submit" id="btn_save" name="action" class="btn btn-facebook" value="save">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('customer.script.edit')
@endsection
