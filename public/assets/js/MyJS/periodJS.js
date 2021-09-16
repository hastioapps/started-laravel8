function actionPeriod(name_form){
    $(name_form).validate({
                rules: {
                    cmbMonth:{required: true},
                    cmbYears:{required: true}
                },
                messages: {
                    cmbMonth:{
                            required: "Silakan pilih bulan."
                            },
                    cmbYears:{
                            required: "Silakan pilih tahun."
                            }
                },
                highlight: function (element, errorClass, validClass) {
                  $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                  $(element).removeClass('is-invalid');
                },
                submitHandler: function() {
                    var dataForm=$(name_form).serialize();
                    swal({
                            title: "",
                            text: 'Data akan disimpan...!!!',
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3071a9",
                            confirmButtonText: "Ya",
                            cancelButtonText: "Tidak",
                            closeOnConfirm: false,
                            showLoaderOnConfirm:true
                    },
                    function(){
                            $.ajax({
                                type    : "POST",
                                dataType : "json",
                                url     : base_url+'/setting_up/period/action',
                                data    : dataForm,
                                success : function(json){
                                    if (json.alert=='Error'){
                                        toastr.error(json.message);
                                        swal.close();
                                    }else if (json.alert=='Warning'){
                                        toastr.warning(json.message);
                                        swal.close();
                                    }else if (json.alert=='Session'){
                                        toastr.error(json.message);
                                        setTimeout(function (){location.href=base_url+"/auth/login";},1000);
                                    }else if (json.alert=='Success'){
                                        $('#modalDisplays').modal('hide');
                                        swal.close();
                                        $('#dataDisplays').flexReload();
                                        toastr.success(json.message);
                                    }
                                }
                            });
                    });
                }
    });
}

function myPeriod(){
	$('#dataDisplays').flexigrid({
    		url: base_url+"/setting_up/period/getdata",
    		dataType: 'json',
            buttons : [ {name : '<i class="fa fa-plus fa-xs"></i>',bclass : 'btn btn-primary btn-xs',onpress : btnAction},
                        {name : '<i class="fa fa-lock fa-xs"></i>',bclass : 'btn btn-primary btn-xs',onpress : btnAction} /*,
                        {name : '<i class="fa fa-book fa-xs"></i>',bclass : 'btn btn-primary btn-xs',onpress : btnAction}*/
            ],
    		colModel : [
                {display: 'Periode', name : 'period_doc',width:150, sortable : true, align: 'left'},
                {display: 'Tahun', name : 'period_years',width:100, sortable : true, align: 'left'},
                {display: 'Status', name : 'status',width:150, sortable : true, align: 'left'},
                {display: 'Perusahaan', name : 'com_code',width:100, sortable : true, align: 'left'}
            ],
    		searchitems : false,
    		sortname: 'period_doc',
    		sortorder: 'desc',
    		usepager: true,
    		title: false,
    		useRp: false,
    		rp: 10,
            height:332,
            resizable: false,
            autoload: true,
            singleSelect: true,
            procmsg: 'please wait ...'
		}
	);

	$('#btnSearch').click(function(){
		$('#dataDisplays').flexOptions({ query: $(".dataSearch").val(),qtype: $("#cmbKey").val(), rp: 10,sortname: 'period_doc', sortorder: 'desc' }).flexReload();
        return false;
	});
}

function btnAction(action,grid) {
    var ID=$('.trSelected',grid).children('td').eq(0).text();
    var Status=$('.trSelected',grid).children('td').eq(2).text();
    if (action == '<i class="fa fa-plus fa-xs"></i>') {
        $('#modalDisplays').modal('show');
    }else if (action == '<i class="fa fa-lock fa-xs"></i>') {
        if ($('.trSelected',grid).length != 1) {
            toastr.warning('Data belum dipilih.');
        }else{
            status(Status,ID);
        }
    }else if (action == '<i class="fa fa-book fa-xs"></i>') {
        if ($('.trSelected',grid).length != 1) {
            toastr.warning('Data belum dipilih.');
        }else{

        }
    }
}

function status(Status,id){
    if (Status=='Opened'){
        var updateStatus='Closed';
    }else if (Status=='Dibuka'){
        var updateStatus='Closed';
    }else{
        var updateStatus='Opened';
    }
    
    $.ajax({
        type    : "POST",
        dataType : "json",
        url     : base_url+'/setting_up/period/action',
        data    : "addStatus="+updateStatus+"&code="+id,
        success : function(json){
            if (json.alert=='Error'){
                toastr.error(json.message);
            }else if (json.alert=='Warning'){
                toastr.warning(json.message);
            }else if (json.alert=='Session'){
                toastr.error(json.message);
                setTimeout(function (){location.href=base_url+"/auth/login";},1000);
            }else if (json.alert=='Success'){
                toastr.success(json.message);
                $('#dataDisplays').flexReload();
                return false;
            }
        }
    });
}