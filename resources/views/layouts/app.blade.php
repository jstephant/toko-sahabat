<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta http-equiv="Content-Type" content="text/html">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
        <meta name="author" content="Leunammi">
        <meta name="csrf-token" content="{{ csrf_token() }}">
		<title>{{ $title }}</title>

		<!-- Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

        <!-- Icons -->
		<link href="{{ $asset('vendor/nucleo/css/nucleo.css?v=1.0.0') }}" rel="stylesheet">
		<link href="{{ $asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">

		<!-- Argon CSS -->
		<link type="text/css" href="{{ $asset('css/argon-pro.css?v=1.1.0') }}" rel="stylesheet">

        {{-- select2 --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">


        {{-- datatables --}}
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.bootstrap4.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css">

        {{-- flatpickr --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

        {{-- sweetalert --}}

        {{-- swiper --}}
		<link rel="stylesheet" type="text/css" href="https://unpkg.com/swiper/swiper-bundle.min.css">
		{{-- <link rel="stylesheet" href="{{ $asset('css/swiper-custom.css')}}" /> --}}
	</head>
	<body>
		<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
			<div class="scroll-wrapper scrollbar-inner" style="position: relative;"><div class="scrollbar-inner scroll-content scroll-scrolly_visible" style="height: auto; margin-bottom: 0px; margin-right: 0px; max-height: 689px;">
			<!-- Brand -->
				<div class="sidenav-header d-flex align-items-center">
					<a class="navbar-brand" href="/">

					</a>
					<div class="ml-auto">
						<!-- Sidenav toggler -->
						<div class="sidenav-toggler d-none d-xl-block active" data-action="sidenav-unpin" data-target="#sidenav-main">
							<div class="sidenav-toggler-inner">
								<i class="sidenav-toggler-line"></i>
								<i class="sidenav-toggler-line"></i>
								<i class="sidenav-toggler-line"></i>
							</div>
						</div>
					</div>
				</div>
				<div class="navbar-inner">
					<!-- Collapse -->
					<div class="collapse navbar-collapse" id="sidenav-collapse-main">
						<!-- Nav items -->
						<ul class="navbar-nav">
							<li class="nav-item">
								<a class="nav-link" href="/home">
									<i class="ni ni-shop text-default"></i>
									<span class="nav-link-text">Dashboard</span>
								</a>
                            </li>
                            <li class="nav-item">
								<a class="nav-link" href="/user">
									<i class="ni ni-single-02 text-default"></i>
									<span class="nav-link-text">User</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="/role">
									<i class="ni ni-hat-3 text-default"></i>
									<span class="nav-link-text">Role</span>
								</a>
							</li>
                            <li class="nav-item">
								<a class="nav-link" href="/customer">
                                    <i class="fas fa-user-friends text-default"></i>
									<span class="nav-link-text">Customer</span>
								</a>
							</li>
                            <li class="nav-item">
                                <a class="nav-link collapsed" href="#navbar-product" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-dashboards">
									<i class="ni ni-app text-default"></i>
									<span class="nav-link-text">Barang</span>
								</a>
								<div class="collapse" id="navbar-product" style="">
									<ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="/satuan">
                                                <i class="ni ni-building text-default"></i>
                                                <span class="sidenav-normal">Satuan</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="/kategori">
                                                <i class="ni ni-bullet-list-67 text-default"></i>
                                                <span class="sidenav-normal">Kategori</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="/sub-kategori">
                                                <i class="ni ni-building text-default"></i>
                                                <span class="sidenav-normal">Sub Kategori</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="/barang">
                                                <i class="ni ni-building text-default"></i>
                                                <span class="sidenav-normal">Barang</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
							</li>
                            <li class="nav-item">
                                <a class="nav-link collapsed" href="#navbar-purchase" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-dashboards">
									<i class="ni ni-building text-default"></i>
									<span class="nav-link-text">Pembelian</span>
								</a>
								<div class="collapse" id="navbar-purchase" style="">
									<ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="/supplier">
                                                <i class="fas fa-chalkboard-teacher text-default"></i>
                                                <span class="nav-link-text">Supplier</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="/pembelian">
                                                <i class="ni ni-building text-default"></i>
                                                <span class="nav-link-text">Pembelian</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
								<a class="nav-link" href="/penjualan">
									<i class="ni ni-money-coins text-default"></i>
									<span class="nav-link-text">Penjualan</span>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="scroll-element scroll-x scroll-scrolly_visible"><div class="scroll-element_outer"><div class="scroll-element_size"></div><div class="scroll-element_track"></div><div class="scroll-bar" style="width: 0px; left: 0px;"></div></div></div><div class="scroll-element scroll-y scroll-scrolly_visible"><div class="scroll-element_outer"><div class="scroll-element_size"></div><div class="scroll-element_track"></div><div class="scroll-bar" style="height: 602px; top: 0px;"></div></div></div></div>
		</nav>
        <div class="main-content" id="panel">
			<!-- Topnav -->
			<nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
				<div class="container-fluid">
					<div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <h6 class="h2 text-white d-none d-xl-block d-lg-block d-md-block mb-0 text-uppercase">{{ $active_menu }}</h6>
						<!-- Search form -->
						{{-- <form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main">
							<div class="form-group mb-0">
								<div class="input-group input-group-alternative input-group-merge">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="fas fa-search"></i></span>
									</div>
									<input class="form-control" placeholder="Search" type="text" id="searchactive">
								</div>
							</div>
							<button type="button" class="close" data-action="search-close" data-target="#navbar-search-main" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</form> --}}
						<!-- Navbar links -->
						<ul class="navbar-nav align-items-center ml-md-auto">
							<li class="nav-item d-xl-none">
								<!-- Sidenav toggler -->
								<div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
									<div class="sidenav-toggler-inner">
										<i class="sidenav-toggler-line"></i>
										<i class="sidenav-toggler-line"></i>
										<i class="sidenav-toggler-line"></i>
									</div>
								</div>
							</li>
							<li class="nav-item d-sm-none">
								<a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">
									<i class="ni ni-zoom-split-in"></i>
								</a>
							</li>
						</ul>
						<ul class="navbar-nav align-items-center ml-auto ml-md-0">
							<li class="nav-item dropdown">
								<a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<div class="media align-items-center">
										<span class="avatar avatar-sm rounded-circle">
											<img alt="Image profile" src="{{ session('photo') }}">
										</span>
										<div class="media-body ml-2 d-none d-lg-block">
											<span class="mb-0 text-sm font-weight-bold">{{ session('name') }}</span>
										</div>
									</div>
								</a>
								<div class="dropdown-menu dropdown-menu-right">
									<div class="dropdown-header noti-title">
										<h6 class="text-overflow m-0">Welcome!</h6>
									</div>
									<a href="/internal/auth/logout" class="dropdown-item">
										<i class="ni ni-user-run"></i>
										<span>Logout</span>
									</a>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</nav>
			@yield('content')
			<div class="container-fluid">
				<footer class="footer pt-0">
					<div class="row align-items-center justify-content-lg-between">
						<div class="col-lg-6">
							<div class="copyright text-center text-lg-left text-muted">
								Copyright © {{ date('Y') }} <span class="font-weight-bold ml-1 text-uppercase">Toko Sahabat</a>
							</div>
						</div>
					</div>
				</footer>
			</div>
		</div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.2.1/js.cookie.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.scrollbar/0.2.11/jquery.scrollbar.min.js"></script>
        <script src="{{ $asset('vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js')}}"></script>

        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

		<!-- Argon JS -->
		<script src="{{ $asset('js/argon-pro.js?v=1.1.0') }}"></script>

        <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

        {{-- datatables --}}
        <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.bootstrap4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>

        @include('sweet::alert')

		<div class="backdrop d-xl-none" data-action="sidenav-unpin" data-target="undefined"></div>
		<div style="left: -1000px; overflow: scroll; position: absolute; top: -1000px; border: none; box-sizing: content-box; height: 200px; margin: 0px; padding: 0px; width: 200px;"><div style="border: none; box-sizing: content-box; height: 200px; margin: 0px; padding: 0px; width: 200px;"></div></div>
	</body>
</html>
