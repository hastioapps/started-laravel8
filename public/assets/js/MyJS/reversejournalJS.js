function myGeneral(){
	$('#dataDisplays').flexigrid({
    		url: base_url+"/journal_entries/reverse/getdata",
    		dataType: 'json',
            buttons : [ {name : '<i class="fa fa-plus fa-xs"></i>',bclass : 'btn btn-primary btn-xs',onpress : btnAction}
            ],
    		colModel : [
                        {display: 'Tgl. Reversal', name : 'hjour_date_reverse',width:80, sortable : true, align: 'left', process: celDivAction},
                        {display: 'Tgl. Dokumen', name : 'date_doc',width:80, sortable : true, align: 'left', process: celDivAction},
                        {display: 'Batch', name : 'batch',width:130, sortable : true, align: 'left', process: celDivAction},
                        {display: 'Dokumen', name : 'doc',width:120, sortable : true, align: 'left', process: celDivAction},
                        {display: 'Reversal Oleh', name : 'user_id_reverse',width:80, sortable : true, align: 'left', process: celDivAction},
                        {display: 'Alasan', name : 'hjour_reason_reverse',width:200, sortable : true, align: 'left', process: celDivAction},
                        {display: 'Debit', name : 'hjour_db',width:150, sortable : false, align: 'right', process: celDivAction},
                        {display: 'Kredit', name : 'hjour_cr',width:150, sortable : false, align: 'right', process: celDivAction},
                        {display: 'Kategori', name : 'cj_code',width:50, sortable : true, align: 'left', process: celDivAction},
                        {display: 'Area Bisnis', name : 'ba_code',width:50, sortable : false, align: 'left', process: celDivAction},
                        {display: 'Perusahaan', name : 'com_code',width:50, sortable : false, align: 'left', process: celDivAction}
                        ],
            searchitems : false,
            sortname: 'hjour_date_reverse',
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
		$('#dataDisplays').flexOptions({ query: $(".dataSearch").val(),qtype: $("#cmbKey").val(), rp: 10,sortname: 'hjour_date_reverse', sortorder: 'desc' }).flexReload();
        return false;
	});
}

function btnAction() {
    addReverse();
}

function actionReverse(batch,period){
    swal({
        title: '',
        text: 'Kenapa batch ini dibatalkan:',
        type: "input",
        showCancelButton: true,
        closeOnConfirm: false,
        animation: "slide-from-top",
        inputPlaceholder: 'Alasan...',
        showLoaderOnConfirm:true
    },function(inputValue){
        if (inputValue === false) return false;
        if (inputValue === "") {
            swal.showInputError('Alasan tidak boleh kosong...!!!');
            return false;
        }
        $.ajax({
            type    : "POST",
            dataType : "json",
            url     : base_url+"/journal_entries/reverse/action",
            data    : "batch="+batch+"&reason="+inputValue+"&period="+period,
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
                    document.location.href=base_url+"/journal_entries/reverse";
                }
            }
        });
    });
}

function addReverse(){
    swal({
            title: '',
            text: 'Masukan batch:',
            type: "input",
            showCancelButton: true,
            closeOnConfirm: false,
            animation: "slide-from-top",
            inputPlaceholder: 'Batch...',
            showLoaderOnConfirm:true
    },function(inputValue){
            if (inputValue === false) return false;
            if (inputValue === "") {
              swal.showInputError('Batch tidak boleh kosong...!!!');
              return false;
            }
            document.location.href=base_url+'/journal_entries/reverse?batch='+inputValue;
    });
}

function celDivAction(celDiv) {
    $( celDiv ).dblclick( function() {
        var code = $(this).parent().parent().children('td').eq(2).text();
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