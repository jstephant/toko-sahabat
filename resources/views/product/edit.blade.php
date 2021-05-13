@extends('layouts.app')

@section('content')
    <div class="header bg-primary pb-6"></div>
    <div class="container-fluid -fluid mt--7">
        <div class="row">
            <div class="col-12">
                <div class="card shadow mt-5 mb-5">
                    <form class="form-basic needs-validation" novalidate method="post" role="form" action="{{ route('product.edit.post') }}" enctype="multipart/form-data" id="form-create-lead">
                        @csrf
                        <div class="card-body">
                            <div class="pl-lg-2">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label for="code" class="col-form-label-sm text-uppercase display-4">Kode Barang *</label>
                                                    <input type="text" id="code" name="code" class="form-control" autocomplete="off" value="{{ $product->code }}" readonly>
                                                    @if ($errors->has('code'))
                                                        <div class="invalid-feedback">{{ $errors->first('code') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-xs-12">
                                                <div class="form-group">
                                                    <label for="name" class="col-form-label-sm text-uppercase display-4">Nama Barang *</label>
                                                    <input type="text" id="name" name="name" class="form-control @error('name') 'is-invalid @enderror" autocomplete="off" value="{{ $product->name }}" required autofocus>
                                                    @error('name')
                                                        <div class="alert alert-danger p-2 mt-2">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label for="sub_category" class="col-form-label-sm text-uppercase display-4">Sub Kategori *</label>
                                                    <select id="sub_category" name="sub_category" class="form-control @error('sub_category') 'is-invalid @enderror" required>
                                                        <option value=""></option>
                                                        @foreach ($sub_category as $item)
                                                            <option value="{{ $item->id }}" {{ ($item->id==$product->sub_category_id) ? 'selected' : '' }}>{{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('sub_category')
                                                        <div class="alert alert-danger p-2 mt-2">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <div class="form-group">
                                                    <label for="hpp" class="col-form-label-sm text-uppercase display-4">HPP</label>
                                                    <input type="number" id="hpp" name="hpp" class="form-control" autocomplete="off" value="{{ $product->hpp }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label for="satuan" class="col-form-label-sm text-uppercase display-4">Satuan *</label>
                                                    <select id="satuan" name="satuan[]" class="form-control @error('satuan') 'is-invalid @enderror" multiple required>
                                                        <option value=""></option>
                                                        @foreach ($satuan as $item )
                                                            {{ $selected = '' }}
                                                            @if ($product->product_satuan)
                                                                @foreach ($product->product_satuan as $item2)
                                                                    {{ $selected = '' }}
                                                                    @if ($item->id==$item2->id)
                                                                        {{ $selected = 'selected' }}
                                                                        @break
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                            <option value="{{ $item->id }}" {{ $selected }}>{{ $item->name . ' ('.$item->code.')' }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('satuan')
                                                        <div class="alert alert-danger p-2 mt-2">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <div class="form-group">
                                                    <label for="status" class="col-form-label-sm text-uppercase display-4">Status *</label>
                                                    <select id="status" name="status" class="" required>
                                                        <option value="1" {{ ($product->is_active==1) ? 'selected' : '' }}>Active</option>
                                                        <option value="0" {{ ($product->is_active==0) ? 'selected' : '' }}>Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-xs-12">
                                                <div class="form-group mb-3">
                                                    <label for="barcode" class="col-form-label-sm text-uppercase display-4">Barcode</label>
                                                    {!! DNS1D::getBarcodeHTML($product->barcode, 'C39', 1, 30, 'black') !!}
                                                    <span class="text-sm text-dark">{{ $product->barcode }}</span>
                                                    <input type="hidden" id="barcode" name="barcode" class="form-control" autocomplete="off" value="{{ $product->barcode }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <input type="hidden" id="image_name" name="image_name" value="{{ $product->image_name }}">
                                                    <label for="product_image" class="col-form-label-sm text-uppercase display-4">Foto</label>

                                                    <div class="custom-file mb-3">
                                                        <input type="file" id="product_image" name="product_image" class="custom-file-input" lang="en">
                                                        <label class="custom-file-label" for="product_image">Select file</label>
                                                    </div>
                                                    <img src="{{ $product->image_url }}" style="width: 150px; height: 150px;">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <div class="d-flex">
                                <input type="hidden" id="product_id" name="product_id" value="{{ $product->id }}">
                                <a href="{{url('barang')}}" id="btn_cancel" name="action" class="btn btn-link">Batal</a>
                                <button type="submit" id="btn_save" name="action" class="btn btn-facebook" value="save">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('product.script.edit')
@endsection
