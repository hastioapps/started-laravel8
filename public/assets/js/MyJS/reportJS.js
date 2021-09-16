function actionForm(){
    $('#formReport').validate({
                highlight: function (element, errorClass, validClass) {
                  $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                  $(element).removeClass('is-invalid');
                },
                submitHandler: function() {
                            $.ajax({
                                type    : "POST",
                                dataType : "json",
                                url     : base_url+"/reports/action",
                                data    : $('#formReport').serialize(),
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
                }
    });
}

function journalView(code) {
        $('#modalDisplays').modal('show');
            $.ajax({
                type    : "POST",
                url     : base_url+"/journal_entries/views",
                data    : "code="+code,
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


function selectGroupReport(){
    $(document).on('change','#cmbGroup', function () {
        var group=$('#cmbGroup').val();
        $.ajax({
                type    : "POST",
                url     : base_url+"/reports/action",
                data    : 'btnReport='+group,
                success : function(data){
                    $("#cmbReport").html(data);
                }
        });
    });
}

function selectReport(){
    $(document).on('change','#cmbReport', function () {
        var report=$('#cmbReport').val();
        document.location.href=base_url+'/'+report;
    });
}

function myReport(){
	$('#dataDisplays').flexigrid({
    		url: base_url+"/reports/getdata",
    		dataType: 'json',
            buttons : [ {name : '<i class="fa fa-folder-open fa-xs"></i>',tooltip:'Buka',bclass : 'btn btn-primary btn-xs',onpress : btnAction},
                        {name : '<i class="fa fa-file-pdf fa-xs"></i>',tooltip:'Pdf',bclass : 'btn btn-primary btn-xs',onpress : btnAction},
                        {name : '<i class="fa fa-file-excel fa-xs"></i>',tooltip:'Excel',bclass : 'btn btn-primary btn-xs',onpress : btnAction},
                        {name : '<i class="fa fa-file fa-xs"></i>',tooltip:'Txt',bclass : 'btn btn-primary btn-xs',onpress : btnAction},
                        {name : '<i class="fa fa-trash fa-xs"></i>',tooltip:'Hapus',bclass : 'btn btn-danger btn-xs',onpress : btnAction}
            ],
    		colModel : [
                {display: 'Request ID', name : 'req_id',width:200, sortable : true, align: 'left', process: celDivAction},
                {display: 'Tcode', name : 'tcode_id',width:80, sortable : true, align: 'left', process: celDivAction},
                {display: 'Parameters', name : 'req_parameters',width:500, sortable : true, align: 'left', process: celDivAction},
                {display: 'Pengguna', name : 'user_id',width:100, sortable : true, align: 'left', process: celDivAction},
                {display: 'Perusahaan', name : 'com_code',width:100, sortable : true, align: 'left', process: celDivAction}
            ],
    		searchitems : false,
    		sortname: 'req_id',
    		sortorder: 'desc',
    		usepager: true,
    		title: false,
    		useRp: false,
    		rp: 6,
            height:250,
            resizable: false,
            autoload: true,
            singleSelect: true,
            procmsg: 'please wait ...'
		}
	);
}

function celDivAction(celDiv) {
    $( celDiv ).dblclick( function() {
        var id = $(this).parent().parent().children('td').eq(0).text();
        var tcode=$(this).parent().parent().children('td').eq(1).text();
        cekTcode(tcode,'?id='+id,'false');
    });    
}

function btnAction(action,grid) {
    var id=$('.trSelected',grid).children('td').eq(0).text();
    var tcode=$('.trSelected',grid).children('td').eq(1).text();
    if (action == '<i class="fa fa-folder-open fa-xs"></i>') {
        if ($('.trSelected',grid).length != 1) {
            toastr.warning('Data belum dipilih.');
        }else{
            cekTcode(tcode,'?id='+id,'false');
        }
    }else if (action == '<i class="fa fa-file-pdf fa-xs"></i>') {
        if ($('.trSelected',grid).length != 1) {
            toastr.warning('Data belum dipilih.');
        }else{
            cekTcode(tcode,'/output?format=pdf&id='+id,'false');
        }
    }else if (action == '<i class="fa fa-file-excel fa-xs"></i>') {
        if ($('.trSelected',grid).length != 1) {
            toastr.warning('Data belum dipilih.');
        }else{
            cekTcode(tcode,'/output?format=excel&id='+id,'false');
        }
    }else if (action == '<i class="fa fa-file fa-xs"></i>') {
        if ($('.trSelected',grid).length != 1) {
            toastr.warning('Data belum dipilih.');
        }else{
            cekTcode(tcode,'/output?format=txt&id='+id,'false');
        }
    }else if (action == '<i class="fa fa-trash fa-xs"></i>') {
        $.ajax({
                                type    : "POST",
                                dataType : "json",
                                url     : base_url+"/reports/action",
                                data    : "btnDelete=true",
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
                                        $('#dataDisplays').flexReload();
                                    }
                                }
         });
    }
}