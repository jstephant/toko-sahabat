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
								<li class="breadcrumb-item active"><a href="#" class="text-white">Daftar Supplier</a></li>
							</ol>
						</nav>
					</div>
					<div class="col-lg-6 col-5 text-right">
						<a href="{{url('supplier/create')}}" class="btn btn-sm btn-neutral">Create</a>
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
							<div class="col-12">
								<div class="table-responsive">
									<table class="table align-items-center table-flush dataTable" id="supplier_table" width="100%">
										<thead class="thead-light text-white">
											<tr>
												<th scope="col">Nama</th>
												<th scope="col">Phone</th>
                                                <th scope="col">Email</th>
												<th scope="col">Alamat</th>
												<th scope="col" width="5%">Status</th>
												<th scope="col" width="10%">Tgl. Update</th>
												<th scope="col" width="5%"></th>
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
    @include('supplier.script.index')
    @include('confirmation.delete')
@endsection
