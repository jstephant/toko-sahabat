@extends('layouts.app')

@section('content')
    <div class="header bg-primary pb-6"></div>
    <div class="container-fluid -fluid mt--7">
        <div class="row">
            <div class="col-12">
                <div class="card shadow mt-5 mb-5">
                    <form class="form-basic needs-validation" novalidate method="post" role="form" action="{{ route('user.edit.post') }}" enctype="multipart/form-data" id="form-edit-user">
                        @csrf
                        <div class="card-body">
                            <div class="pl-lg-2">
                                <div class="row">
                                    <div class="col-lg-5 col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="name" class="col-form-label-sm text-uppercase display-4">Nama *</label>
                                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" autocomplete="off" value="{{ $user->name }}" required autofocus>
                                            @error('name')
                                                <div class="alert alert-danger p-2 mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="email" class="col-form-label-sm text-uppercase display-4">Email</label>
                                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" autocomplete="off" value="{{ $user->email }}">
                                            @error('email')
                                                <div class="alert alert-danger p-2 mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5 col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="username" class="col-form-label-sm text-uppercase display-4">Username *</label>
                                            <input type="text" id="username" name="username" class="form-control" autocomplete="off" value="{{ $user->user_name }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5 col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="role" class="col-form-label-sm text-uppercase display-4">Role *</label>
                                            <select id="role" name="role" class="form-control @error('role') is-invalid @enderror" data-toggle="select" data-live-search="true" required>
                                                <option value=""></option>
                                                @foreach ($roles as $item )
                                                    <option value="{{ $item->id }}" {{ ($item->id==$user->role_id) ? 'selected' : '' }}>{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('role')
                                                <div class="alert alert-danger p-2 mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <div class="d-flex">
                                <input type="hidden" id="user_id" name="user_id" value="{{ $user->id }}">
                                <a href="{{url('/user')}}" id="btn_cancel" name="action" class="btn btn-link">Batal</a>
                                <button type="submit" id="btn_save" name="action" class="btn btn-facebook" value="save">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('user.script.edit')
@endsection
