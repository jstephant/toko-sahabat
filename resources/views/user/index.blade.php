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
								<li class="breadcrumb-item active"><a href="#" class="text-white">List of User</a></li>
							</ol>
						</nav>
					</div>
					<div class="col-lg-6 col-5 text-right">
						<a href="{{url('/user/create')}}" class="btn btn-sm btn-neutral">Create</a>
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
									<table class="table table-striped display responsive nowrap dataTable" id="user_table" width="100%">
										<thead class="thead-light">
											<tr>
												<th scope="col">No</th>
												<th scope="col">Nama</th>
												<th scope="col">Username</th>
												<th scope="col">Email</th>
                                                <th scope="col">Role</th>
												<th scope="col">Active</th>
												<th scope="col">Submitted On</th>
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
    @include('user.script.index')
@endsection
