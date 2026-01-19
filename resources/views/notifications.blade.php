
@extends('layouts.app')
@section('css')
<style>
    .card-header.seen {
        background-color: #fff;
    }
    .card-header .date {
        float: right;font-size: 12px;color: #000;margin-top: 10px;
    }
</style>
@endsection
@section('content')

<div id="wrapper">
    <nav class="navbar navbar-fixed-top">
        <div class="container-fluid">
            @include('layouts.topbar')
        </div>
    </nav>

    <div id="left-sidebar" class="sidebar">
        <div class="sidebar-scroll">
            @include('layouts.leftside')
        </div>
    </div>

    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    @include('layouts.topbottombar')
                </div>
            </div>
            
            <div class="row clearfix">                
                <div class="col-12">
                    <div class="card single-s">
                        <div class="header" style="border-bottom: 1px solid #ddd;">
                            <h2><?php echo $_GET['notifications']; ?></h2>
                        </div>
                        <div class="body">
                            <div class="accordion render-notifications" id="accordion">
                                <div class="not-loader" align="center"><i class="fa fa-spinner fa-spin fa-2x"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@section('js')
<script type="text/javascript">
    $(function () { 
        var preview = getSearchParams("preview");
        if ($.isEmptyObject(preview)) {
            userNotifications();
        } else {
            previewNotification("<?php echo Auth::user()->id; ?>",preview);
        }
    });

    function previewNotification(user_id,not_id) {
        $('.not-loader').css('display','block');
        $.get('/notification/preview-notification/'+user_id+'~'+not_id+'', function(data) {
            $('.notification-dot').css('display','none');
            $('.not-id-'+not_id).remove();
            if(data.status == "success") {
                $('.not-loader').css('display','none');
                $('.render-notifications').append(data.not);
            }  
        });            
    }

    function userNotifications() {
        $('.not-loader').css('display','block');
        $.get('/notification/get-all-user-notifications/<?php echo Auth::user()->company_id; ?>~<?php echo Auth::user()->id; ?>', function(data) {
            $('.notification-dot').css('display','none');
            $('.not-loader').css('display','none');
            if(data.nots.length == 0) {
                $('.render-notifications').html("<div align='center'>-- <?php echo $_GET['no-notifications']; ?> --</div>");
            } else {
                $('.render-notifications').append(data.nots);
            }
        });            
    }
    
    function getSearchParams(k){
     var p={};
     location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(s,k,v){p[k]=v})
     return k?p[k]:p;
    }
    
    $(document).on('click', '.open-notification', function() {
        var nid = $(this).attr('nid');
        $(this).css('background','#fff');
        $.get('/notification/open-notification/<?php echo Auth::user()->id; ?>~'+nid, function(data){
            console.log(data.status);
        });
    });
</script>
@endsection