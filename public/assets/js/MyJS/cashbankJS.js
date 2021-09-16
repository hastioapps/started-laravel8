function actionForm(){
    $('#form-journal').validate({
                highlight: function (element, errorClass, validClass) {
                  $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                  $(element).removeClass('is-invalid');
                },
                submitHandler: function() {
                    var dataForm=$('#form-journal').serialize();
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
                                url     : base_url+"/journal_entries/cash_bank/action",
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

function col_del(){
    $(document).on('click','#col-del', function () {
        $(this).parents(".data-journal").remove();
    });
}

function col_add(line){
    $(document).on('click','#col-add', function () {
        line ++;
        if (line<501){
            $('#col-journal').append(
                '<tr class="data-journal">'
                +'<td style="text-align: left; width: 9%;padding: 0rem;"><input type="hidden" name="line[]" value="'+line+'" id="txtLine"><input type="hidden" name="txtCf_'+line+'" id="txtCf" class="txtCf_'+line+'"><input type="text" maxlength="7" class="form-control form-control-sm txtCode_'+line+'" name="txtCode_'+line+'" id="txtCode" value=""></td>'
                +'<td style="text-align: left; width: 1%;padding: 0rem;"><button class="form-control form-control-sm" type="button" id="search_acc"><i class="fa fa-list"></i></button></td>'
                +'<td style="text-align: left; width: 20%;padding: 0rem;"><input  class="form-control form-control-sm txtAcc_'+line+'" name="txtAcc_'+line+'" id="txtAcc" type="text" readonly></td>'
                +'<td style="text-align: left; width: 5%;padding: 0rem;"><input type="text" maxlength="4" class="form-control form-control-sm txtSegment_'+line+'" name="txtSegment_'+line+'" id="txtSegment" readonly></td>'
                +'<td style="text-align: left; width: 20%;padding: 0rem;"><input type="text" class="form-control form-control-sm txtMemo_'+line+'" maxlength="200" name="txtMemo_'+line+'" id="txtMemo" readonly></td>'
                +'<td style="text-align: right; width: 20%;padding: 0rem;"><input type="text" style="text-align: right;"  maxlength="16" class="form-control form-control-sm txtAmount_'+line+'" name="txtAmount_'+line+'" value="0.00" id="txtAmount" onBlur="this.value=roundValue(this.value);" readonly></td>'
                +'<td style="text-align: left; width: 5%;padding: 0rem;"><button class="form-control form-control-sm" type="button" id="col-del"><i class="fa fa-trash"></i></button></td>'
                +'</tr>'
            );
            $('.txtCode_'+ line).focus();
        }else{
            toastr.warning('Anda sudah mencapai batas maksimal kolom.');
        }
    });
}

function myGeneral(){
	$('#dataDisplays').flexigrid({
    		url: base_url+"/journal_entries/cash_bank/getdata",
    		dataType: 'json',
            buttons : [ 
                        {name : '<i class="fa fa-arrow-alt-circle-up fa-xs"></i>',tooltip:'A021',bclass : 'btn btn-primary btn-xs',onpress : btnAction},
                        {name : '<i class="fa fa-arrow-alt-circle-down fa-xs"></i>',tooltip:'A022',bclass : 'btn btn-primary btn-xs',onpress : btnAction},
                        {name : '<i class="fa fa-arrows-alt-h fa-xs"></i>',tooltip:'A023',bclass : 'btn btn-primary btn-xs',onpress : btnAction},
                        {name : '<i class="fa fa-folder-open fa-xs"></i>',bclass : 'btn btn-primary btn-xs',onpress : btnAction}
            ],
    		colModel : [
                        {display: 'Tgl. Dokumen', name : 'date_doc',width:80, sortable : true, align: 'left', process: celDivAction},
                        {display: 'Batch', name : 'batch',width:130, sortable : true, align: 'left', process: celDivAction},
                        {display: 'Dokumen', name : 'doc',width:120, sortable : true, align: 'left', process: celDivAction},
                        {display: 'ID Pengguna', name : 'user_id',width:80, sortable : true, align: 'left', process: celDivAction},
                        {display: 'Debit', name : 'hjour_db',width:150, sortable : false, align: 'right', process: celDivAction},
                        {display: 'Kredit', name : 'hjour_cr',width:150, sortable : false, align: 'right', process: celDivAction},
                        {display: 'Kategori', name : 'cj_code',width:50, sortable : true, align: 'left', process: celDivAction},
                        {display: 'Status', name : 'hjour_status',width:100, sortable : true, align: 'left', process: celDivAction},
                        {display: 'Area Bisnis', name : 'ba_code',width:50, sortable : false, align: 'left', process: celDivAction},
                        {display: 'Perusahaan', name : 'com_code',width:50, sortable : false, align: 'left', process: celDivAction}
                        ],
            searchitems : false,
            sortname: 'hjour_date_entry',
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
		$('#dataDisplays').flexOptions({ query: $(".dataSearch").val(),qtype: $("#cmbKey").val(), rp: 10,sortname: 'hjour_date_entry', sortorder: 'desc' }).flexReload();
        return false;
	});
}

function btnAction(action,grid) {
    var code=$('.trSelected',grid).children('td').eq(1).text();
    if (action == '<i class="fa fa-arrow-alt-circle-up fa-xs"></i>') {
        cekTcode('A021','',false);
    }else if (action == '<i class="fa fa-arrow-alt-circle-down fa-xs"></i>') {
        cekTcode('A022','',false);
    }else if (action == '<i class="fa fa-arrows-alt-h fa-xs"></i>') {
        cekTcode('A023','',false);
    }else if (action == '<i class="fa fa-folder-open fa-xs"></i>') {
        if ($('.trSelected',grid).length != 1) {
            toastr.warning('Data belum dipilih.');
        }else{
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
    }
}

function celDivAction(celDiv) {
    $( celDiv ).dblclick( function() {
        var code = $(this).parent().parent().children('td').eq(1).text();
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
    });
}

function total_amount(){
    var totAmount=0;
    for(var i=0;i<501;i++){
        var data=$('.txtAmount_'+i).val();
        if (data != null){
            var dataDr=data*1;
            var totAmount=dataDr+totAmount*1;
        }
    }
    return totAmount;
}

function search_segment(){
    $(document).on('change','#txtSegment', function () {
        var segment=$(this).parents('.data-journal').children('td').children('#txtSegment').val();
        var line=$(this).parents('.data-journal').children('td').children('#txtLine').val();
        $.ajax({
            type    : "POST",
            url : base_url+'/setting_up/segment/action',
            data    : "search_segment="+segment,
            dataType : "json",
            success : function(json){
                if (json.alert=='Error'){
                    toastr.error(json.message);
                    $('.txtSegment_'+line).val('');
                    $('.txtSegment_'+line).focus();
                }else if (json.alert=='Warning'){
                    toastr.warning(json.message);
                    $('.txtSegment_'+line).val('');
                    $('.txtSegment_'+line).focus();
                }else if (json.alert=='Session'){
                    toastr.error(json.message);
                    setTimeout(function (){location.href=base_url+"/auth/login";},1000);
                }else if (json.alert=='Success'){
                    $('.txtSegment_'+line).val(json.message);
                    $('.txtMemo_'+line).focus();
                }
            }
        });
        return false;
    });
}

function cashAccount(){
    $('#dataDisplays').flexigrid({
            url: base_url+"/master/account/acccash",
            dataType: 'json',
            buttons : [ {name : '<i class="fa fa-plus fa-xs"></i>',bclass : 'btn btn-primary btn-xs',onpress : btnActionAcc}
            ],
            colModel : [
                {display: 'Kode', name : 'acc_code',width:80, sortable : true, align: 'left', process: celDivActionAcc},
                {display: 'Nama Akun', name : 'acc_label',width:400, sortable : true, align: 'left', process: celDivActionAcc}
            ],
            searchitems : false,
            sortname: 'acc_code',
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
        $('#dataDisplays').flexOptions({ query: $(".dataSearch").val(), rp: 10,sortname: 'acc_code', sortorder: 'asc' }).flexReload();
        return false;
    });
}

function celDivActionAcc(celDiv) {
    $( celDiv ).dblclick( function() {
        var code = $(this).parent().parent().children('td').eq(0).text();
        var line=$('#col-line').val();
        checkAccCash(code,line);
    });    
}

function btnActionAcc(action,grid) {
    var code=$('.trSelected',grid).children('td').eq(0).text();
    var line=$('#col-line').val();
    if (action == '<i class="fa fa-plus fa-xs"></i>') {
        if ($('.trSelected',grid).length != 1) {
            toastr.warning('Data belum dipilih.');
        }else{
            checkAccCash(code,line);
        }
    }
}

function account_search(){
    $(document).on('click','#search_acc', function () {
        var line=$(this).parents('.data-journal').children('td').children('#txtLine').val();
        $('#col-line').val(line);
        $('#modalDisplays').modal('show');
        cashAccount();
    });
}

function account_add(){
    $(document).on('change','#txtCode', function () {
        var line=$(this).parents('.data-journal').children('td').children('#txtLine').val();
        var code=$(this).parents('.data-journal').children('td').children('#txtCode').val();
        checkAccCash(code,line);
    });
}


function checkAccCash(code,line){
    $.ajax({
            type    : "POST",
            url     : base_url+'/master/account/action',
            data    : "checkAccCash="+code,
            dataType : "json",  
            success : function(json){
                var desc=json.desc;
                if (json.alert=='Error'){
                    toastr.error(json.message);
                }else if (json.alert=='Session'){
                    toastr.error(json.message);
                    setTimeout(function (){location.href=base_url+"/auth/login";},1000);
                }else if (json.alert=='Warning'){
                    $('#col-line').val(line);
                    $('.txtCode_'+line).val('');
                    $('.txtAcc_'+line).val('');
                    $('.txtAmount_'+line).attr('readonly','readonly');
                    $('.txtAmount_'+line).val('0.00');
                    $('.txtCf_'+line).val('');
                    $('.txtMemo_'+line).attr('readonly','readonly');
                    $('.txtSegment_'+line).attr('readonly','readonly');
                    $('.txtSegment_'+line).removeAttr('required','required');
                    $('#modalDisplays').modal('show');
                    cashAccount();
                }else{
                    $('.txtCode_'+line).val(code);
                    $('.txtAcc_'+line).val(desc);
                    $('.txtAmount_'+line).removeAttr('readonly','readonly');
                    $('.txtCf_'+line).val(json.cf);
                    $('.txtMemo_'+line).removeAttr('readonly','readonly');
                    if (json.key=='Yes'){
                        $('.txtSegment_'+line).removeAttr('readonly','readonly');
                        $('.txtSegment_'+line).removeAttr('required','required');
                        $('.txtSegment_'+line).focus();
                    }else if (json.key=='Required'){
                        $('.txtSegment_'+line).removeAttr('readonly','readonly');
                        $('.txtSegment_'+line).attr('required','required');
                        $('.txtSegment_'+line).focus();
                    }else{
                        $('.txtSegment_'+line).attr('readonly','readonly');
                        $('.txtSegment_'+line).removeAttr('required','required');
                        $('.txtMemo_'+line).focus();
                        $('.txtSegment_'+line).val('');
                    }
                    $('#modalDisplays').modal('hide');
                }
            }
    });
}
