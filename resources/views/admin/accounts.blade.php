@extends('layouts.app')

@section('css')
<style>
    .conf-link p span {
        border: 1px solid #ddd;padding: 3px 10px;
    }
    .view-company-btn {
        display: inline-block;width: 25px !important;
    }
    .action-company-btn {
        font-size: 20px;display: inline-block; width: 25px !important;
    }
    .action-company-btn:hover, .view-company-btn:hover {
        background: #ddd;cursor: pointer;
    }
    .drop-action-outer {position: relative;}
    .drop-action {box-shadow: 0 1px 1px rgba(0,0,0,0.08), 0 2px 2px rgba(0,0,0,0.12), 0 4px 4px rgba(0,0,0,0.16), 0 8px 8px rgba(0,0,0,0.20);position: absolute;background: #fff;text-align: left;margin-top: -5px; display: none;padding: 0px 4px;}
    .drop-action span {display: block;padding: 4px 10px;padding-bottom: 0px; color: #007bff;border-bottom: 1px solid #ddd;}
    .drop-action span:hover {background: #ddd;cursor: pointer;}
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
                    <div class="col-lg-12 col-md-12">
                        <div class="row">
                            <div class="col-12">
                                <div class="acc-options mb-2">
                                    <button class="btn btn-sm active-accounts">Active</button>
                                    <button class="btn btn-sm f-t-accounts">Free Trial</button>
                                    <button class="btn btn-sm n-p-accounts">Not Paid</button>
                                    <button class="btn btn-sm e-f-t-accounts">End Free Trial</button>
                                    <button class="btn btn-sm d-report">Detailed report</button>
                                </div>
                                <div class="card">
                                    <div class="header" style="background-color: #01b2c6;padding-bottom: 12px;padding-top: 10px;">
                                        <h2 class="text-white render-head">- </h2>
                                        <ul class="header-dropdown">
                                            <!-- <li><button class="btn btn-info btn-sm" data-toggle="modal" data-target="#newCompany">New company</button></li> -->
                                            <!-- <li><button class="btn btn-info btn-sm update-buying-price">update buying price</button></li> -->
                                        </ul>
                                    </div>
                                    <div class="body body-1 pt-0">
                                        <div class="table-responsive">
                                            <table class="table m-b-0 c_list">
                                                <thead> 
                                                    <tr>
                                                        <!-- <th>#</th> -->
                                                        <th>Name</th>         
                                                        <!-- <th>Contact person</th>               -->
                                                        <th>Created Date</th>          
                                                        <th>Activeness</th>          
                                                        <th align="center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="render-accounts">
                                                    
                                                </tbody>
                                                <tbody class="more-btn-blc" style="display: none;">
                                                    <tr>
                                                        <td colspan="4" align="center"><button class="btn btn-info more-btn">More</button></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="body body-2 pt-0" style="display: none;">
                                        <div class="table-responsive">
                                            <table class="table m-b-0 c_list">
                                                <thead> 
                                                    <tr>
                                                        <th></th>         
                                                        <th>Active</th>              
                                                        <th>Not Paid</th>          
                                                        <th>Free Trial</th>          
                                                        <th>E.F Trial</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>Accounts <br> Shops <br> Stores</th>
                                                        <th><b class="a_acc">-</b> <br> <b class="a_shop">-</b> <br> <b class="a_store">-</b></th>
                                                        <th><b class="np_acc">-</b> <br> <b class="np_shop">-</b> <br> <b class="np_store">-</b></th>
                                                        <th><b class="ft_acc">-</b> <br> <b class="ft_shop">-</b> <br> <b class="ft_store">-</b></th>
                                                        <th><b class="eft_acc">-</b> <br> <b class="eft_shop">-</b> <br> <b class="eft_store">-</b></th>
                                                        <th><b class="t_acc">-</b> <br> <b class="t_shop">-</b> <br> <b class="t_store">-</b></th>
                                                    </tr>
                                                </tbody>
                                                <tbody class="more-btns">
                                                    <tr>
                                                        <td colspan="6"><a href="#" class="monthly-regis"><i class="fa fa-arrow-right"></i> Monthly Registrations</a></td>
                                                    </tr>
                                                </tbody>
                                                <tbody class="render-monthly-regis">
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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
<script>    
    $(function () {     
        let searchParams = new URLSearchParams(window.location.search);
        if (searchParams.has('opt')) { 
            if (searchParams.get('opt') == "active-accounts") {
                $('.active-accounts').click();
            }
            if (searchParams.get('opt') == "free-trial-accounts") {
                $('.f-t-accounts').click();
            }
            if (searchParams.get('opt') == "end-free-trial-accounts") {
                $('.e-f-t-accounts').click();
            }
            if (searchParams.get('opt') == "not-paid-accounts") {
                $('.n-p-accounts').click();
            }
            if (searchParams.get('opt') == "detailed-report") {
                $('.d-report').click();
            }
        } else {
            $('.active-accounts').click();
        }
    });
    
    $(document).on('click', '.active-accounts', function(e){
        $('.render-head').html('Active accounts: (<span>-</span>)');
        $('.more-btn-blc, .body-2').css('display','none'); $('.body-1').css('display','block');
        $('.acc-options .btn').removeClass('btn-info');
        $('.acc-options .active-accounts').addClass('btn-info');
        history.replaceState({}, document.title, "?opt=active-accounts");
        $('.render-accounts').html("<div align='center'>Loading...</div>");
        $.get('/get-data/companies/active', function(data) {    
            $('.render-head').html('Active accounts: (<span>'+data.data.total+'</span>)');
            $('.render-accounts').html(data.output);
            if(data.data.totalp == 20) {
                $('.more-btn-blc').css('display','');
                $('.more-btn').attr({'lastid':data.data.last_id, 'status':'active'});
            }
        }); 
    });
    
    $(document).on('click', '.f-t-accounts', function(e){        
        $('.render-head').html('Free Trial accounts: (<span>-</span>)');
        $('.more-btn-blc, .body-2').css('display','none'); $('.body-1').css('display','block');
        $('.acc-options .btn').removeClass('btn-info');
        $('.acc-options .f-t-accounts').addClass('btn-info');
        history.replaceState({}, document.title, "?opt=free-trial-accounts");
        $('.render-accounts').html("<div align='center'>Loading...</div>");
        $.get('/get-data/companies/free-trial', function(data) {    
            $('.render-head').html('Free Trial accounts: (<span>'+data.data.total+'</span>)');
            $('.render-accounts').html(data.output);
            if(data.data.totalp == 20) {
                $('.more-btn-blc').css('display','');
                $('.more-btn').attr({'lastid':data.data.last_id, 'status':'f-t'});
            }
        }); 
    });
    
    $(document).on('click', '.e-f-t-accounts', function(e){
        $('.render-head').html('End Free Trial accounts: (<span>-</span>)');
        $('.more-btn-blc, .body-2').css('display','none'); $('.body-1').css('display','block');
        $('.acc-options .btn').removeClass('btn-info');
        $('.acc-options .e-f-t-accounts').addClass('btn-info');
        history.replaceState({}, document.title, "?opt=end-free-trial-accounts");
        $('.render-accounts').html("<div align='center'>Loading...</div>");
        $.get('/get-data/companies/end-free-trial', function(data) {    
            $('.render-head').html('End Free Trial accounts: (<span>'+data.data.total+'</span>)');
            $('.render-accounts').html(data.output);
            if(data.data.totalp == 20) {
                $('.more-btn-blc').css('display','');
                $('.more-btn').attr({'lastid':data.data.last_id, 'status':'e-f-t'});
            }
        }); 
    });
    
    $(document).on('click', '.n-p-accounts', function(e){
        $('.render-head').html('Not Paid accounts: (<span>-</span>)');
        $('.more-btn-blc, .body-2').css('display','none'); $('.body-1').css('display','block');
        $('.acc-options .btn').removeClass('btn-info');
        $('.acc-options .n-p-accounts').addClass('btn-info');
        history.replaceState({}, document.title, "?opt=not-paid-accounts");
        $('.render-accounts').html("<div align='center'>Loading...</div>");
        $.get('/get-data/companies/not-paid', function(data) {    
            $('.render-head').html('Not Paid accounts: (<span>'+data.data.total+'</span>)');
            $('.render-accounts').html(data.output);
            if(data.data.totalp == 20) {
                $('.more-btn-blc').css('display','');
                $('.more-btn').attr({'lastid':data.data.last_id, 'status':'n-p'});
            }
        }); 
    });
    
    $(document).on('click', '.d-report', function(e){
        e.preventDefault();
        $('.render-head').html('Detailed Report');
        $('.body-2').css('display','block'); $('.body-1').css('display','none');
        $('.acc-options .btn').removeClass('btn-info');
        $('.acc-options .d-report').addClass('btn-info');
        history.replaceState({}, document.title, "?opt=detailed-report");
        $('.render-accounts').html("<div align='center'>Loading...</div>");
        $.get('/get-data/companies/detailed-report', function(data) {   
            $.each( data.numbers, function( key, value ) {          
                $('.a_acc').html(value.total_active); $('.np_acc').html(value.total_not_paid); $('.ft_acc').html(value.total_free_trial); $('.eft_acc').html(value.total_end_free_trial); $('.t_acc').html(value.total_accounts); 
            });
            $.get('/get-data/companies/detailed-shops-report', function(data) {   
                $.each( data.numbers, function( key, value ) {          
                    $('.a_shop').html(value.total_active); $('.np_shop').html(value.total_not_paid); $('.ft_shop').html(value.total_free_trial); $('.eft_shop').html(value.total_end_free_trial); $('.t_shop').html(value.total_shops); 
                });
                $.get('/get-data/companies/detailed-stores-report', function(data) {   
                    $.each( data.numbers, function( key, value ) {          
                        $('.a_store').html(value.total_active); $('.np_store').html(value.total_not_paid); $('.ft_store').html(value.total_free_trial); $('.eft_store').html(value.total_end_free_trial); $('.t_store').html(value.total_stores); 
                    });
                    $('.more-btns').css('display','table-row-group');
                }); 
            }); 
        }); 
    });
    
    $(document).on('click', '.monthly-regis', function(e) {
        e.preventDefault();

        getMonthlyAccounts();        
    });
    function getMonthlyAccounts(callback) {
        var monthNames = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ];

        var varDate = new Date();
        var month = varDate.getMonth()+1;
        var currentDay = varDate.getDate();

        $('.render-monthly-regis').html("");

        for ( var i = 0; i <= 5; i++) {
            var now = new Date();
            now.setDate(1);
            var date = new Date(now.setMonth(now.getMonth() - i));
            var datex = ("0" + date.getDate()).slice(-2) + "-" + ("0" + (date.getMonth() + 1)).slice(-2) + "-" + date.getFullYear();
            var monthyear = monthNames[date.getMonth()] + "-" + date.getFullYear();
            $('.render-monthly-regis').append('<tr><th colspan="6">'+monthyear+'</th></tr>'
                +'<tr class="'+monthyear+'">'
                +'<th class="name"><b>Accounts</b><br><b>Shops</b><br><b>Stores</b></th>'
                +'<th class="a"><b class="0"></b><br><b class="1"></b><br><b class="2"></b></th>'
                +'<th class="n"><b class="0"></b><br><b class="1"></b><br><b class="2"></b></th>'
                +'<th class="f"><b class="0"></b><br><b class="1"></b><br><b class="2"></b></th>'
                +'<th class="e"><b class="0"></b><br><b class="1"></b><br><b class="2"></b></th>'
                +'<th class="t"><b class="0"></b><br><b class="1"></b><br><b class="2"></b></th>'
                +'</tr>');
            $.get('/get-data/accounts-monthly-registrations/'+monthyear, function(data) {   
                $.when( 
                    // appendTr(data.monthyear)
                 ).then(function () {
                    for (var j = 0; j < data.numbers.length; j++) {
                        $('.'+data.monthyear+' .a .0').html(data.numbers[j][0]['total_active']);
                        $('.'+data.monthyear+' .a .1').html(data.numbers[j][0]['total_active2']);
                        $('.'+data.monthyear+' .a .2').html(data.numbers[j][0]['total_active3']);
                        $('.'+data.monthyear+' .n .0').html(data.numbers[j][0]['total_not_paid']);
                        $('.'+data.monthyear+' .n .1').html(data.numbers[j][0]['total_not_paid2']);
                        $('.'+data.monthyear+' .n .2').html(data.numbers[j][0]['total_not_paid3']);
                        $('.'+data.monthyear+' .f .0').html(data.numbers[j][0]['total_free_trial']);
                        $('.'+data.monthyear+' .f .1').html(data.numbers[j][0]['total_free_trial2']);
                        $('.'+data.monthyear+' .f .2').html(data.numbers[j][0]['total_free_trial3']);
                        $('.'+data.monthyear+' .e .0').html(data.numbers[j][0]['total_end_free_trial']);
                        $('.'+data.monthyear+' .e .1').html(data.numbers[j][0]['total_end_free_trial2']);
                        $('.'+data.monthyear+' .e .2').html(data.numbers[j][0]['total_end_free_trial3']);
                        $('.'+data.monthyear+' .t .0').html(data.numbers[j][0]['total_accounts']);
                        $('.'+data.monthyear+' .t .1').html(data.numbers[j][0]['total_shops']);
                        $('.'+data.monthyear+' .t .2').html(data.numbers[j][0]['total_stores']);
                    }
                });
            }); 
        }
        return true;
    }

    function appendTr(monthyear) {
        $('.render-monthly-regis').append('<tr><th colspan="6">'+monthyear+'</th></tr>'
            +'<tr class="'+monthyear+'">'
            +'<th class="name"><b>Accounts</b><br><b>Shops</b><br><b>Stores</b></th>'
            +'<th class="a"><b class="0"></b><br><b class="1"></b><br><b class="2"></b></th>'
            +'<th class="n"><b class="0"></b><br><b class="1"></b><br><b class="2"></b></th>'
            +'<th class="f"><b class="0"></b><br><b class="1"></b><br><b class="2"></b></th>'
            +'<th class="e"><b class="0"></b><br><b class="1"></b><br><b class="2"></b></th>'
            +'<th class="t"><b class="0"></b><br><b class="1"></b><br><b class="2"></b></th>'
            +'</tr>');
    }
    
    $(document).on('click', '.more-btn', function(e) {
        $('.render-accounts').append("<tr class='tr-loader'><td colspan='4' align='center'><i class='fa fa-spinner fa-spin fa-2x'></i> Loading..</td></tr>");
        $('.more-btn-blc').css('display','none');
        var last_id = $(this).attr('lastid');
        var status = $(this).attr('status');
        $.get('/get-data/more-companies/'+status+'~'+last_id, function(data) {    
            $('.render-accounts').append(data.output);
            $('.tr-loader').css('display','none');
            if(data.data.totalp == 20) {
                $('.more-btn-blc').css('display','');
                $('.more-btn').attr({'lastid':data.data.last_id, 'status':status});
            }
        }); 
    });
    
    $(document).on('click', '.action-company-btn', function(e){
        e.preventDefault();
        var cid = $(this).attr('cid');
        $('.action-company-btn i').removeClass('fa-angle-down');
        $('.company-btn'+cid+' i').addClass('fa-angle-down');
        $('.drop-action').css('display','none');
        $('.view-drop'+cid).css('display','block');
    });
</script>
@endsection