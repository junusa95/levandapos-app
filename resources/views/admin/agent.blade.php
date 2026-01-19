
@extends('layouts.app')

@section('css')
<style type="text/css">
    /*password show hide*/
    .pass_show{position: relative} 
    .pass_show .ptxt { 
        position: absolute;
        top: 72%; right: 10px; z-index: 1; color: #f36c01; 
        margin-top: -10px; cursor: pointer; transition: .3s ease all; 
    }
    .pass_show .ptxt:hover{color: #333333;} 
    .tool-tip:hover {
        cursor: pointer;
    }

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
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="header pb-0"><h2>General info:</h2><hr> </div>
                                    <div class="body pt-0">
                                        <ul class="pl-2" style="list-style: none;">
                                            <li><b>Agent name:</b><span style="font-weight: bold;font-size: 18px;"> {{$data['agent']->name}}</span></li>
                                            <li><b>Contact:</b><span> {{$data['agent']->phone}}</span></li>
                                            <?php 
                                                $cdate = new DateTime($data['agent']->created_at); 
                                            ?>
                                            <li><b>Created at:</b><span> {{$cdate->format('d/m/Y h:i A')}}</span></li>
                                        </ul>                                                
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="card">
                                    <!-- <div class="header pb-0"><h2>Payments:</h2><hr> </div> -->
                                    <div class="body py-4" align="center">
                                        <p>Amount to earn this month</p>
                                        <h2><span class="amount-to-earn"><i class='fa fa-spinner fa-spin' style='font-size:15px;'></i></span> TZS</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 col-md-6">
                        <div align="right" class="mb-2">
                            <button class="btn btn-info info-sm" data-toggle="modal" data-target="#payAgent">Add Payment</button>
                        </div>
                        <div class="card">
                            <div class="header pb-0"><h2>Accounts Sumary</h2><hr> </div>
                            <div class="body pt-0">
                                <div class="row profile_state">
                                    <div class="col-6">
                                        <div class="body">
                                            <i class="fa fa-check-square-o text-success"></i>
                                            <h5 class="m-b-0 number count-to active-accounts">-</h5>
                                            <small>Active accounts</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="body">
                                            <i class="fa fa-star text-info"></i>
                                            <h5 class="m-b-0 number count-to free-accounts">-</h5>
                                            <small>Free trial accounts</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="body">
                                            <i class="fa fa-times text-danger"></i>
                                            <h5 class="m-b-0 number count-to e-free-accounts">-</h5>
                                            <small>End free trial accounts</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="body">
                                            <i class="fa fa-exclamation text-warning"></i>
                                            <h5 class="m-b-0 number count-to e-pay-accounts">-</h5>
                                            <small>End payment accounts</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 small-screen-margin">
                        <div class="card">
                            <div class="header">
                                <h2>All Accounts: (<span class="total-accounts"></span>)</h2>
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
                                                        <th style="width: 90px;"><?php echo $_GET['created-at']; ?></th>  
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
    
<!-- add payment modal -->
<div class="modal fade" id="payAgent" tabindex="-1" role="dialog" aria-labelledby="payAgentModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">Pay Agent</h4>
                <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9">
                    <button class="btn btn-danger btn-sm">x</button>
                </span>
            </div>
            <div class="modal-body"> 
                <form id="basic-form" class="agent-payment-frm">
                    @csrf
                    <div class="row clearfix">
                        <div class="col-sm-6 offset-sm-3">
                            <input type="hidden" name="aid" value="{{$data['agent']->id}}">
                            <div class="form-group">
                                <label>Agent name</label>
                                <input type="text" class="form-control" name="aname" value="{{$data['agent']->name}}" disabled>
                            </div>
                            <div class="form-group">
                                <label class="mb-0">Amount</label>
                                <input type="number" class="form-control" name="amount" value="" required>
                            </div>
                            <div class="form-group pass_show">
                                <label class="mb-0">Paid Month</label>
                                <input type="text" id="datepicker" class="form-control" name="month" value="" required>
                            </div>
                            <div class="form-group">
                                <label class="mb-0">Attach reference</label>
                                <input type="file" class="form-control" name="reference" value="">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary submit-agent-payment px-5">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
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

<script type="text/javascript">

    $(function () {        
        getAgentAccounts('<?php echo $data["agent"]->id; ?>');
        $('#datepicker').datepicker({
            format: "mm-yyyy",
            startView: "months", 
            minViewMode: "months"
        });   
    });
    
    function getAgentAccounts(agent_id) {     
        $('.render-agent-accounts').html('<tr class="align-center"><td colspan="6">Loading... </td></tr>');
        $.get('/agent/agent-accounts/'+agent_id, function(data) {  
            $('.total-accounts').html(data.data.total_accounts);
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
        "<?php foreach($data['agent']->agentAccounts()->get() as $ac) { ?>";
            $.get('/get-data/account-last-activity/<?php echo $ac->id; ?>', function(data) {  
                $('.last-a-'+data.cid).html(data.last_activity); 
            }); 
        "<?php } ?>";

        getActiveShops('<?php echo $data["agent"]->id; ?>');
    }

    function getActiveShops(agent_id) {
        $('.render-active-shops').html('<tr class="align-center"><td colspan="3">Loading... </td></tr>');
        $.get('/agent/agent-active-shops/'+agent_id, function(data) {  
            $('.total-a-shops').html(data.data.total_shops);
            $('.render-active-shops').html(data.shops); 
            
            getActiveStores('<?php echo $data["agent"]->id; ?>');
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
    
    $(document).on('submit', '.agent-payment-frm', function(e){
        e.preventDefault();
        $('.submit-agent-payment').prop('disabled', true).html('submitting..');

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData(this);
        formdata.append('status','add agent payment');
        $.ajax({
            type: 'POST',
            url: '/submit-data',
            processData: false,
            contentType: false,
            data: formdata,
            success: function(data) {
                $('.submit-agent-payment').prop('disabled', false).html('Submit');
                if (data.status == "success") {
                    popNotification('success',"Success! Payment to agent has been added.");
                    $('.agent-payment-frm [name="amount"], .agent-payment-frm [name="month"], .agent-payment-frm [name="reference"]').val("");
                    // $('.agent-payment-frm')[0].reset();
                    $('#payAgent').modal('hide');    
                } else {
                    popNotification('warning',"Error! Failed to add payment, please try again.");
                }
            }
        });
    });

    $(document).on('click', '.view-reference', function(e){
        e.preventDefault();
        $('#viewReference').modal('show');   
        $('.render-reference').html('<img src="/images/payment_references/'+$(this).attr('img')+'" />');
    });

</script>
@endsection 