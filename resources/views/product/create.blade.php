@extends('layouts.app')

@section('content')
    <div class="header bg-primary pb-6"></div>
    <div class="container-fluid -fluid mt--7">
        <div class="row">
            <div class="col-12">
                <div class="card shadow mt-5 mb-5">
                    <form class="form-basic needs-validation" novalidate method="post" role="form" action="{{ route('product.create.post') }}" enctype="multipart/form-data" id="form-create">
                        @csrf
                        <div class="card-body">
                            <div class="pl-lg-2">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="code" class="form-control-label">Kode Barang *</label>
                                                    <input type="text" id="code" name="code" class="form-control" autocomplete="off" value="{{ $code }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="name" class="form-control-label">Nama Barang *</label>
                                                    <input type="text" id="name" name="name" class="form-control" autocomplete="off" value="{{ old('name') }}" required>
                                                    @if ($errors->has('name'))
                                                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="sub_category" class="form-control-label">Sub Kategori *</label>
                                                    <select id="sub_category" name="sub_category[]" class="form-control" data-toggle="select" data-live-search="true" multiple required>
                                                        <option value=""></option>
                                                        @foreach ($sub_category as $item )
                                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('sub_category'))
                                                        <div class="invalid-feedback">{{ $errors->first('sub_category') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="hpp" class="form-control-label">HPP</label>
                                                    <input type="number" id="hpp" name="hpp" class="form-control" autocomplete="off" value="{{ old('hpp') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="barcode" class="form-control-label">Barcode</label>
                                                    <input type="text" id="barcode" name="barcode" class="form-control" autocomplete="off" value="{{ $barcode }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="custom-file">
                                                    <input type="file" id="product_image" name="product_image" class="custom-file-input" lang="en">
                                                    <label class="custom-file-label" for="product_image">Select image</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <div class="d-flex">
                                <a href="{{url('barang')}}" id="btn_cancel" name="action" class="btn btn-link">Cancel</a>
                                <button type="submit" id="btn_save" name="action" class="btn btn-facebook" value="save">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
