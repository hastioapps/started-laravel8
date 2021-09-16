$(document).ready(function() { 
    $.LoadingOverlaySetup({
        //background      : "rgba(0, 0, 0, 0.5)",
        image           : base_url+"/assets/img/loading.svg",
        imageAnimation  : "1.5s fadein",
        imageColor      : "#3b5998"
    });

    $(document).ajaxStart(function(){
        $(".card-body").LoadingOverlay("show");
    });
    $(document).ajaxStop(function(){
        $(".card-body").LoadingOverlay("hide");
    });

    var container = $('div.callout');
    $("#formRegister").validate({
                errorContainer: container,
                errorLabelContainer: $("ol", container),
                wrapper: 'li',
                rules: {
                    user_id:{required: true,maxlength: 10},
                    name:{required: true,maxlength: 100},
                    email:{required: true,email: true},
                    phone:{required: true,number: true,minlength: 9,maxlength: 15},
                    password:{required: true,maxlength: 20},
                    repassword:{required: true,equalTo: "#password"}
                },
                messages: {
                    user_id:{
                            required: "Silakan isi ID pengguna.",
                            maxlength: $.validator.format( "ID pengguna max 10 karakter." )
                            },
                    name:{
                            required: "Silakan isi nama lengkap.",
                            maxlength: $.validator.format( "Nama lengkap max 100 karakter." )
                            },
                    email:{
                            required: "Silakan isi email.",
                            email: "Masukan email dengan benar."
                            },
                    phone:{
                            required: "Silakan isi telepon.",
                            number: "Masukan telepon dengan benar.",
                            minlength: $.validator.format( "telepon min 9 karakter." ),
                            maxlength: $.validator.format( "Telepon max 15 karakter." )
                            },
                    password:{
                            required: "Silakan isi kata sandi.",
                            maxlength: $.validator.format( "Kata sandi max 20 karakter." )
                            },
                    repassword:{
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
                    $.ajax({
                        type    : "POST",
                        url     : base_url+"/auth/process",
                        data    : $("#formRegister").serialize(),
                        success : function(data){
                            if (data=='success'){
                                document.location.href=base_url+"/auth/register/actived?confirm=unconfirmed";
                            }else{
                                toastr.warning(data);
                            }
                        }
                    });
                }
    });

    $("#formLogin").validate({
                errorContainer: container,
                errorLabelContainer: $("ol", container),
                wrapper: 'li',
                rules: {
                    user_id:{required: true},
                    password:{required: true,maxlength: 20}
                },
                messages: {
                    user_id:{
                            required: "Silakan isi ID pengguna."
                            },
                    password:{
                            required: "Silakan isi kata sandi.",
                            maxlength: $.validator.format( "Kata sandi max 20 karakter." )
                            }
                },
                highlight: function (element, errorClass, validClass) {
                  $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                  $(element).removeClass('is-invalid');
                },submitHandler: function() {
                    $.ajax({
                        type    : "POST",
                        dataType : "json",
                        url     : base_url+"/auth/process",
                        data    : $("#formLogin").serialize(),
                        success : function(json){
                            if (json.alert=='Success'){
                                document.location.href=base_url;
                            }else if (json.alert=='Unconfirmed'){
                                swal({
                                        title: "",
                                        text: json.message,
                                        type: "warning",
                                        showCancelButton: true,
                                        confirmButtonColor: "#3071a9",
                                        confirmButtonText: json.Resend,
                                        cancelButtonText: json.Cancel,
                                        closeOnConfirm: false,
                                        showLoaderOnConfirm:true
                                },function(){
                                    swal.close();
                                });    
                            }else{
                                toastr.warning(json.message);
                            }
                        }
                    });
		        }
	});
	
	/*$("#btnReset").click(function(){
        swal({
            title: '',
            text: 'Reset kata sandi, masukan email anda:',
            type: "input",
            inputType: "email",
            showCancelButton: true,
            closeOnConfirm: false,
            animation: "slide-from-top",
            inputPlaceholder: 'contoh@defasystem.com',
            showLoaderOnConfirm:true
            },
            function(inputValue){
                if (inputValue === false) return false;
                if (inputValue === "") {
                    swal.showInputError("Anda harus memasukan Email!");
                    return false;
                }
            
                $.ajax({
                    type	: "POST",
                    url     : "../controllers/controlLogOn.php",
                    data	: "btnReset="+inputValue,
                    success	: function(data){
                        if (data=='GLO_WAR_NF'){
                            swal.showInputError("Email yang anda masukan tidak di temukan.");
                        }else if (data=='GLO_ERR_FAI'){
                            swal.close();
                            gritterAlert('Error','Terjadi kesalahan, hubungi IT Support.',false,false,'');
                        }else{
                            swal.close();
                            gritterAlert('Success','Tautan telah dikirim ke alamat email Anda.',false,false,'');
                        }
                    }
                });
        });                    
        return false;
	});
        
    
	
	$("#formReset").validate({
                submitHandler: function() {
                    var datafrm=$("#formReset").serialize();
                    var password=$('#txtPassword').val();
                    swal({
                        title: '',
                        text: 'Masukan kembali kata sandi:',
                        type: "input",
                        inputType: "password",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        animation: "slide-from-top",
                        inputPlaceholder: 'Masukan kembali kata sandi.',
                        showLoaderOnConfirm:true
                      },
                      function(inputValue){
                        if (inputValue === false) return false;
                        if (inputValue === "") {
                          swal.showInputError("Anda harus memasukan kembali kata sandi!");
                          return false;
                        }
                        if (inputValue === password) {
                          $.ajax({
                                    type	: "POST",
                                    url         : "../../controllers/controlLogOn.php",
                                    data	: datafrm,
                                    beforeSend: function () {
                                        $('#btnNewPassword').attr('disabled','disabled');
                                    },
                                    success	: function(data){
                                        $('#btnNewPassword').removeAttr('disabled','disabled');
                                        if (data=='GLO_SUC_UPD'){
                                            setTimeout(function (){location.href='../?';},500);
                                        }else{
                                            swal.close();
                                            gritterAlert('Error','Terjadi kesalahan, hubungi IT Support.',false,false,'');
                                        }
                                    }
                               });
                        }else{
                            swal.showInputError("Kata sandi tidak cocok!");
                            return false;
                        }    
                    });
		}
	});*/
});