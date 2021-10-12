@extends('auth.main')
@section('content')
    @if (session()->has('warning'))
        <div class="alert alert-danger  alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ session('warning') }}
        </div>
    @endif 
    <form action="{{ url('auth/register') }}" method="POST">
        @csrf
        <div class="input-group mb-2">
          <input value="{{ old('company') }}" placeholder="{{ __('auth.your_company') }}" class="form-control form-control-sm @error('company') is-invalid @enderror" id="company" name="company" type="text" maxlength="100" required/>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-flag"></span>
            </div>
          </div>
          @error('company') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
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
          <input value="{{ old('email') }}" placeholder="Email" class="form-control form-control-sm @error('email') is-invalid @enderror" id="email" name="email" type="email" required/>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
          @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="input-group mb-2">
          <input value="{{ old('phone') }}" placeholder="Phone" class="form-control form-control-sm @error('phone') is-invalid @enderror" id="phone" name="phone" type="text" maxlength="15" required/>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-phone"></span>
            </div>
          </div>
          @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
            <button class="btn btn-primary btn-block btn-sm" name="btnRegister" id="btnRegister" type="submit">{{ __('auth.sign_up') }}</button>
          </div>
        </div>
    </form>
    <p class="mb-1">
        <a href="{{ url('auth/login') }}">{{ __('auth.login') }}</a>
    </p>
@endsection