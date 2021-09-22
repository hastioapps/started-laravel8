@extends('layouts.main')
@section('content')
<div class="col-12">
    <div class="card card-primary card-outline">
        <div class="card-header box-profile">
            <div class="card-tools">
                <a type="button" href="{{ route('company_edit') }}" class="btn btn-tool" ><i class="fas fa-edit"></i></a>
                <a type="button" href="{{ route('home') }}" class="btn btn-tool" ><i class="fas fa-times"></i></a>
            </div>
            <br>
            <div class="text-center">
                <a href="#" class="logo">
                    <img class="profile-user-img img-fluid" src="{{ (is_file('storage/company-img/'.$company->img))? asset('storage/company-img/'.$company->img):url('assets/img/logo-default.png')}}" alt="...">
                </a>
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
                                        <td>{{ $company->owner }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('label.currency') }}</td>
                                        <td>:</td>
                                        <td>{{ $company->currency_id }}</td>
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

<!-- Modal upload-->
<div class="modal fade" id="modalLogo">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <form class="form-horizontal" action="#">
                    <div class="input-group input-group-sm">
                        <input type="file" name="file"  id="file" class="form-control">
                        <span class="input-group-append">
                        <button type="submit" class="btn btn-default btn-flat" name="btnLogo" id="btnLogo"><i class="fa fa-upload"></i></button>
                        </span>
                    </div>
                </form>   
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('.logo').click(function (){
        $('#modalLogo').modal('show');
        return false;
    });

    $(document).on('click','#btnLogo',function(e){
            e.preventDefault();
            if ($('#file').val()!=''){
                var form_data = new FormData();
                form_data.append('file', $('#file').prop('files')[0]);
                $.ajax({
                    type    : "POST",
                    dataType : "json",
                    url: 'company/change_logo',
                    data: form_data,
                    cache: false,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $(".logo").LoadingOverlay("show");
                        $('#modalLogo').modal('hide');
                    },success: function(json){
                        $(".logo").LoadingOverlay("hide");
                        $('#file').val('');
                        if (json.alert=='Error'){
                            toastr.error(json.message);
                        }else if (json.alert=='Warning'){
                            toastr.warning(json.message);
                        }else if (json.alert=='Success'){
                            $('#modalLogo').modal('hide');
                            toastr.success(json.message);
                            $(".logo").html(json.img);
                        }
                    }
                });
            }
        });
</script>
@endsection
