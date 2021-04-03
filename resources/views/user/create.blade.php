@extends('layouts.app')

@section('content')
    <div class="header bg-primary pb-6"></div>
    <div class="container-fluid -fluid mt--7">
        <div class="row">
            <div class="col-12">
                <div class="card shadow mt-5 mb-5">
                    <form class="form-basic needs-validation" novalidate method="post" role="form" action="{{ route('user.create.post') }}" enctype="multipart/form-data" id="form-create">
                        @csrf
                        <div class="card-body">
                            <div class="pl-lg-2">
                                <div class="row">
                                    <div class="col-lg-5 col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="name" class="form-control-label">Nama *</label>
                                            <input type="text" id="name" name="name" class="form-control" autocomplete="off" value="{{ old('name') }}" required autofocus>
                                            @if ($errors->has('name'))
                                                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="email" class="form-control-label">Email</label>
                                            <input type="email" id="email" name="email" class="form-control" autocomplete="off" value="{{ old('email') }}">
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5 col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="username" class="form-control-label">Username *</label>
                                            <input type="text" id="username" name="username" class="form-control" autocomplete="off" value="{{ old('username') }}" required>
                                            <span class="mb-0 text-sm" id="check-username"></span>
                                            @if ($errors->has('username'))
                                                <div class="invalid-feedback">{{ $errors->first('username') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="password" class="form-control-label">Password *</label>
                                            <input type="password" id="password" name="password" class="form-control" autocomplete="off" required>
                                            @if ($errors->has('password'))
                                                <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5 col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="role" class="form-control-label">Role *</label>
                                            <select id="role" name="role[]" class="form-control" data-toggle="select" data-live-search="true" multiple required>
                                                <option value=""></option>
                                                @foreach ($roles as $item )
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('role'))
                                                <div class="invalid-feedback">{{ $errors->first('role') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <div class="d-flex">
                                <a href="{{url('/user')}}" id="btn_cancel" name="action" class="btn btn-link">Cancel</a>
                                <button type="submit" id="btn_save" name="action" class="btn btn-facebook" value="save">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('user.script.create')
@endsection
