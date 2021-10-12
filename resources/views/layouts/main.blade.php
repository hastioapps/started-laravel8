<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', config('app.locale')) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name') }} | {{ $title ?? __('label.title') }}</title>
        <link rel="icon" type="image/x-icon" href="{{ url('favicon.ico') }}" />
        <link rel="stylesheet" href="{{ url('assets/fontawesome-free/css/all.min.css') }}"/>
        <link rel="stylesheet" href="{{ url('assets/adminlte3/dist/css/adminlte.min.css') }}">
        <link rel="stylesheet" href="{{ url('assets/toastr/toastr.min.css') }}">
        <link rel="stylesheet" href="{{ url('assets/sweetalert/dist/sweetalert.css') }}"/>
        <link rel="stylesheet" href="{{ url('assets/flexigrid/css/flexigrid.css') }}">
        <link rel="stylesheet" href="{{ url('assets/DualListboxTransfer/icon_font/css/icon_font.css') }}">
        <link rel="stylesheet" href="{{ url('assets/DualListboxTransfer/css/jquery.transfer.css') }}">
        <script src="{{ url('assets/jquery/jquery.min.js') }}"></script>
        <script src="{{ url('assets/flexigrid/js/flexigrid.js') }}"></script>
    </head>
    <body class="hold-transition layout-top-nav layout-navbar-fixed text-sm">
        <div class="wrapper">
          <!-- Navbar -->
          <nav class="main-header navbar navbar-expand-md navbar-dark navbar-primary">
            <div class="container-fluid">
              <a href="{{ url('/') }}" class="navbar-brand">
                <img src="{{ url('logo.svg') }}" alt="..." class="brand-image" style="opacity: .8"/>
              </a>
              <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
        
              <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                  <li class="nav-item {{ (Request::is('home*'))?'active':'' }}">
                    <a href="{{ route('home') }}" class="nav-link">{{ __('label.home') }}</a>
                  </li>
                  <li class="nav-item {{ (Request::is('reports*'))?'active':'' }}">
                    <a href="{{ route('reports') }}" class="nav-link">{{ __('label.reports') }}</a>
                  </li>
                  <li class="nav-item {{ (Request::is('masters*'))?'active':'' }}">
                    <a href="{{ route('masters') }}" class="nav-link">{{ __('label.master_data') }}</a>
                  </li>
                </ul>
              </div>

              <!-- Right navbar links -->
              <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fa fa-language"></i>
                        <span class="badge badge-warning navbar-badge"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                      <a href="{{ url('lang?id=en') }}" class="dropdown-item">
                          English  @if (isset($_COOKIE['lang']) && $_COOKIE['lang']=='en') <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span> @endif
                      </a>
                      <a href="{{ url('lang?id=id') }}" class="dropdown-item">
                          Indonesia @if (isset($_COOKIE['lang']) && $_COOKIE['lang']=='id') <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span> @endif
                      </a>
                  </div>
                </li>
                <li class="nav-item user-menu">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
                        <img src="{{ (is_file('storage/users-img/'.Request::user()->img))? asset('storage/users-img/'.Request::user()->img):url('assets/img/default.png')}}" class="user-image img-circle elevation-2" alt="Img" style="background-color:#ffffff">
                    </a>
                </li>
              </ul>
              <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="flag-icon flag-icon-us"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right p-0">
          <a href="#" class="dropdown-item active">
            <i class="flag-icon flag-icon-us mr-2"></i> English
          </a>
          <a href="#" class="dropdown-item">
            <i class="flag-icon flag-icon-de mr-2"></i> German
          </a>
          <a href="#" class="dropdown-item">
            <i class="flag-icon flag-icon-fr mr-2"></i> French
          </a>
          <a href="#" class="dropdown-item">
            <i class="flag-icon flag-icon-es mr-2"></i> Spanish
          </a>
        </div>
      </li>
            </div>
          </nav>
          <!-- /.navbar -->
          <!-- Content Wrapper. Contains page content -->
          <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
              <div class="container-fluid mt-2">
                <div class="row mb-2">
                  <div class="col-sm-6">
                      <h5 class="m-0">{{ config('app.name') }}</h5>
                  </div><!-- /.col -->
                  <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                      {!! isset($breadcrumbs)? $breadcrumbs:'' !!}
                    </ol>
                  </div><!-- /.col -->
                </div><!-- /.row -->
              </div><!-- /.container-fluid -->
            </div>
            <!-- Main content -->
            <div class="content">
              <div class="container-fluid">
                <div class="row">
                  @yield('content')
                </div>
                <!-- /.row -->
              </div><!-- /.container-fluid -->
            </div>
          </div>
          <!-- Main Footer -->

          <!-- Control Sidebar -->
          @include('layouts.sidebar')
          <!-- /.control-sidebar -->

          <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
              <b>Version</b> {{ config('app.version') }}
            </div>
            {{ config('app.name') }} &copy; {{ config('app.copyright') }}
          </footer>
          <!-- ./wrapper -->
        </div>

        <script type="text/javascript">
            $(document).ready(function (){ 
                @if (session()->has('error'))
                    toastr.error("{{ session('error') }}");
                @elseif (session()->has('warning'))
                    toastr.warning("{{ session('warning') }}");
                @elseif (session()->has('success'))
                    toastr.success("{{ session('success') }}");
                @endif 
            });
        </script>
        <script src="{{ url('assets/adminlte3/dist/js/adminlte.min.js') }}"></script>
        <script src="{{ url('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ url('assets/loading-overlay/dist/loadingoverlay.min.js') }}"></script>
        <script src="{{ url('assets/adminlte3/dist/plugins/moment/moment.min.js') }}"></script>
        <script src="{{ url('assets/toastr/toastr.min.js') }}"></script>
        <script src="{{ url('assets/validate/jquery.validate.js') }}"></script>
        <script src="{{ url('assets/sweetalert/dist/sweetalert.min.js') }}"></script>
        <script src="{{ url('assets/DualListboxTransfer/js/jquery.transfer.js') }}"></script>
        <script src="{{ url('assets/js/app.js') }}"></script>
    </body>
</html>