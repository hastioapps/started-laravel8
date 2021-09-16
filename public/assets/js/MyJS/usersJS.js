function actionForm(name_form){
    $(name_form).validate({
                rules: {
                    user_id:{required: true,maxlength: 10},
                    txtName:{required: true,maxlength: 100},
                    txtPhone:{number: true,minlength: 9,maxlength: 15},
                    password:{required: true,maxlength: 20},
                    Repassword:{required: true,equalTo: "#password"}
                },
                messages: {
                    user_id:{
                            required: "Silakan isi ID pengguna.",
                            maxlength: $.validator.format( "ID pengguna max 10 karakter." )
                            },
                    txtName:{
                            required: "Silakan isi nama lengkap.",
                            maxlength: $.validator.format( "Nama lengkap max 100 karakter." )
                            },
                    txtPhone:{
                            number: "Masukan telepon dengan benar.",
                            minlength: $.validator.format( "Telepon min 9 karakter." ),
                            maxlength: $.validator.format( "Telepon max 15 karakter." )
                            },
                    password:{
                            required: "Silakan isi kata sandi.",
                            maxlength: $.validator.format( "Kata sandi max 20 karakter." )
                            },
                    Repassword:{
                            required: "Silakan isi konfirmasi kata sandi.",
                            equalTo: "Kata sandi tidak sama."
                            }
                },
                highlight: function (element, errorClass, validClass) {
                  $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                  $(element).removeClass('is-invalid');
                },submitHandler: function() {
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
                                url     : base_url+'/users/action',
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
                                        location.href=base_url+"/users?code="+json.message;
                                    }
                                }
                            });
                    });
                }
    });
}

function actionReset(name_form){
    $(name_form).validate({
                rules: {
                    user_id:{required: true,maxlength: 10},
                    txtName:{required: true,maxlength: 100},
                    password:{required: true,maxlength: 20},
                    Repassword:{required: true,equalTo: "#password"}
                },
                messages: {
                    user_id:{
                            required: "Silakan isi ID pengguna.",
                            maxlength: $.validator.format( "ID pengguna max 10 karakter." )
                            },
                    txtName:{
                            required: "Silakan isi nama lengkap.",
                            maxlength: $.validator.format( "Nama lengkap max 100 karakter." )
                            },
                    password:{
                            required: "Silakan isi kata sandi.",
                            maxlength: $.validator.format( "Kata sandi max 20 karakter." )
                            },
                    Repassword:{
                            required: "Silakan isi konfirmasi kata sandi.",
                            equalTo: "Kata sandi tidak sama."
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
                                url     : base_url+'/users/action',
                                data    : dataForm,
                                beforeSend: function () {
                                    $('#btnAdd').attr('disabled','disabled');
                                },
                                success : function(json){
                                    $('#btnAdd').removeAttr('disabled','disabled');
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
                                        toastr.success(json.message);
                                        swal.close();
                                    }
                                }
                            });
                    });
                }
    });
}

function myUsers(){
	$('#dataDisplays').flexigrid({
    		url: base_url+"/users/getdata",
    		dataType: 'json',
            buttons : [ {name : '<i class="fa fa-plus fa-xs"></i>',tooltip:'Tambah',bclass : 'btn btn-primary btn-xs',onpress : btnAction},
                        {name : '<i class="fa fa-edit fa-xs"></i>',tooltip:'Edit',bclass : 'btn btn-primary btn-xs',onpress : btnAction},
                        {name : '<i class="fa fa-key fa-xs"></i>',tooltip:'Reset',bclass : 'btn btn-primary btn-xs',onpress : btnAction},
                        {name : '<i class="fa fa-lock fa-xs"></i>',tooltip:'Status',bclass : 'btn btn-primary btn-xs',onpress : btnAction},
                        {name : '<i class="fa fa-folder-open fa-xs"></i>',tooltip:'Buka',bclass : 'btn btn-primary btn-xs',onpress : btnAction}
            ],
    		colModel : [
                {display: 'ID Pengguna', name : 'user_id',width:100, sortable : true, align: 'left', process: celDivAction},
                {display: 'Nama Lengkap', name : 'user_name',width:250, sortable : true, align: 'left', process: celDivAction},
                {display: 'Email', name : 'user_email',width:250, sortable : true, align: 'left', process: celDivAction},
                {display: 'Telepon', name : 'user_phone',width:150, sortable : true, align: 'left', process: celDivAction},
                {display: 'Level', name : 'user_key',width:100, sortable : true, align: 'left', process: celDivAction},
                {display: 'Peran', name : 'user_role',width:100, align: 'left', process: celDivAction},
                {display: 'Status', name : 'user_status',width:80, align: 'left', process: celDivAction}
            ],
    		searchitems : false,
    		sortname: 'user_id',
    		sortorder: 'asc',
    		usepager: true,
    		title: false,
    		useRp: false,
    		rp: 10,
            height:290,
            resizable: false,
            autoload: true,
            singleSelect: true,
            procmsg: 'please wait ...'
		}
	);

	$('#btnSearch').click(function(){
		$('#dataDisplays').flexOptions({ query: $(".dataSearch").val(),qtype: $("#cmbKey").val(), rp: 10,sortname: 'user_id', sortorder: 'asc' }).flexReload();
        return false;
	});
}

function celDivAction(celDiv) {
    $( celDiv ).dblclick( function() {
        var ID = $(this).parent().parent().children('td').eq(0).text();
 		document.location.href=base_url+'/users?code='+ID;
    });    
}

function btnAction(action,grid) {
    var ID=$('.trSelected',grid).children('td').eq(0).text();
    var Status=$('.trSelected',grid).children('td').eq(6).text();
    if (action == '<i class="fa fa-plus fa-xs"></i>') {
        document.location.href=base_url+'/users/add';
    }else if (action == '<i class="fa fa-edit fa-xs"></i>') {
        if ($('.trSelected',grid).length != 1) {
            toastr.warning('Data belum dipilih.');
        }else{
            document.location.href=base_url+'/users/edit?code='+ID;
        }
    }else if (action == '<i class="fa fa-key fa-xs"></i>') {
        if ($('.trSelected',grid).length != 1) {
            toastr.warning('Data belum dipilih.');
        }else{
            document.location.href=base_url+'/users/reset?code='+ID;
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
            document.location.href=base_url+'/users?code='+ID;
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
        url     : base_url+'/users/action',
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

function dualListCom(code){
    $.ajax({
        type        : "POST",
        dataType    : "json",
        url         : base_url+'/users/getcom',
        data        : "btnCom="+code,
        success     : function(data){
            var dataArray = data;
            var settings = {
                "dataArray": dataArray,
                "tabNameText": "Perusahaan",
                "rightTabNameText": "Perusahaan Aktif",
                "callable": function (items) {
                    var totalArray=items.length;
                    var data=[];
                    for (i=0;i<totalArray;i++){
                        data.push(items[i]['value']);
                    }
                    $.ajax({
                        type        : "POST",
                        dataType    : "json",
                        url         : base_url+'/users/getcom',
                        data        : {user_id:code,data:data},
                        success     : function(json){
                            if (json.alert=='Error'){
                                toastr.error(json.message);
                            }else if (json.alert=='Warning'){
                                toastr.warning(json.message);
                            }else if (json.alert=='Session'){
                                toastr.error(json.message);
                                setTimeout(function (){location.href=base_url+"/auth/login";},1000);
                            }else if (json.alert=='Success'){
                                toastr.success(json.message);
                            }
                        }
                    });
                }
            };
            $(".com").transfer(settings);
        }
    });
}

function dualListBa(code){
    $.ajax({
        type        : "POST",
        dataType    : "json",
        url         : base_url+'/users/getba',
        data        : "btnBa="+code,
        success     : function(data){
            var dataArray = data;
            var settings = {
                "dataArray": dataArray,
                "tabNameText": "Area Bisnis",
                "rightTabNameText": "Area Bisnis Aktif",
                "callable": function (items) {
                    var totalArray=items.length;
                    var data=[];
                    for (i=0;i<totalArray;i++){
                        data.push(items[i]['value']);
                    }
                    $.ajax({
                        type        : "POST",
                        dataType    : "json",
                        url         : base_url+'/users/getba',
                        data        : {user_id:code,data:data},
                        success     : function(json){
                            if (json.alert=='Error'){
                                toastr.error(json.message);
                            }else if (json.alert=='Warning'){
                                toastr.warning(json.message);
                            }else if (json.alert=='Session'){
                                toastr.error(json.message);
                                setTimeout(function (){location.href=base_url+"/auth/login";},1000);
                            }else if (json.alert=='Success'){
                                toastr.success(json.message);
                            }
                        }
                    });
                }
            };
            $(".ba").transfer(settings);
        }
    });
}

function dualListWrh(code){
    $.ajax({
        type        : "POST",
        dataType    : "json",
        url         : base_url+'/users/getwrh',
        data        : "btnWrh="+code,
        success     : function(data){
            var dataArray = data;
            var settings = {
                "dataArray": dataArray,
                "tabNameText": "Gudang",
                "rightTabNameText": "Gudang Aktif",
                "callable": function (items) {
                    var totalArray=items.length;
                    var data=[];
                    for (i=0;i<totalArray;i++){
                        data.push(items[i]['value']);
                    }
                    $.ajax({
                        type        : "POST",
                        dataType    : "json",
                        url         : base_url+'/users/getwrh',
                        data        : {user_id:code,data:data},
                        success     : function(json){
                            if (json.alert=='Error'){
                                toastr.error(json.message);
                            }else if (json.alert=='Warning'){
                                toastr.warning(json.message);
                            }else if (json.alert=='Session'){
                                toastr.error(json.message);
                                setTimeout(function (){location.href=base_url+"/auth/login";},1000);
                            }else if (json.alert=='Success'){
                                toastr.success(json.message);
                            }
                        }
                    });
                }
            };
            $(".wrh").transfer(settings);
        }
    });
}