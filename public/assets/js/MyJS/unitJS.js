function actionUnit(name_form){
    $(name_form).validate({
                rules: {
                    txtCode:{required: true,maxlength: 4},
                    txtLabel:{required: true,maxlength: 100}
                },
                messages: {
                    txtCode:{
                            required: "Silakan isi kode.",
                            maxlength: $.validator.format( "Kode max 4 karakter." )
                            },
                    txtLabel:{
                            required: "Silakan isi keterangan.",
                            maxlength: $.validator.format( "Keterangan max 100 karakter." )
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
                                url     : base_url+'/setting_up/unit/action',
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

function myUnit(){
	$('#dataDisplays').flexigrid({
    		url: base_url+"/setting_up/unit/getdata",
    		dataType: 'json',
            buttons : [ {name : '<i class="fa fa-plus fa-xs"></i>',bclass : 'btn btn-primary btn-xs',onpress : btnAction},
                        {name : '<i class="fa fa-edit fa-xs"></i>',bclass : 'btn btn-primary btn-xs',onpress : btnAction},
                        {name : '<i class="fa fa-lock fa-xs"></i>',bclass : 'btn btn-primary btn-xs',onpress : btnAction}
            ],
    		colModel : [
                {display: 'Kode', name : 'unit_code',width:100, sortable : true, align: 'left'},
                {display: 'Keterangan', name : 'unit_label',width:300, sortable : true, align: 'left'},
                {display: 'Status', name : 'unit_status',width:150, sortable : true, align: 'left'},
                {display: 'Perusahaan', name : 'com_code',width:100, sortable : true, align: 'left'}
            ],
    		searchitems : false,
    		sortname: 'unit_code',
    		sortorder: 'asc',
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
		$('#dataDisplays').flexOptions({ query: $(".dataSearch").val(),qtype: $("#cmbKey").val(), rp: 10,sortname: 'unit_code', sortorder: 'asc' }).flexReload();
        return false;
	});
}

function btnAction(action,grid) {
    var code=$('.trSelected',grid).children('td').eq(0).text();
    var label=$('.trSelected',grid).children('td').eq(1).text();
    var status=$('.trSelected',grid).children('td').eq(2).text();
    if (action == '<i class="fa fa-plus fa-xs"></i>') {
        $('#modalDisplays').modal('show');
        $('#txtCode').val('');
        $('#txtLabel').val('');
        $('#txtCode').removeAttr('readonly','readonly');
    }else if (action == '<i class="fa fa-edit fa-xs"></i>') {
        if ($('.trSelected',grid).length != 1) {
            toastr.warning('Data belum dipilih.');
        }else{
            $('#modalDisplays').modal('show');
            $('#txtCode').val(code);
            $('#txtLabel').val(label);
            $('#txtCode').attr('readonly','readonly');
        }
    }else if (action == '<i class="fa fa-lock fa-xs"></i>') {
        if ($('.trSelected',grid).length != 1) {
            toastr.warning('Data belum dipilih.');
        }else{
            change_status(status,code);
        }
    }
}

function change_status(status,code){
    if (status=='Enabled'){
        var updateStatus='Disabled';
    }else if (status=='Aktif'){
        var updateStatus='Disabled';
    }else{
        var updateStatus='Enabled';
    }
    
    $.ajax({
        type    : "POST",
        dataType : "json",
        url     : base_url+'/setting_up/unit/action',
        data    : "addStatus="+updateStatus+"&code="+code,
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