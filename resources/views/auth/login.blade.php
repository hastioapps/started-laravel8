@extends('auth.main')
@section('content')
    @if (session()->has('warning'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ session('warning') }}
        </div>
    @elseif (session()->has('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ session('success') }}
        </div>
    @endif 
    <form action="{{ url('auth/login') }}" method="POST">
        @csrf
        <div class="input-group mb-2">
          <input value="{{ old('user_id') }}" placeholder="User ID" class="form-control form-control-sm @error('user_id') is-invalid @enderror" id="user_id" name="user_id" type="text" maxlength="10" required/>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
          @error('user_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="input-group mb-2">
          <input value="" placeholder="{{ __('auth.password') }}" class="form-control form-control-sm @error('password') is-invalid @enderror" id="password" name="password" type="password" required/>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-key"></span>
            </div>
          </div>
          @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="form-check mb-2">
          <input class="form-check-input text-center" type="checkbox" name="remember" id="remember" value="true" aria-label="...">
          <label class="form-check-label" for="remember">Remember me</label>
        </div>         
        <div class="row">
          <div class="col-12">
            <button class="btn btn-primary btn-block btn-sm" name="btnLogin" id="btnLogin" type="submit">{{ __('auth.login') }}</button>
          </div>
        </div>
    </form>
    <p class="mb-1">
        <a href="{{ url('auth/register') }}">{{ __('auth.sign_up') }}</a> 
        <br>
        <a href="{{ route('password.request') }}">{{ __('auth.forgotten_password') }}</a>
    </p>
@endsection