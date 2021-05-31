@extends('layouts.login')

@section('content')
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-5 col-lg-5">
            <div class="card bg-secondary border-0 mb-0">
                <div class="card-header bg-transparent">
                    <div class="text-muted text-center">Login to your account</div>
                </div>
                <div class="card-body px-lg-4 py-lg-4">
                    <form method="POST" action="{{ route('login.post') }}" enctype="multipart/form-data" role="form">
                        @csrf
                        <div class="form-group">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                </div>
                                <input id="username" placeholder="Username" type="text" class="form-control {{ $errors->has('nik') ? ' is-invalid' : '' }}" name="username" required autofocus>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                </div>
                                <input id="password" type="password" placeholder="Password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>

                        @include('alert.alert')

                        <div class="text-center">
                            <input type="hidden" name="token" value="fgAyKd_mQdakS2pevikNu6:APA91bHpFjz0BWZCi6WzsyG3F22asRCDuxPTliKA0hE7RoNLDN2P5-32kzBA86uqhmnYzOaF4G9CyxqW5fcqU01O8nyjeYjjVho_VSNET4ObICvVCZdYAY4MFSF38DK70qW9NFZa38_A">
                            <button type="submit" class="btn btn-primary my-4">Sign in</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
