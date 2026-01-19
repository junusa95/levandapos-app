
@extends('layouts.app')

@section('css')
<style type="text/css">

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
        getAgentAccounts("<?php echo Auth::user()->id; ?>");
    });

    function getAgentAccounts(agent_id) {     
        $('.render-agent-accounts').html('<tr class="align-center"><td colspan="6">Loading... </td></tr>');
        $.get('/agent/agent-accounts/'+agent_id, function(data) {  
            $('.render-agent-accounts').html(data.accounts); 
            getAccountLastActivity();
        }); 
    }

    function getAccountLastActivity() {
        "<?php foreach(Auth::user()->agentAccounts()->get() as $ac) { ?>";
            $.get('/get-data/account-last-activity/<?php echo $ac->id; ?>', function(data) {  
                $('.last-a-'+data.cid).html(data.last_activity); 
            }); 
        "<?php } ?>";
    }
</script>
@endsection