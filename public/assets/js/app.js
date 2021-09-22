$(document).ready(function (){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.LoadingOverlaySetup({
        background      : "rgba(0, 0, 0, 0)"
    });
    
    $(document).ajaxStart(function(){
        $(".brand-image").LoadingOverlay("show");
    });
    $(document).ajaxStop(function(){
        $(".brand-image").LoadingOverlay("hide");
    });
});

function cekRoute(tcode){
    $.ajax({
        type    : "POST",
        url     : "tcode",
        data    : "tcode="+tcode,
        dataType : "json",
        success : function(json){
            if (json.alert=='Warning'){
                toastr.warning(json.message);
            }else if (json.alert=='Success'){
                document.location.href=json.message;
            }
        }
    });
    return false;
}

function roundValue(val, denominator) {
    if(denominator == undefined || isNaN(denominator)) denominator = "0.01";

    var temp = "" + Math.round(val/denominator);
    var precision = 0;
    if(denominator == 1) {
        return temp;
    } else if(denominator > 1) {
        temp += ("" + Math.round(denominator)).substring(1) + ".00";
    } else {
        denominator = "" + denominator;
        while(denominator.charAt(denominator.length -1) == '0') {
            denominator = denominator.substring(0, denominator.length -1);
        }
        precision = denominator.length - denominator.indexOf(".") - 1;
        if(temp.length <= precision) {
            var temp2 = "0.";
            for(i=temp.length+1; i<=precision; i++) {
                temp2 += "0";
            }
            temp2 += temp;
            temp = temp2;
        } else {
            temp = temp.substring(0, temp.length - precision) + "." + temp.substring(temp.length - precision);
        }
    }
    if(temp == "N.aN") temp = "0";
    precision = temp.indexOf(".");
    if(precision == -1) {
        temp += ".00";
    } else {
        for(i=(temp.length-precision); i<3; i++) {
            temp += "0";
        }
    }
    return temp;
}

function formatCurrency(num) {
    num = num.toString().replace(/\$|\,/g,'');
    if(isNaN(num))
    num = "0";
    sign = (num == (num = Math.abs(num)));
    num = Math.floor(num*100+0.50000000001);
    cents = num%100;
    num = Math.floor(num/100).toString();
    if(cents<10)
    cents = "0" + cents;
    for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
    num = num.substring(0,num.length-(4*i+3))+','+
    num.substring(num.length-(4*i+3));
    return (((sign)?'':'-') + num);
}