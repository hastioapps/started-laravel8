@extends('layouts.main')
@section('content')
<div class="lockscreen-wrapper">
    <div class="text-center">
        <h5>{{ $title ?? __('label.no_title') }}</h5>
    </div>
    <div class="lockscreen-logo">
        {{ __('alert.data_not_found') }}
    </div>
    <div class="text-center">
        <a type="button" href="{{ $back?? url('home') }}" class="btn btn-primary btn-sm" >{{ __('button.back') }}</a>
    </div>
</div>
@endsection