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
								<li class="breadcrumb-item active"><a href="#" class="text-white">Daftar Sub Kategori</a></li>
							</ol>
						</nav>
					</div>
					<div class="col-lg-6 col-5 text-right">
						<a href="#" class="btn btn-sm btn-neutral" data-toggle="modal" data-target="#modal-create-edit" data-mode="create">Create</a>
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
                            <div class="col"></div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="category1" class="col-form-label-sm text-uppercase display-4">Kategori</label>
                                    <select id="category1" name="category1" class="form-control" data-toggle="select" required>
                                        <option value=""></option>
                                        @foreach ($categories as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
						<div class="row">
							<div class="col-12">
								<div class="table-responsive">
									<table class="table table-striped display responsive nowrap dataTable" id="sub_category_table" width="100%">
										<thead class="thead-light">
											<tr>
												<th scope="col">No</th>
												<th scope="col">Name</th>
                                                <th scope="col">Kategori</th>
												<th scope="col">Active</th>
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
    @include('sub-category.script.index')
    @include('sub-category.modal.sub-create-edit')
    @include('sub-category.script.sub-create-edit')
    @include('confirmation.delete')
@endsection
