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
        <script src="{{ url('assets/jquery/jquery.min.js') }}"></script>
        <script src="{{ url('assets/flexigrid/js/flexigrid.js') }}"></script>
    </head>
    <body class="hold-transition layout-top-nav layout-navbar-fixed text-sm">
        <div class="wrapper">
          <!-- Navbar -->
          <nav class="main-header navbar navbar-expand navbar-dark navbar-primary">
            <div class="container-fluid">
              <a href="{{ url('home') }}" class="navbar-brand">
                <img src="{{ url('logo.svg') }}" alt="..." class="brand-image" style="opacity: .8"/>
              </a>

              <!-- Right navbar links -->
              <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                <li class="nav-item nav-link">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" placeholder="{{ __('label.tcode') }}" aria-label="tcode">
                        <div class="input-group-append">
                            <button class="btn btn-navbar">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </li>
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
                <li class="nav-item dropdown user-menu">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <img src="{{ (is_file(url('assets/img/'.Request::user()->image)))? url('assets/img/'.Request::user()->image):url('assets/img/default.png')}}" class="user-image img-circle elevation-2" alt="Img">
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link"><i class="nav-icon fa fa-sign-out-alt"></i></a>
                </li>
              </ul>
            </div>
          </nav>
          <!-- /.navbar -->
          <!-- Content Wrapper. Contains page content -->
          <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
              <div class="container-fluid">
                <div class="row mb-2 mt-2">
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
        <script src="{{ url('assets/js/app.js') }}"></script>
    </body>
</html>