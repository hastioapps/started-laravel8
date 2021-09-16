function actionForm(name_form){
    $(name_form).validate({
                rules: {
                    txtCode:{required: true,maxlength: 4},
                    txtName:{required: true,maxlength: 100},
                    txtAddress:{required: true},
                    txtDistricts:{required: true,maxlength: 20},
                    txtCity:{required: true,maxlength: 20},
                    txtProvince:{required: true,maxlength: 20},
                    txtCountry:{required: true,maxlength: 20},
                    txtPhone:{number: true,minlength: 9,maxlength: 15},
                    txtFax:{number: true,minlength: 9,maxlength: 15},
                    txtEmail:{email: true},
                    txtManager:{required: true,maxlength: 100}
                },
                messages: {
                    txtCode:{
                            required: "Silakan isi kode.",
                            maxlength: $.validator.format( "Kode max 4 karakter." )
                            },
                    txtName:{
                            required: "Silakan isi nama area bisnis.",
                            maxlength: $.validator.format( "Area bisnis max 100 karakter." )
                            },
                    txtAddress:{
                            required: "Silakan isi alamat."
                            },
                    txtDistricts:{
                            required: "Silakan isi kecamatan.",
                            maxlength: $.validator.format( "Kecamatan max 20 karakter." )
                            },
                    txtCity:{
                            required: "Silakan isi kota.",
                            maxlength: $.validator.format( "Kota max 20 karakter." )
                            },
                    txtProvince:{
                            required: "Silakan isi propinsi.",
                            maxlength: $.validator.format( "Propinsi max 20 karakter." )
                            },
                    txtCountry:{
                            required: "Silakan isi negara.",
                            maxlength: $.validator.format( "Negara max 20 karakter." )
                            },
                    txtPhone:{
                            number: "Masukan telepon dengan benar.",
                            minlength: $.validator.format( "Telepon min 9 karakter." ),
                            maxlength: $.validator.format( "Telepon max 15 karakter." )
                            },
                    txtFax:{
                            number: "Masukan fax dengan benar.",
                            minlength: $.validator.format( "Fax min 9 karakter." ),
                            maxlength: $.validator.format( "Fax max 15 karakter." )
                            },
                    txtEmail:{
                            email: "Masukan email dengan benar."
                            },
                    txtManager:{
                            required: "Silakan isi manager.",
                            maxlength: $.validator.format( "Manager max 100 karakter." )
                            }
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
                                url     : base_url+'/setting_up/business_area/action',
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
                                        location.href=base_url+"/setting_up/business_area";
                                    }
                                }
                            });
                    });
                }
    });
}

function myBA(){
	$('#dataDisplays').flexigrid({
    		url: base_url+"/setting_up/business_area/getdata",
    		dataType: 'json',
            buttons : [ {name : '<i class="fa fa-plus fa-xs"></i>',tooltip:'Z011',bclass : 'btn btn-primary btn-xs',onpress : btnAction},
                        {name : '<i class="fa fa-edit fa-xs"></i>',tooltip:'Z012',bclass : 'btn btn-primary btn-xs',onpress : btnAction},
                        {name : '<i class="fa fa-lock fa-xs"></i>',bclass : 'btn btn-primary btn-xs',onpress : btnAction},
                        {name : '<i class="fa fa-folder-open fa-xs"></i>',bclass : 'btn btn-primary btn-xs',onpress : btnAction}
            ],
    		colModel : [
                {display: 'Kode', name : 'ba_code',width:50, sortable : true, align: 'left', process: celDivAction},
                {display: 'Keterangan', name : 'ba_name',width:250, sortable : true, align: 'left', process: celDivAction},
                {display: 'Kota', name : 'ba_country',width:100, sortable : true, align: 'left', process: celDivAction},
                {display: 'Telepon', name : 'ba_phone',width:150, sortable : true, align: 'left', process: celDivAction},
                {display: 'Fax', name : 'ba_fax',width:150, sortable : true, align: 'left', process: celDivAction},
                {display: 'Manager', name : 'ba_manager',width:200, sortable : true, align: 'left', process: celDivAction},
                {display: 'Status', name : 'ba_status',width:80, sortable : true, align: 'left', process: celDivAction},
                {display: 'Perusahaan', name : 'com_code',width:100, sortable : true, align: 'left', process: celDivAction}
            ],
    		searchitems : false,
    		sortname: 'ba_code',
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
		$('#dataDisplays').flexOptions({ query: $(".dataSearch").val(),qtype: $("#cmbKey").val(), rp: 10,sortname: 'ba_code', sortorder: 'asc' }).flexReload();
        return false;
	});
}

function celDivAction(celDiv) {
    $( celDiv ).dblclick( function() {
        var ID = $(this).parent().parent().children('td').eq(0).text();
 		$('#modalDisplays').modal('show');
        $.ajax({
            type    : "POST",
            url     : base_url+"/setting_up/business_area/views",
            data    : "code="+ID,
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
    var ID=$('.trSelected',grid).children('td').eq(0).text();
    var Status=$('.trSelected',grid).children('td').eq(6).text();
    if (action == '<i class="fa fa-plus fa-xs"></i>') {
        cekTcode('Z011','',false);
    }else if (action == '<i class="fa fa-edit fa-xs"></i>') {
        if ($('.trSelected',grid).length != 1) {
            toastr.warning('Data belum dipilih.');
        }else{
            cekTcode('Z012','?code='+ID,false);
        }
    }else if (action == '<i class="fa fa-lock fa-xs"></i>') {
        if ($('.trSelected',grid).length != 1) {
            toastr.warning('Data belum dipilih.');
        }else{
            statusUser(Status,ID);
        }
    }else if (action == '<i class="fa fa-folder-open fa-xs"></i>') {
        if ($('.trSelected',grid).length != 1) {
            toastr.warning('Data belum dipilih.');
        }else{
            $('#modalDisplays').modal('show');
            $.ajax({
                type    : "POST",
                url     : base_url+"/setting_up/business_area/views",
                data    : "code="+ID,
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
    }
}

function statusUser(Status,id){
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
        url     : base_url+'/setting_up/business_area/action',
        data    : "addStatus="+updateStatus+"&id="+id,
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