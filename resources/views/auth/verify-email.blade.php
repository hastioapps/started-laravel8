@extends('auth.main')
@section('content')
@if (session('message'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{ session('message') }}
    </div>
@endif
<div>
    {{  __('auth.verify_intro',['email'=>Request::user()->email])  }}
    <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('auth.click_here') }}</button>.
    </form>
    <hr>
    <form action="{{ route('change.email') }}" method="POST">
        @csrf
        <div class="input-group mb-2">
            <input value="{{ old('email') }}" placeholder="Email" class="form-control form-control-sm @error('email') is-invalid @enderror" id="email" name="email" type="email" required/>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="row">
          <div class="col-12">
            <button class="btn btn-primary btn-block btn-sm" name="btnEmail" id="btnEmail" type="submit">{{ __('button.change_email') }}</button>
          </div>
        </div>
    </form>
</div>
@endsection
