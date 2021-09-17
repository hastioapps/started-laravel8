@extends('auth.main')
@section('content')
@error('email')
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{ $message }}
    </div>
@enderror
<form id="resetForm" action="{{ route('password.update') }}" method="POST">
    @csrf
    <input value="{{ $token }}" name="token" type="hidden" required/>
    <div class="input-group mb-2">
        <input readonly value="{{ $_GET['email'] }}" placeholder="Email" class="form-control form-control-sm" id="email" name="email" type="email" required/>
        <div class="input-group-append">
          <div class="input-group-text">
            <span class="fas fa-envelope"></span>
          </div>
        </div>
    </div>
    <div class="input-group mb-2">
        <input value="" placeholder="{{ __('auth.new_password') }}" class="form-control form-control-sm @error('password') is-invalid @enderror" id="password" name="password" type="password" required/>
        <div class="input-group-append">
          <div class="input-group-text">
            <span class="fas fa-key"></span>
          </div>
        </div>
        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="input-group mb-2">
        <input value="" placeholder="{{ __('auth.re_password') }}" class="form-control form-control-sm" id="password_confirmation" name="password_confirmation" type="password" required/>
              <div class="input-group-append">
          <div class="input-group-text">
            <span class="fas fa-key"></span>
          </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
          <button class="btn btn-primary btn-block btn-sm" name="btnRegister" id="btnRegister" type="submit">Submit</button>
        </div>
    </div>
</form>
@endsection