@extends('layouts.app')

@section('content')
	<div class="header pb-6">
		<div class="container-fluid">
			<div class="header-body">
				<div class="row align-items-center py-4">
					<div class="col-lg-6 col-7">
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
						<div class="row align-items-center mb-3">
							<div class="col"></div>
							<div class="col-lg-3 col-md-4">
								<div class="form-group mb-3">
									<select id="category" name="category" class="form-control">
										<option value="" selected>Select Kategori</option>
										@foreach ($category as $item)
											<option value="{{$item->id}}">{{ $item->name }}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12 align-items-center">
								<span id="errorMessage" class="text-center"></span>
								<div class="row" id="detail_product"></div>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<button type="button" id="btn_more" name="btn_more" class="btn btn-sm btn-primary ml-2">Load more...</button>
							</div>
						</div>
						<input type="hidden" id="cart_id" name="cart_id" value="{{ session('cart_id') }}">
						<input type="hidden" id="last_id" name="last_id" value="0">
					</div>
				</div>
			<div>
		</div>
	</div>
    @include('pos.script.index')
@endsection
