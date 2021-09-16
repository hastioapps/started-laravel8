@extends('layouts.main')
@section('content')
<div class="col-12">
    <div class="card card-primary card-outline">
        <div class="card-body box-profile">
            <div class="text-center">
            <img class="profile-user-img img-fluid img-circle"
                src="{{ (is_file(url('assets/img/logo/'.Request::user()->image)))? url('assets/img/logo/'.Request::user()->image):url('assets/img/logo/default.png')}}"
                alt="User profile picture">
            </div>
            <h3 class="profile-username text-center">{{ $company->name }}</h3>
            <div class="row">
                <div class="col-5 col-sm-3">
                    <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="vert-tabs-home-tab" data-toggle="pill" href="#vert-tabs-home" role="tab" aria-controls="vert-tabs-home" aria-selected="true">{{ __('label.general') }}</a>
                        <a class="nav-link" id="vert-tabs-tax-tab" data-toggle="pill" href="#vert-tabs-tax" role="tab" aria-controls="vert-tabs-tax" aria-selected="false">{{ __('label.tax') }}</a>
                    </div>
                </div>
                <div class="col-7 col-sm-9">
                    <div class="tab-content" id="vert-tabs-tabContent">
                        <div class="tab-pane text-left fade show active" id="vert-tabs-home" role="tabpanel" aria-labelledby="vert-tabs-home-tab">
                            <div class="table-responsive p-0">
                                <table class="table table-sm">
                                <tbody>
                                    <tr>
                                        <td style="width:20%">{{ __('company.company_address') }}</td>
                                        <td style="width:5%">:</td>
                                        <td style="width:75%">{{ $company->address }}</td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>:</td>
                                        <td>{{ $company->email }}</td>
                                    </tr>
                                    <tr>
                                        <td>Phone</td>
                                        <td>:</td>
                                        <td>{{ $company->phone }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('company.owner') }}</td>
                                        <td>:</td>
                                        <td>{{ $company->warning }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('label.currency') }}</td>
                                        <td>:</td>
                                        <td>{{ $company->currency }}</td>
                                    </tr>
                                </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="vert-tabs-tax" role="tabpanel" aria-labelledby="vert-tabs-tax-tab">
                            <div class="table-responsive p-0">
                                <table class="table table-sm">
                                <tbody>
                                    <tr>
                                        <td style="width:20%">{{ __('company.npwp') }}</td>
                                        <td style="width:5%">:</td>
                                        <td style="width:75%">{{ $company->npwp }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('company.npwp_name') }}</td>
                                        <td>:</td>
                                        <td>{{ $company->npwp_name }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('company.npwp_address') }}</td>
                                        <td>:</td>
                                        <td>{{ $company->npwp_address }}</td>
                                    </tr>
                                </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
