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
								<li class="breadcrumb-item active"><a href="#" class="text-white">Daftar Pembelian</a></li>
							</ol>
						</nav>
					</div>
					<div class="col-lg-6 col-5 text-right">
						<a href="{{url('beli/create')}}" class="btn btn-sm btn-neutral">Create</a>
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
                                    <label for="supplier" class="col-form-label-sm text-uppercase display-4">Supplier</label>
                                    <select id="supplier" name="supplier" class="form-control">
                                        <option value=""></option>
                                        @foreach ($supplier as $item)
											<option value="{{ $item->id }}">{{$item->name}}
										@endforeach
                                    </select>
                                </div>
                            </div>
						</div>
						<div class="row">
							<div class="col-12">
								<div class="table-responsive">
									<table class="table table-striped display responsive nowrap dataTable" id="purchase_table" width="100%">
										<thead class="thead-light">
											<tr>
												<th scope="col">No</th>
												<th scope="col">No. Pembelian</th>
												<th scope="col">Tgl. Pembelian</th>
                                                <th scope="col">Supplier</th>
												<th scope="col">Sub Total</th>
												<th scope="col">Disc</th>
                                                <th scope="col">Total</th>
												<th scope="col">Tgl. Update</th>
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
    @include('purchase.script.index')
@endsection
