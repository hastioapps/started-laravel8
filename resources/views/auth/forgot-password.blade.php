@extends('auth.main')
@section('content')
@if (session('status'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{ session('status') }}
    </div>
@endif     
<form id="resetForm" action="{{ route('password.email') }}" method="POST">
    @csrf
    <div class="input-group mb-2">
        <input value="{{ old('email') }}" placeholder="Email" class="form-control form-control-border border-width-2 form-control-sm @error('email') is-invalid @enderror" id="email" name="email" type="email" required/>
        <div class="input-group-append">
          <div class="input-group-text">
            <span class="fas fa-envelope"></span>
          </div>
        </div>
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="row">
      <div class="col-12">
        <button class="btn btn-primary btn-block btn-sm" name="btnRegister" id="btnRegister" type="submit">{{ __('auth.search') }}</button>
      </div>
    </div>
</form>
<p class="mb-1">
    <a href="{{ url('auth/login') }}">{{ __('auth.login') }}</a> 
    <br>
    <a href="{{ url('auth/register') }}">{{ __('auth.sign_up') }}</a>
</p>
@endsection