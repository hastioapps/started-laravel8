function actionForm(){
    $('#form-journal').validate({
                /*rules: {
                    txtTotDr:{equalTo: "#txtTotCr"},
                    txtTotCr:{equalTo: "#txtTotDr"}
                },
                messages: {
                    txtTotDr:{equalTo: "Data tidak sama."},
                    txtTotCr:{equalTo: "Data tidak sama."}
                },*/
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
                                url     : base_url+"/journal_entries/general/action",
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
        $('#txtTotDr').val(roundValue(total_debit()));
        $('#txtTotCr').val(roundValue(total_credit()));
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
                +'<td style="text-align: right; width: 20%;padding: 0rem;"><input type="text" style="text-align: right;"  maxlength="16" class="form-control form-control-sm txtDr_'+line+'" name="txtDr_'+line+'" value="0.00" id="txtDr" onBlur="this.value=roundValue(this.value);" readonly></td>'
                +'<td style="text-align: right; width: 20%;padding: 0rem;"><input type="text" style="text-align: right;"  maxlength="16" class="form-control form-control-sm txtCr_'+line+'" name="txtCr_'+line+'" value="0.00" id="txtCr" onBlur="this.value=roundValue(this.value);" readonly></td>'
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
    		url: base_url+"/journal_entries/general/getdata",
    		dataType: 'json',
            buttons : [ 
                        {name : '<i class="fa fa-plus fa-xs"></i>',tooltip:'A011',bclass : 'btn btn-primary btn-xs',onpress : btnAction},
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
    if (action == '<i class="fa fa-plus fa-xs"></i>') {
        cekTcode('A011','',false);
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

function generalAccount(){
    $('#dataDisplays').flexigrid({
            url: base_url+"/master/account/acctrx",
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
        checkAccGeneral(code,line);
    });    
}

function btnActionAcc(action,grid) {
    var code=$('.trSelected',grid).children('td').eq(0).text();
    var line=$('#col-line').val();
    if (action == '<i class="fa fa-plus fa-xs"></i>') {
        if ($('.trSelected',grid).length != 1) {
            toastr.warning('Data belum dipilih.');
        }else{
            checkAccGeneral(code,line);
        }
    }
}

function checkAccGeneral(code,line){
    $.ajax({
            type    : "POST",
            url     : base_url+'/master/account/action',
            data    : "checkAccGeneral="+code,
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
                    $('.txtDr_'+line).attr('readonly','readonly');
                    $('.txtDr_'+line).val('0.00');
                    $('.txtCr_'+line).attr('readonly','readonly');
                    $('.txtCr_'+line).val('0.00');
                    $('.txtCf_'+line).val('');
                    $('.txtMemo_'+line).attr('readonly','readonly');
                    $('.txtSegment_'+line).attr('readonly','readonly');
                    $('.txtSegment_'+line).removeAttr('required','required');
                    $('#modalDisplays').modal('show');
                    generalAccount();
                }else{
                    $('.txtCode_'+line).val(code);
                    $('.txtAcc_'+line).val(desc);
                    $('.txtDr_'+line).removeAttr('readonly','readonly');
                    $('.txtCr_'+line).removeAttr('readonly','readonly');
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


function data_debit(){
    $(document).on('input','#txtDr', function () {
        var initCr=$(this).parents('.data-journal').children('td').children('#txtDr').val();
        var dataCr=initCr*1;
        if (dataCr>0 || dataCr<0){
            $(this).parents('.data-journal').children('td').children('#txtCr').val('0.00');
            $(this).parents('.data-journal').children('td').children('#txtCr').attr('readonly','readonly');
        }else{
            $(this).parents('.data-journal').children('td').children('#txtCr').removeAttr('readonly','readonly');
        }
        $('#txtTotDr').val(roundValue(total_debit()));
        $('#txtTotCr').val(roundValue(total_credit()));
    });
}

function data_credit(){                
    $(document).on('input','#txtCr', function () {
        var initCr=$(this).parents('.data-journal').children('td').children('#txtCr').val();
        var dataCr=initCr*1;
        if (dataCr>0 || dataCr<0){
            $(this).parents('.data-journal').children('td').children('#txtDr').val('0.00');
            $(this).parents('.data-journal').children('td').children('#txtDr').attr('readonly','readonly');
        }else{
            $(this).parents('.data-journal').children('td').children('#txtDr').removeAttr('readonly','readonly');
        }
        $('#txtTotDr').val(roundValue(total_debit()));
        $('#txtTotCr').val(roundValue(total_credit()));
    });
}

function total_debit(){
    var totDr=0;
    for(var i=0;i<501;i++){
        var data=$('.txtDr_'+i).val();
        if (data != null){
            var dataDr=data*1;
            var totDr=dataDr+totDr*1;
        }
    }
    return totDr;
}

function total_credit(){
    var totCr=0;
    for(var i=0;i<501;i++){
        var data=$('.txtCr_'+i).val();
        if (data != null){
            var dataCr=data*1;
            var totCr=dataCr+totCr*1;
        }
    }
    return totCr;
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

function account_search(){
    $(document).on('click','#search_acc', function () {
        var line=$(this).parents('.data-journal').children('td').children('#txtLine').val();
        $('#col-line').val(line);
        $('#modalDisplays').modal('show');
        generalAccount();
    });
}

function account_add(){
    $(document).on('change','#txtCode', function () {
        var line=$(this).parents('.data-journal').children('td').children('#txtLine').val();
        var code=$(this).parents('.data-journal').children('td').children('#txtCode').val();
        checkAccGeneral(code,line);
    });
}