@extends('layouts.app')

@section('content')
    <div class="header bg-primary pb-6"></div>
    <div class="container-fluid -fluid mt--7">
        <div class="row">
            <div class="col-12">
                <div class="card shadow mt-5 mb-5">
                    <form class="form-basic needs-validation" novalidate method="post" role="form" action="{{ route('user.edit.post') }}" enctype="multipart/form-data" id="form-create-lead">
                        @csrf
                        <div class="card-body">
                            <div class="pl-lg-2">
                                <div class="row">
                                    <div class="col-lg-5 col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="name" class="form-control-label">Nama *</label>
                                            <input type="text" id="name" name="name" class="form-control" autocomplete="off" value="{{ $user->name }}" required autofocus>
                                            @if ($errors->has('name'))
                                                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="email" class="form-control-label">Email</label>
                                            <input type="email" id="email" name="email" class="form-control" autocomplete="off" value="{{ $user->email }}">
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5 col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="username" class="form-control-label">Username *</label>
                                            <input type="text" id="username" name="username" class="form-control" autocomplete="off" value="{{ $user->user_name }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5 col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="role" class="form-control-label">Role *</label>
                                            <select id="role" name="role[]" class="form-control" data-toggle="select" data-live-search="true" multiple>
                                                <option value=""></option>
                                                @foreach ($roles as $item )
                                                    @foreach ($user->user_role as $item2)
                                                        {{ $selected = '' }}
                                                        @if ($item->id==$item2->role_id)
                                                            {{ $selected = 'selected' }}
                                                            @break
                                                        @endif
                                                    @endforeach
                                                    <option value="{{ $item->id }}" {{ $selected }}>{{ $item->name }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <div class="d-flex">
                                <input type="hidden" id="user_id" name="user_id" value="{{ $user->id }}">
                                <a href="{{url('/user')}}" id="btn_cancel" name="action" class="btn btn-link">Cancel</a>
                                <button type="submit" id="btn_save" name="action" class="btn btn-facebook" value="save">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
