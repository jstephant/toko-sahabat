@extends('layouts.app')

@section('content')
    <div class="header bg-primary pb-6"></div>
    <div class="container-fluid -fluid mt--5">
		<div class="row">
			<div class="col-lg-4 col-md-4 col-xs-12">
				<div class="card shadow">
					<div class="card-header bg-danger h4 text-center text-uppercase text-white">Customer</div>
                    <div class="card-body">
                        <ul class="list-group" id="lead_status">
                            {{-- @foreach ($lead_status as $item) --}}
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{-- {{ $item['status_name']}} --}}
                                    <span class="badge badge-primary badge-pill"></span>
                                </li>
                            {{-- @endforeach --}}
                        </ul>
                        <br>
                        <ul class="list-group" id="followup_status">
                            {{-- @foreach ($followup_status as $item) --}}
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{-- {{ $item['status_name']}} --}}
                                    <span class="badge badge-primary badge-pill"></span>
                                </li>
                            {{-- @endforeach --}}
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-xs-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow">
                            <div class="card-header bg-danger h4 text-center text-uppercase text-white">Sales</div>
                            <div class="card-body">
                                <ul class="list-group" id="total_account">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        New Accounts
                                        <span class="badge badge-primary badge-pill"></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Total Account
                                        <span class="badge badge-primary badge-pill"></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- @include('home.script.index') --}}
@endsection
