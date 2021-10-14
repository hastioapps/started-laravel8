@extends('layouts.main')
@section('content')
<div class="col-lg-12">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h5 class="card-title">{{ $title ?? __('label.no_title') }}</h5>
            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 200px;">
                    <input type="text" placeholder="{{ __('button.search') }}..." class="form-control float-right dataSearch">
                    <select name="cmbKey" id="cmbKey" class="form-control">
                        <option value="code">{{ __('label.code') }}</option>
                        <option value="name">{{ __('label.name') }}</option>
                        <option value="status">Status</option>
                    </select>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-default" id="btnSearch"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <table id="dataDisplays" style="display:none"></table>
    </div>        	
</div>

<div class="modal fade" id="modalDisplays">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('label.displays') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body dataModal"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function (){
		$('#dataDisplays').flexigrid({
    		url: '{{ url("branches/flexigrid") }}',
    		dataType: 'json',
            buttons : [ {name : '<i class="fa fa-plus fa-xs"></i>',tooltip:'{{ __("button.create") }}',bclass : 'btn btn-primary btn-xs',onpress : btnAction},
                        {name : '<i class="fa fa-edit fa-xs"></i>',tooltip:'{{ __("button.edit") }}',bclass : 'btn btn-primary btn-xs',onpress : btnAction},
                        {name : '<i class="fa fa-lock fa-xs"></i>',tooltip:'Status',bclass : 'btn btn-primary btn-xs',onpress : btnAction},
                        {name : '<i class="fa fa-folder-open fa-xs"></i>',tooltip:'{{ __("button.open") }}',bclass : 'btn btn-primary btn-xs',onpress : btnAction}
            ],
    		colModel : [
                {display: '{{ __("label.code") }}', name : 'code',width:100, sortable : true, align: 'left', process: celDivAction},
                {display: '{{ __("label.branch") }}', name : 'name',width:400, sortable : true, align: 'left', process: celDivAction},
                {display: 'Phone', name : 'phone',width:250, sortable : true, align: 'left', process: celDivAction},
                {display: 'Email', name : 'email',width:200, align: 'left', process: celDivAction},
                {display: 'Status', name : 'status',width:80, align: 'left', process: celDivAction}
            ],
    		searchitems : false,
    		sortname: 'code',
    		sortorder: 'asc',
    		usepager: true,
    		title: false,
    		useRp: false,
    		rp: 10,
            height:320,
            resizable: false,
            autoload: true,
            singleSelect: true,
            procmsg: 'please wait ...'
            }
        );

        $('#btnSearch').click(function(){
            $('#dataDisplays').flexOptions({ query: $(".dataSearch").val(),qtype: $("#cmbKey").val(), rp: 10,sortname: 'code', sortorder: 'asc' }).flexReload();
            return false;
        });

        function celDivAction(celDiv) {
            $( celDiv ).dblclick( function() {
                var id = $(this).parent().parent().children('td').eq(0).text();
                $('#modalDisplays').modal('show');
                $.ajax({
                        type    : "POST",
                        url     : '{{ url("branches/show") }}',
                        data    : "id="+id,
                        beforeSend: function () {
                            $(".dataModal").LoadingOverlay("show");
                            $(".dataModal").html('');      
                        },
                        success : function(data){
                            $(".dataModal").LoadingOverlay("hide");
                            $(".dataModal").html(data);            
                        }
                });
            });    
        }

        function btnAction(action,grid) {
            var id=$('.trSelected',grid).children('td').eq(0).text();
            var status=$('.trSelected',grid).children('td').eq(4).text();
            if (action == '<i class="fa fa-plus fa-xs"></i>') {
                document.location.href='branches/create';
            }else if (action == '<i class="fa fa-edit fa-xs"></i>') {
                if ($('.trSelected',grid).length != 1) {
                    toastr.warning('{{ __("alert.data_not_selected") }}');
                }else{
                    document.location.href='branches/'+id+'/edit';
                }
            }else if (action == '<i class="fa fa-folder-open fa-xs"></i>') {
                if ($('.trSelected',grid).length != 1) {
                    toastr.warning('{{ __("alert.data_not_selected") }}');
                }else{
                    $('#modalDisplays').modal('show');
                    $.ajax({
                        type    : "POST",
                        url     : '{{ url("branches/show") }}',
                        data    : "id="+id,
                        beforeSend: function () {
                            $(".dataModal").LoadingOverlay("show");
                            $(".dataModal").html('');      
                        },
                        success : function(data){
                            $(".dataModal").LoadingOverlay("hide");
                            $(".dataModal").html(data);            
                        }
                    });
                }
            }else if (action == '<i class="fa fa-lock fa-xs"></i>') {
                if ($('.trSelected',grid).length != 1) {
                    toastr.warning('{{ __("alert.data_not_selected") }}');
                }else{
                    $.ajax({
                        type    : "POST",
                        dataType  : "json",
                        url     : '{{ url("branches/status") }}',
                        data    : "id="+id+"&status="+status,
                        success : function(json){
                            if (json.alert=='Error'){
                                toastr.error(json.message);
                            }else if (json.alert=='Warning'){
                                toastr.warning(json.message);
                            }else if (json.alert=='Success'){
                                toastr.success(json.message);
                                $('#dataDisplays').flexReload();
                                return false;
                            }
                        }
                    });
                }
            }
        }
	});
</script>
@endsection