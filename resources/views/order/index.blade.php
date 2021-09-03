@extends('layouts.app')

@section('content')
	<div class="header pb-6 bg-primary">
		<div class="container-fluid">
			<div class="header-body">
				<div class="row align-items-center py-4">
					<div class="col-lg-6 col-7">
						<nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
							<ol class="breadcrumb breadcrumb-links breadcrumb-dark">
								<li class="breadcrumb-item"><a href="{{url('home')}}"><i class="fas fa-home text-white"></i></a></li>
								<li class="breadcrumb-item active"><a href="#" class="text-white">Daftar Order</a></li>
							</ol>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid -fluid mt--6">
		<div class="row">
			<div class="col">
				<div class="card shadow">
					<div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
								<label for="start_date" class="col-form-label-sm text-uppercase display-4">From</label>
								<input type="text" class="form-control flatpickr flatpickr-input" id="start_date" name="start_date" value="">
                            </div>
                            <div class="col-lg-3 col-md-6">
								<label for="end_date" class="col-form-label-sm text-uppercase display-4">To</label>
								<input type="text" class="form-control flatpickr flatpickr-input" id="end_date" name="end_date" value="">
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <label for="staff" class="col-form-label-sm text-uppercase display-4">Staff</label>
                                    <select id="staff" name="staff" class="form-control">
                                        <option value=""></option>
                                        @foreach ($users as $item)
											<option value="{{ $item->id }}">{{$item->name}}
										@endforeach
                                    </select>
                                </div>
                            </div>
						</div>
						<div class="row">
							<div class="col-12">
								<div class="table-responsive">
									<table class="table table-striped align-items-center" id="order_table" width="100%">
										<thead class="thead-light">
											<tr>
												<th scope="col">No. Order</th>
												<th scope="col">Tgl. Order</th>
                                                <th scope="col">Customer</th>
												<th scope="col">Sub Total</th>
												<th scope="col">Discount</th>
                                                <th scope="col">Total</th>
                                                <th scope="col">Status Bayar</th>
												<th scope="col">Staff</th>
												<th scope="col"></th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
    @include('order.script.index')
    @include('confirmation.cancel')
    @include('order.modal.detail')
    @include('order.script.detail')
@endsection
