function actionForm(name_form){
    $(name_form).validate({
                rules: {
                    cmbCat:{required: true},
                    txtCode:{required: true,maxlength: 7},
                    txtLabel:{required: true,maxlength: 100},
                    txtLabel2:{required: true,maxlength: 100}
                },
                messages: {
                    cmbCat:{
                            required: "Silakan pilih kategori."
                            },
                    txtCode:{
                            required: "Silakan isi kode.",
                            maxlength: $.validator.format( "Kode max 7 karakter." )
                            },
                    txtLabel:{
                            required: "Silakan isi nama akun.",
                            maxlength: $.validator.format( "Nama akun max 100 karakter." )
                            },
                    txtLabel2:{
                            required: "Silakan isi nama akun #2.",
                            maxlength: $.validator.format( "Nama akun #2 max 100 karakter." )
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
                                url     : base_url+'/master/account/action',
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
                                        location.href=json.message;
                                    }
                                }
                            });
                    });
                }
    });
}

function myAcc(){
	$('#dataDisplays').flexigrid({
    		url: base_url+"/master/account/getdata",
    		dataType: 'json',
            buttons : [ {name : '<i class="fa fa-plus fa-xs"></i>',tooltip:'Y011',bclass : 'btn btn-primary btn-xs',onpress : btnAction},
                        {name : '<i class="fa fa-edit fa-xs"></i>',tooltip:'Y012',bclass : 'btn btn-primary btn-xs',onpress : btnAction},
                        {name : '<i class="fa fa-lock fa-xs"></i>',bclass : 'btn btn-primary btn-xs',onpress : btnAction}
            ],
    		colModel : [
                {display: 'Kode', name : 'tbl_acc_full.acc_code',width:80, sortable : true, align: 'left'},
                {display: 'Nama Akun', name : 'tbl_acc_full.acc_label',width:500, sortable : true, align: 'left'},
                {display: 'Kategori Akun', name : 'tbl_acc_full.acc_label_oth',width:300, sortable : true, align: 'left'},
                {display: 'Segment', name : 'tbl_acc_full.segment',width:100, sortable : true, align: 'left'},
                {display: 'Status', name : 'tbl_acc_full.acc_status',width:80, sortable : true, align: 'left'},
                {display: 'Perusahaan', name : 'tbl_acc_full.com_code',width:100, sortable : true, align: 'left'}
            ],
    		searchitems : false,
    		sortname: 'tbl_acc_full.acc_code',
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
		$('#dataDisplays').flexOptions({ query: $(".dataSearch").val(),qtype: $("#cmbKey").val(), rp: 10,sortname: 'tbl_acc_full.acc_code', sortorder: 'asc' }).flexReload();
        return false;
	});
}

function btnAction(action,grid) {
    var ID=$('.trSelected',grid).children('td').eq(0).text();
    var Status=$('.trSelected',grid).children('td').eq(4).text();
    if (action == '<i class="fa fa-plus fa-xs"></i>') {
        cekTcode('Y011','',false);
    }else if (action == '<i class="fa fa-edit fa-xs"></i>') {
        if ($('.trSelected',grid).length != 1) {
            toastr.warning('Data belum dipilih.');
        }else{
            cekTcode('Y012','?code='+ID,false);
        }
    }else if (action == '<i class="fa fa-lock fa-xs"></i>') {
        if ($('.trSelected',grid).length != 1) {
            toastr.warning('Data belum dipilih.');
        }else{
            statusUser(Status,ID);
        }
    }
}

function statusUser(Status,code){
    if (Status=='Enabled'){
        var updateStatus='Disabled';
    }else if (Status=='Aktif'){
        var updateStatus='Disabled';
    }else{
        var updateStatus='Enabled';
    }
    
    $.ajax({
        type    : "POST",
        dataType : "json",
        url     : base_url+'/master/account/action',
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