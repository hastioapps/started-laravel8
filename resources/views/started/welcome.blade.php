@extends('layouts.main')
@section('content')
<div class="lockscreen-wrapper">
    <div class="text-center">
        <h1>{{ Request::user()->name }}</h1>
        <p>{{ __('label.welcome_to_join') }}</p>
    </div>
    <div class="text-center">
      <button id="btnFinish" class="btn btn-primary btn-xs">{{ __('button.finish') }}</button>
    </div>
</div>

<script type="text/javascript">
  $(document).ready(function (){
      $(document).on('click','#btnFinish', function () {
            $.ajax({
                type      : "POST",
                dataType  : "json",
                url       : "{{ url('welcome') }}",
                data      : '',
                beforeSend: function() {
                    $.LoadingOverlay("show", {
                        image       : "",
                        background  : "rgba(0, 0, 0, 0.5)",
                        progress    : true
                    });
                    var count     = 0;
                    var interval  = setInterval(function(){
                        if (count >= 100) {
                            clearInterval(interval);
                            return;
                        }
                        count += 10;
                        $.LoadingOverlay("progress", count);
                    }, 300);
                },success : function(data){
                    if (data.alert=='Error'){
                        toastr.error(data.message);
                        $.LoadingOverlay("hide");
                    }else if (data.alert=='Warning'){
                        toastr.warning(data.message);
                        $.LoadingOverlay("hide");
                    }else if (data.alert=='Success'){
                        setTimeout(function (){
                            location.href=data.message;
                            $.LoadingOverlay("hide");
                        },2000);
                    }
                }
            });
      });
  });
</script>
@endsection