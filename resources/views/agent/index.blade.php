
@extends('layouts.app')

@section('css')
<style type="text/css">

.render-reference img {width: 100%;}

@media screen and (max-width: 480px) {
    .small-screen-margin {padding-left: 0px;padding-right: 0px;}
    .small-screen-margin .card .header, .small-screen-margin .card .body {padding-left: 10px;padding-right: 10px;}
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
                    <div class="col-lg-12 col-md-12">
                        <div class="row">

                            <div class="col-md-3 col-8">
                                <div class="card top_counter">
                                    <div class="body pt-3">
                                        <div style="display: block;margin-bottom: 10px;">Amount to earn this month.</div>
                                        <div class="icon text-info"><img src="/images/money2.png" width="50" alt=""> </div>
                                        <div class="content">
                                            <div class="text">TZS</div>
                                            <h5 class="number"><strong class="amount-to-earn"><i class="fa fa-spinner fa-spin" style="font-size:15px;"></i></strong></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-9">
                                <div class="card">
                                    <div class="row profile_state">
                                        <div class="col-lg-3 col-6">
                                            <div class="body">
                                                <i class="fa fa-check-square-o text-success"></i>
                                                <h5 class="m-b-0 number count-to active-accounts"><i class="fa fa-spinner fa-spin" style="font-size:15px;"></i></h5>
                                                <small>Active accounts</small>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-6">
                                            <div class="body">
                                                <i class="fa fa-star text-info"></i>
                                                <h5 class="m-b-0 number count-to free-accounts"><i class="fa fa-spinner fa-spin" style="font-size:15px;"></i></h5>
                                                <small>Free trial accounts</small>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-6">
                                            <div class="body">
                                                <i class="fa fa-times text-danger"></i>
                                                <h5 class="m-b-0 number count-to e-free-accounts"><i class="fa fa-spinner fa-spin" style="font-size:15px;"></i></h5>
                                                <small>End free trial accounts</small>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-6">
                                            <div class="body">
                                                <i class="fa fa-exclamation text-warning"></i>
                                                <h5 class="m-b-0 number count-to e-pay-accounts"><i class="fa fa-spinner fa-spin" style="font-size:15px;"></i></h5>
                                                <small>End payment accounts</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 small-screen-margin">
                                <div class="card">
                                    <div class="header">
                                        <h2><?php echo $_GET['accounts-you-registered']; ?></h2>
                                        <ul class="header-dropdown">
                                            <li><a href="/agent/register-account" class="btn btn-info btn-sm"><?php echo $_GET['register-account']; ?></a></li>
                                            <!-- <li><button class="btn btn-info btn-sm update-buying-price">update buying price</button></li> -->
                                        </ul>
                                    </div>
                                    <div class="body pt-0">
                                        <div class="table-responsive">
                                            <table class="table m-b-0 c_list table-bordered">
                                                <thead class="thead-light"> 
                                                    <tr>
                                                        <th>#</th>
                                                        <th><?php echo $_GET['name']; ?></th>         
                                                        <th><?php echo $_GET['shop-store']; ?></th>              
                                                        <th style="width: 90px;"><?php echo $_GET['created-at']; ?></th>          
                                                        <th><?php echo $_GET['last-activity']; ?></th>         
                                                        <th><?php echo $_GET['payment-status']; ?></th>       
                                                    </tr>
                                                </thead>
                                                <tbody class="render-agent-accounts">
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-12 small-screen-margin">
                                        <div class="card">
                                            <div class="header">
                                                <h2>Active shops: (<span class="total-a-shops"></span>)</h2>
                                                <ul class="header-dropdown">
                                                    <!-- <li><button class="btn btn-info btn-sm update-buying-price">update buying price</button></li> -->
                                                </ul>
                                            </div>
                                            <div class="body pt-0">
                                                <div class="table-responsive">
                                                    <table class="table m-b-0 c_list table-bordered">
                                                        <thead class="thead-light"> 
                                                            <tr>
                                                                <th>#</th>
                                                                <th><?php echo $_GET['name']; ?></th>                
                                                                <th style="width: 90px;"><?php echo $_GET['created-at']; ?></th>  
                                                            </tr>
                                                        </thead>
                                                        <tbody class="render-active-shops">
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 small-screen-margin">
                                        <div class="card">
                                            <div class="header">
                                                <h2>Active stores: (<span class="total-a-stores"></span>)</h2>
                                                <ul class="header-dropdown">
                                                    <!-- <li><button class="btn btn-info btn-sm update-buying-price">update buying price</button></li> -->
                                                </ul>
                                            </div>
                                            <div class="body pt-0">
                                                <div class="table-responsive">
                                                    <table class="table m-b-0 c_list table-bordered">
                                                        <thead class="thead-light"> 
                                                            <tr>
                                                                <th>#</th>
                                                                <th><?php echo $_GET['name']; ?></th>                
                                                                <th style="width: 95px;"><?php echo $_GET['created-at']; ?></th>  
                                                            </tr>
                                                        </thead>
                                                        <tbody class="render-active-stores">
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-12 small-screen-margin">
                                        <div class="card">
                                            <div class="header">
                                                <h2>Previous Payments:</h2>
                                                <ul class="header-dropdown">
                                                    <!-- <li><button class="btn btn-info btn-sm update-buying-price">update buying price</button></li> -->
                                                </ul>
                                            </div>
                                            <div class="body pt-0">
                                                <div class="table-responsive">
                                                    <table class="table m-b-0 c_list table-bordered">
                                                        <thead class="thead-light"> 
                                                            <tr>
                                                                <th style="width: 90px;">Month</th>  
                                                                <th>Amount</th>     
                                                                <th>Status</th>           
                                                            </tr>
                                                        </thead>
                                                        <tbody class="render-p-payments">
                                                            <tr><td colspan="3" align="center">Loading..</td></tr>
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
        </div>
</div>

<!-- view reference modal -->
<div class="modal fade" id="viewReference" tabindex="-1" role="dialog" aria-labelledby="viewReferenceModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- <div class="modal-header">
                <h4 class="title" id="largeModalLabel">Pay Agent</h4>
                <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9">
                    <button class="btn btn-danger btn-sm">x</button>
                </span>
            </div> -->
            <div class="modal-body"> 
                <div>
                    <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9">
                        <button class="btn btn-danger btn-sm">x</button>
                    </span>
                </div>
                <div class="render-reference">

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    $(function () { 
        getAgentAccounts("<?php echo Auth::user()->id; ?>");
    });

    function getAgentAccounts(agent_id) {     
        $('.render-agent-accounts').html('<tr class="align-center"><td colspan="6">Loading... </td></tr>');
        $.get('/agent/agent-accounts/'+agent_id, function(data) {  
            $('.amount-to-earn').html(data.agent_commission);
            $('.render-agent-accounts').html(data.accounts); 
            $('.active-accounts').html(data.data.total_active);
            $('.free-accounts').html(data.data.total_free);
            $('.e-free-accounts').html(data.data.total_e_free);
            $('.e-pay-accounts').html(data.data.total_e_payments);

            getAccountLastActivity();
        }); 
    }

    function getAccountLastActivity() {
        "<?php foreach(Auth::user()->agentAccounts()->get() as $ac) { ?>";
            $.get('/get-data/account-last-activity/<?php echo $ac->id; ?>', function(data) {  
                $('.last-a-'+data.cid).html(data.last_activity); 
            }); 
        "<?php } ?>";

        getActiveShops("<?php echo Auth::user()->id; ?>");
    }
    
    function getActiveShops(agent_id) {
        $('.render-active-shops').html('<tr class="align-center"><td colspan="3">Loading... </td></tr>');
        $.get('/agent/agent-active-shops/'+agent_id, function(data) {  
            $('.total-a-shops').html(data.data.total_shops);
            $('.render-active-shops').html(data.shops); 
            
            getActiveStores("<?php echo Auth::user()->id; ?>");
        }); 
    }
    
    function getActiveStores(agent_id) {
        $('.render-active-stores').html('<tr class="align-center"><td colspan="3">Loading... </td></tr>');
        $.get('/agent/agent-active-stores/'+agent_id, function(data) {  
            $('.total-a-stores').html(data.data.total_stores);
            $('.render-active-stores').html(data.stores); 

            fivePreviousPayments(agent_id);
        }); 
    }

    function fivePreviousPayments(agent_id) {
        $('.render-p-payments').html('<tr class="align-center"><td colspan="3">Loading... </td></tr>');
        $.get('/agent/five-previous-payments/'+agent_id, function(data) {  
            $('.render-p-payments').html(data.payments); 
        }); 
    }
    
    $(document).on('click', '.view-reference', function(e){
        e.preventDefault();
        $('#viewReference').modal('show');   
        $('.render-reference').html('<img src="/images/payment_references/'+$(this).attr('img')+'" />');
    });
</script>
@endsection