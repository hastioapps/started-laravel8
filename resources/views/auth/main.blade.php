<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', config('app.locale')) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>{{ config('app.name') }} | {{ $title ?? __('label.title') }}</title>
        <link rel="icon" type="image/x-icon" href="{{ url('favicon.ico') }}" />
        <link rel="stylesheet" href="{{ url('assets/fontawesome-free/css/all.min.css') }}"/>
        <link rel="stylesheet" href="{{ url('assets/adminlte3/dist/css/adminlte.min.css') }}">
        
        <script src="{{ url('assets/jquery/jquery.min.js') }}"></script>
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
          <div class="card card-outline card-blue">
            <div class="card-header text-center">
              <img src="{{ url(config('app.logo')) }}" alt="..." width="50px" height="50px"> <h4>{{ config('app.name') }}</h4>
            </div>
            <div class="card-body">
                <h5>{{ $title ?? __('label.title') }}</h5>
                @yield('content')
            </div>
            <div class="card-footer text-center">
                &copy; {{ config('app.copyright') }}<br>
                Version {{ config('app.version') }} <br>
                <a href="{{ url('lang?id=id') }}">Indonesia</a> | <a href="{{ url('lang?id=en') }}">English</a>
            </div>
          </div>
        </div>
    
        <script src="{{ url('assets/adminlte3/dist/js/adminlte.min.js') }}"></script>
        <script src="{{ url('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    </body>
</html>