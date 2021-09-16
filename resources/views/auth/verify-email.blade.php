@extends('auth.main')
@section('content')
@if (session('message'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{ session('message') }}
    </div>
@endif
{{ __('auth.verify_intro') }}
<form class="d-inline" method="POST" action="{{ route('verification.send') }}">
    @csrf
    <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('auth.click_here') }}</button>.
</form>
@endsection
