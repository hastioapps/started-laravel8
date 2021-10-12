@extends('layouts.main')
@section('content')
<div class="lockscreen-wrapper">
<div class="error-page">
    <h2 class="headline text-warning"> 404</h2>
    <div class="error-content text-center">
        <h3><i class="fas fa-exclamation-triangle text-warning"></i> {{ __('alert.data_not_found', ['Data' => $id ?? 'Data']) }}.</h3>
        <p>
            {{ __('alert.data_not_find') }} <a href="{{ route($back??'home') }}">{{ __('label.'.$back??'home') }}</a>.
        </p>
    </div>
</div>
</div>
@endsection