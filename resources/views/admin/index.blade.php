@extends('layouts.app')
@section('css')
<style type="text/css">
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
    .agent-row td, .render-f-t-accounts td, .render-a-accounts td, .render-n-p-accounts td, .render-e-f-t-accounts td {padding-bottom: 0px;padding-top: 4px;}
    .drop-action-outer {position: relative;}
    .drop-action {box-shadow: 0 1px 1px rgba(0,0,0,0.08), 0 2px 2px rgba(0,0,0,0.12), 0 4px 4px rgba(0,0,0,0.16), 0 8px 8px rgba(0,0,0,0.20);position: absolute;background: #fff;text-align: left;margin-top: -5px; display: none;padding: 0px 4px;}
    .drop-action span {display: block;padding: 4px 10px;padding-bottom: 0px; color: #007bff;border-bottom: 1px solid #ddd;}
    .drop-action span:hover {background: #ddd;cursor: pointer;}

    .app-installs {text-align:left}
    .app-installs p {padding-top:0px}
</style>
@endsection
@section('content')
<?php 
    $hyper_text = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
 ?>
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
                            <div class="col-4">
                                <div class="card">
                                    <div class="header">
                                        <h2>App Installations:</h2>
                                    </div>
                                    <div class="body app-installs">
                                        <div>
                                            <h4 class="mb-0"><b class="count-installs">-</b></h4>
                                            <p>Installations</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-8">
                                <div class="card">
                                    <div class="body">
                                        <button class="btn btn-sm btn-warning update-sales-date m-2" disabled>update sales date</button>
                                        <button class="btn btn-sm btn-warning update-payments-test m-2" disabled>Update payments test</button>
                                        <button class="btn btn-sm btn-warning yesterday-sms-report m-2" disabled>Yesterday sms report</button>
                                        <button class="btn btn-sm btn-info yearly-sms-report m-2" disabled>Yearly sms report</button>
                                        <!-- <button class="btn btn-sm btn-warning daily-sales-report m-2" disabled>Daily sales report</button> -->
                                        <button class="btn btn-sm btn-warning close-supplier-year m-2" disabled>Close Supplier Year</button>
                                        <button class="btn btn-sm btn-secondary m-2"  data-toggle="modal" data-target="#broadcastSMS">Broadcast SMS</button>
                                        <!-- <button class="btn btn-success m-2 update-sale-table">update sale table</button> -->
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="body">
                                        <div>
                                            <form class="search-accounts-form">
                                                <select name="type" class="form-control" style="width: 105px;display: inline-block;">
                                                    <option value="accounts">Accounts</option>
                                                    <option value="shops">Shops</option>
                                                    <option value="users">Users</option>
                                                </select>
                                                <input type="text" name="name" class="form-control" placeholder="Search" style="width: 180px;display: inline-block;">
                                                <button class="btn btn-info search-accounts-btn" style="display: inline-block;margin-top: -3px;"><i class="fa fa-search"></i></button>
                                            </form>
                                        </div>
                                        <div class="render-searched-accounts pt-2">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <a href="/admin/accounts">
                                    <div class="header" style="background-color: #01b2c6;padding-bottom: 12px;padding-top: 10px;">
                                        <h2 class="text-white">Registered Accounts: (<span class="total-accounts">-</span>) <i class="fa fa-arrow-right float-right"></i></h2>
                                        <ul class="header-dropdown">
                                            <!-- <li><button class="btn btn-info btn-sm" data-toggle="modal" data-target="#newCompany">New company</button></li> -->
                                            <!-- <li><button class="btn btn-info btn-sm update-buying-price">update buying price</button></li> -->
                                        </ul>
                                    </div>
                                    </a>
                                    <div class="body pt-0">
                                        <div class="row profile_state pt-3">
                                            <div class="col-6">
                                                <div class="body">
                                                    <i class="fa fa-check-square-o text-info"></i>
                                                    <h4 class="m-b-0 number count-to f-t-accounts"><i class="fa fa-spinner fa-spin" style="font-size:15px;"></i></h4>
                                                    <small>Free Trial</small>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="body">
                                                    <i class="fa fa-star text-success"></i>
                                                    <h4 class="m-b-0 number count-to a-accounts"><i class="fa fa-spinner fa-spin" style="font-size:15px;"></i></h4>
                                                    <small>Active accounts</small>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="body">
                                                    <i class="fa fa-times text-danger"></i>
                                                    <h4 class="m-b-0 number count-to e-f-t-accounts"><i class="fa fa-spinner fa-spin" style="font-size:15px;"></i></h4>
                                                    <small>End Free Trial</small>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="body">
                                                    <i class="fa fa-exclamation text-warning"></i>
                                                    <h4 class="m-b-0 number count-to n-p-accounts"><i class="fa fa-spinner fa-spin" style="font-size:15px;"></i></h4>
                                                    <small>Not Paid Accounts</small>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mt-3">
                                                    <button class="btn btn-warning bo-numbers">B.O with Phone numbers <i class="fa fa-arrow-right pl-5" style="font-size:15px;"></i></button>
                                                </div>
                                                <div class="mt-3">
                                                    <button class="btn btn-success monthly-revenues">Monthly Revenues <i class="fa fa-arrow-right pl-5" style="font-size:15px;"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <a href="/admin/accounts?opt=free-trial-accounts">
                                    <div class="header" style="background-color: #01b2c6;padding-bottom: 12px;padding-top: 10px;">
                                        <h2 class="text-white">Free Trial Accounts: (<span class="total-f-t-accounts">-</span>) <i class="fa fa-arrow-right float-right"></i></h2>
                                        <ul class="header-dropdown">
                                            <!-- <li><button class="btn btn-info btn-sm" data-toggle="modal" data-target="#newCompany">New company</button></li> -->
                                            <!-- <li><button class="btn btn-info btn-sm update-buying-price">update buying price</button></li> -->
                                        </ul>
                                    </div>
                                    </a>
                                    <div class="body pt-0">
                                        <div class="table-responsive">
                                            <table class="table m-b-0 c_list">
                                                <thead> 
                                                    <tr>
                                                        <th>Name</th>                       
                                                        <th></th> 
                                                    </tr>
                                                </thead>
                                                <tbody class="render-f-t-accounts">
                                                    
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
                            <div class="col-12">
                                <div class="card">
                                    <a href="/admin/accounts?opt=active-accounts">
                                    <div class="header bg-success" style="padding-bottom: 12px;padding-top: 10px;">
                                        <h2 class="text-white">Active Accounts: (<span class="total-a-accounts">-</span>) <i class="fa fa-arrow-right float-right"></i></h2>
                                        <ul class="header-dropdown">
                                            <!-- <li><button class="btn btn-info btn-sm" data-toggle="modal" data-target="#newCompany">New company</button></li> -->
                                            <!-- <li><button class="btn btn-info btn-sm update-buying-price">update buying price</button></li> -->
                                        </ul>
                                    </div>
                                    </a>
                                    <div class="body pt-0">
                                        <div class="table-responsive">
                                            <table class="table m-b-0 c_list">
                                                <thead> 
                                                    <tr>
                                                        <th>Name</th>                       
                                                        <th></th> 
                                                    </tr>
                                                </thead>
                                                <tbody class="render-a-accounts">
                                                    
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
                            <div class="col-12">
                                <div class="card">
                                    <a href="/admin/agents">
                                    <div class="header" style="background-color: #01b2c6;padding-bottom: 12px;padding-top: 10px;">
                                        <h2 class="text-white">Agents: (<span class="total-agents">-</span>) <i class="fa fa-arrow-right float-right"></i></h2>
                                        <ul class="header-dropdown">
                                            <!-- <li><button class="btn btn-info btn-sm" data-toggle="modal" data-target="#newCompany">New company</button></li> -->
                                            <!-- <li><button class="btn btn-info btn-sm update-buying-price">update buying price</button></li> -->
                                        </ul>
                                    </div>
                                    </a>
                                    <div class="body pt-0">
                                        <div class="table-responsive">
                                            <table class="table m-b-0 c_list">
                                                <thead> 
                                                    <tr>
                                                        <th>Name</th>                       
                                                        <th>Created Date</th> 
                                                    </tr>
                                                </thead>
                                                <tbody class="render-agents">
                                                    
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
                            <div class="col-12">
                                <div class="card">
                                    <a href="/admin/accounts?opt=not-paid-accounts">
                                    <div class="header bg-warning" style="padding-bottom: 12px;padding-top: 10px;">
                                        <h2 class="text-white">Not Paid Accounts: (<span class="total-n-p-accounts">-</span>) <i class="fa fa-arrow-right float-right"></i></h2>
                                        <ul class="header-dropdown">
                                            <!-- <li><button class="btn btn-info btn-sm" data-toggle="modal" data-target="#newCompany">New company</button></li> -->
                                            <!-- <li><button class="btn btn-info btn-sm update-buying-price">update buying price</button></li> -->
                                        </ul>
                                    </div>
                                    </a>
                                    <div class="body pt-0">
                                        <div class="table-responsive">
                                            <table class="table m-b-0 c_list">
                                                <thead> 
                                                    <tr>
                                                        <th>Name</th>                       
                                                        <th></th> 
                                                    </tr>
                                                </thead>
                                                <tbody class="render-n-p-accounts">
                                                    
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
                            <div class="col-12">
                                <div class="card">
                                    <a href="/admin/accounts?opt=end-free-trial-accounts">
                                    <div class="header bg-danger" style="padding-bottom: 12px;padding-top: 10px;">
                                        <h2 class="text-white">End Free Trial Accounts: (<span class="total-e-f-t-accounts">-</span>) <i class="fa fa-arrow-right float-right"></i></h2>
                                        <ul class="header-dropdown">
                                            <!-- <li><button class="btn btn-info btn-sm" data-toggle="modal" data-target="#newCompany">New company</button></li> -->
                                            <!-- <li><button class="btn btn-info btn-sm update-buying-price">update buying price</button></li> -->
                                        </ul>
                                    </div>
                                    </a>
                                    <div class="body pt-0">
                                        <div class="table-responsive">
                                            <table class="table m-b-0 c_list">
                                                <thead> 
                                                    <tr>
                                                        <th>Name</th>                       
                                                        <th></th> 
                                                    </tr>
                                                </thead>
                                                <tbody class="render-e-f-t-accounts">
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-6">                                
                                <div class="card">
                                    <div class="header">
                                        <h2>Currencies:</h2>
                                        <ul class="header-dropdown">
                                            <li><button class="btn btn-info btn-sm" data-toggle="modal" data-target="#newCurrency">New</button></li>
                                        </ul>
                                    </div>
                                    <div class="body">
                                        <!-- <button class="btn btn-success btn-sm move-data">Move data</button> -->
                                    </div>
                                    <div class="body other-roles">
                                        <table class="table m-b-0">
                                            <tbody class="render-currencies">
                                                                    <tr class="switch-role" role="Business Owner">
                                                    <td>Business Owner</td>
                                                    <td class="align-right"><i class="fa fa-arrow-right"></i></td>
                                                </tr>
                                                                    <tr class="switch-role" role="Accountant">
                                                    <td>Accountant</td>
                                                    <td class="align-right"><i class="fa fa-arrow-right"></i></td>
                                                </tr>
                                                                    <tr class="switch-role" role="Sales Person">
                                                    <td>Sales Person</td>
                                                    <td class="align-right"><i class="fa fa-arrow-right"></i></td>
                                                </tr>
                                                                     
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-6">
                                <div class="card top_counter">
                                    <div class="body">
                                        <div id="top_counter3" class="carousel vert slide" data-ride="carousel" data-interval="2300">
                                            <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                    <div class="icon"><i class="fa fa-eye"></i> </div>
                                                    <div class="content">
                                                        <div class="text">Total Visitors</div>
                                                        <h5 class="number">10K</h5>
                                                    </div>
                                                </div>
                                                <div class="carousel-item">
                                                    <div class="icon"><i class="fa fa-eye"></i> </div>
                                                    <div class="content">
                                                        <div class="text">Today Visitors</div>
                                                        <h5 class="number">142</h5>
                                                    </div>
                                                </div>
                                                <div class="carousel-item">
                                                    <div class="icon"><i class="fa fa-eye"></i> </div>
                                                    <div class="content">
                                                        <div class="text">Month Visitors</div>
                                                        <h5 class="number">2,087</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                    
                                        <hr>
                                        <div class="icon"><i class="fa fa-university"></i> </div>
                                        <div class="content">
                                            <div class="text">Revenue</div>
                                            <h5 class="number">$18,925</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="card top_counter">
                                    <div class="body">
                                        <div class="icon"><i class="fa fa-thumbs-o-up"></i> </div>
                                        <div class="content">
                                            <div class="text">Happy Clients</div>
                                            <h5 class="number">528</h5>
                                        </div>
                                        <hr>
                                        <div class="icon"><i class="fa fa-smile-o"></i> </div>
                                        <div class="content">
                                            <div class="text">Smiley Faces</div>
                                            <h5 class="number">2,528</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-6">                                
                                <div class="card">
                                    <div class="header">
                                        <h2>Settings:</h2>
                                        <ul class="header-dropdown">
                                            <li><button class="btn btn-info btn-sm" data-toggle="modal" data-target="#newSetting">New</button></li>
                                        </ul>
                                    </div>
                                    <div class="body">
                                        <div class="table-responsive">
                                            <table class="table m-b-0">
                                                <tbody class="render-settings">
                                                                
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-6">                                
                                <div class="card">
                                    <div class="header">
                                        <h2>Payment Methods:</h2>
                                        <ul class="header-dropdown">
                                            <li><button class="btn btn-info btn-sm" data-toggle="modal" data-target="#newPayMethod">New</button></li>
                                        </ul>
                                    </div>
                                    <div class="body">
                                        <div class="table-responsive">
                                            <table class="table m-b-0">
                                                <tbody>
                                                    <table class="table">
                                                        <tbody class="render-payment-methods"></tbody>
                                                    </table>           
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


<!-- new company modal -->
<div class="modal fade" id="newCompany" tabindex="-1" role="dialog" aria-labelledby="payDModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">New Company</h4>
                <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9">
                    <button class="btn btn-danger btn-sm">x</button>
                </span>
            </div>
            <div class="modal-body"> 
                <form id="basic-form" class="new-company">
                    @csrf
                    <div class="row clearfix">
                        <div class="col-sm-6 offset-sm-3">
                            <div class="form-group">
                                <label>Company name</label>
                                <input type="text" class="form-control" placeholder="Company Name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label class="mb-0">Status</label>
                                <select class="form-control form-control-sm" name="enabled">
                                    <option value="new">New</option>
                                    <!-- <option value="disabled">Disabled</option> -->
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary submit-new-company px-5">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- new currency modal -->
<div class="modal fade" id="newCurrency" tabindex="-1" role="dialog" aria-labelledby="payDModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">New Currency</h4>
                <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9">
                    <button class="btn btn-danger btn-sm">x</button>
                </span>
            </div>
            <div class="modal-body"> 
                <form id="basic-form" class="new-currency">
                    @csrf
                    <div class="row clearfix">
                        <div class="col-sm-6 offset-sm-3">
                            <div class="form-group">
                                <label>Currency name</label>
                                <input type="text" class="form-control" placeholder="i.e Dollar" name="name" required>
                            </div>
                            <div class="form-group">
                                <label>Currency code</label>
                                <input type="text" class="form-control" placeholder="i.e USD" name="code" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary submit-new-currency px-5">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- new setting modal -->
<div class="modal fade" id="newSetting" tabindex="-1" role="dialog" aria-labelledby="payDModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">New Setting</h4>
                <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9">
                    <button class="btn btn-danger btn-sm">x</button>
                </span>
            </div>
            <div class="modal-body"> 
                <form id="basic-form" class="new-setting">
                    @csrf
                    <div class="row clearfix">
                        <div class="col-sm-6 offset-sm-3">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control" cols="30" rows="4"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary submit-new-setting px-5">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- edit modal -->
<div class="modal fade" id="editCompany" tabindex="-1" role="dialog" aria-labelledby="payDModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">Edit Company</h4>
                <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9">
                    <button class="btn btn-danger btn-sm">x</button>
                </span>
            </div>
            <div class="modal-body"> 
                <form id="basic-form" class="edit-company">
                    @csrf
                    <div class="row clearfix">
                        <div class="col-sm-6 offset-sm-3">
                            <input type="hidden" name="cid">
                            <div class="form-group">
                                <label>Company name</label>
                                <input type="text" class="form-control cname" placeholder="Company Name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label class="mb-0">Status</label>
                                <select class="form-control form-control-sm cenabled" name="enabled">
                                    <option value="active">Active</option>
                                    <option value="blocked">Block</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary submit-edit-company px-5">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- <div class="offset-sm-2 col-sm-8 mt-5 conf-link">
                    <label>Company configuration link</label>
                    <div class="pa" style="">  </div>                   
                </div> -->
            </div>
        </div>
    </div>
</div>

<!-- broadcast sms modal -->
<div class="modal fade" id="broadcastSMS" tabindex="-1" role="dialog" aria-labelledby="payDModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">Messages to Broadcast</h4>
                <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9">
                    <button class="btn btn-danger btn-sm">x</button>
                </span>
            </div>
            <div class="modal-body"> 
                <form id="basic-form" class="broadcast-sms-form">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <!-- <b>SMS to Business owners </b>      -->
                            <div class="form-group">     
                                <label>Message</label>                
                                <textarea name="message" class="form-control" rows="4">
                                
                                </textarea>
                                <!-- Sasa unaweza kupata ripoti za biashara yako kila siku kwa njia ya SMS. Ithamini biashara yako kwa kutumia Levanda POS. Tembelea: https://pos.levanda.co.tz/ -->
                            </div>
                            <div class="form-group">
                                <label>Group to receive</label>
                                <select class="form-control" name="br_group">
                                    <option value="owners">Business Owners</option>
                                    <option value="all">All users</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success btn-sm mt-2">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- business owners phone numbers modal -->
<div class="modal fade" id="boPhoneNumbers" tabindex="-1" role="dialog" aria-labelledby="boPhoneNumbers" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">Business Owners with Phone Numbers</h4>
                <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9">
                    <button class="btn btn-danger btn-sm">x</button>
                </span>
            </div>
            <div class="modal-body"> 
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <input type="text" data-provide="datepicker" data-date-autoclose="true" class="form-control bo-date form-control-sm" value="<?php echo date('d/m/Y'); ?>">
                        <hr>                       
                        <div class="render-bo-numbers">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- monthly revenues -->
<div class="modal fade" id="monthlyRevenues" tabindex="-1" role="dialog" aria-labelledby="monthlyRevenues" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">Monthly Revenues</h4>
                <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9">
                    <button class="btn btn-danger btn-sm">x</button>
                </span>
            </div>
            <div class="modal-body"> 
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div>
                            <div class="table-responsive">
                                <table class="table m-b-0 c_list">
                                    <!-- <thead> 
                                        <tr>
                                            <th></th>         
                                            <th></th>      
                                        </tr>
                                    </thead> -->
                                    <tbody class="render-monthly-revenues">

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

<!-- new payment method modal -->
<div class="modal fade" id="newPayMethod" tabindex="-1" role="dialog" aria-labelledby="payDModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">New payment method</h4>
                <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9">
                    <button class="btn btn-danger btn-sm">x</button>
                </span>
            </div>
            <div class="modal-body"> 
                <form id="basic-form" class="new-payment-method">
                    @csrf
                    <div class="row clearfix">
                        <div class="col-sm-6 offset-sm-3">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" placeholder="" name="name" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary submit-new-pay-method px-5">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection
@section('js')
<script type="text/javascript">

    $(document).on('click', '.yesterday-sms-report', function(e){ 
        $.get('/get-data/send-sms/yesterday-report', function(data) {    
            console.log(data.output);
        });         
    });

    $(document).on('click', '.yearly-sms-report', function(e){
        e.preventDefault();
        $.get('/get-data/send-sms/yearly-report', function(data) {               
            console.log(data.output); 
        }); 
    });
    
    // $(document).on('click', '.daily-sales-report', function(e){ 
    //     $.get('/get-data/daily-sales/test', function(data) {    
    //         console.log(data.output);
    //     });         
    // });
    
    $(document).on('click', '.update-payments-test', function(e){

        $.get('/get-data/update-payments-test/test', function(data) {
            console.log('done');
        });
    }); 
    
    $(document).on('click', '.update-sales-date', function(e){

        $.get('/get-data/update-sales-date/test', function(data) {
            console.log(data.sales);
        });
    });

    $(document).on('click', '.move-data', function(e){

        // commented functions were using to migrate data from one db to another

        // $.get('/move-users', function(data) {
        //     console.log(data.status);
        //     $.get('/move-customers', function(data) {
        //         console.log(data.status);
        //         $.get('/move-shops', function(data) {
        //             console.log(data.status);
        //             $.get('/move-products', function(data) {
        //                 console.log(data.status);
        //             });
        //         });
        //     });
        // });
    });

    $(function () { 
        $('.render-agents').html('<tr class="align-center"><td colspan="2">Loading... </td></tr>');
        getCurrencies();
    });

    function getCurrencies() {     
        $('.render-currencies').html('<tr class="align-center"><td colspan="2">Loading... </td></tr>');
        $.get('/get-data/currencies/all', function(data) {    
            $('.render-currencies').html(data.output); 
            getSettings();
        }); 
    }

    function getSettings() {   
        $('.render-settings').html('<tr class="align-center"><td colspan="2">Loading... </td></tr>');
        $.get('/get-data/settings/all', function(data) {    
            $('.render-settings').html(data.output); 
            countAppInstallations();
        }); 
    }

    function countAppInstallations() {       
        $('.count-installs').html('-');
        $.get('/get-data/installations/count', function(data) {    
            $('.count-installs').html(data.output);
            getPaymentMethods();
        }); 
    }

    function getPaymentMethods() {     
        $('.render-payment-methods').html('<tr class="align-center"><td>Loading... </td></tr>');
        $.get('/get-data/payment-methods/all', function(data) {    
            $('.render-payment-methods').html("");
            if (data.payments.length > 0) {
                $(data.payments).each(function(index, value) {
                    $('.render-payment-methods').append('<tr><td>'+value.name+'</td></tr>');
                });
            } else {
                $('.render-payment-methods').html('<tr><td>No data</td></tr>');
            }
            getAgents();
        }); 
    }

    function getAgents() {    
        $.get('/agent/get-agents/7', function(data) {    
            $('.total-agents').html(data.total);
            $('.render-agents').html(data.output);
            getAccountsSummary();
        }); 
    }
    
    function getAccountsSummary() {    
        $.get('/get-data/companies/summary', function(data) {     
            $('.total-accounts').html(data.data.total_accounts);
            $('.f-t-accounts').html(data.data.total_f);
            $('.a-accounts').html(data.data.total_a);
            $('.e-f-t-accounts').html(data.data.total_e_f);
            $('.n-p-accounts').html(data.data.total_n_p);
            getFreeTrialCompanies();
        }); 
    }

    function getFreeTrialCompanies() {      
        $('.render-f-t-accounts').html('<tr class="align-center"><td colspan="2">Loading... </td></tr>');
        $.get('/get-data/companies/free-trial-summary', function(data) {    
            $('.render-f-t-accounts').html(data.output);
            $('.total-f-t-accounts').html(data.data.total);
            console.log(data.data.companies);
            // getActiveCompanies();
        }); 
    }

    function getActiveCompanies() {     
        $('.render-a-accounts').html('<tr class="align-center"><td colspan="2">Loading... </td></tr>');
        $.get('/get-data/companies/active-summary', function(data) {    
            $('.render-a-accounts').html(data.output);
            $('.total-a-accounts').html(data.data.total);
            getNotPaidCompanies();
        }); 
    }

    function getNotPaidCompanies() {    
        $('.render-n-p-accounts').html('<tr class="align-center"><td colspan="2">Loading... </td></tr>');
        $.get('/get-data/companies/not-paid-summary', function(data) {    
            $('.render-n-p-accounts').html(data.output);
            $('.total-n-p-accounts').html(data.data.total);
            getEndFreeTrialCompanies();
        }); 
    }
    
    function getEndFreeTrialCompanies() {     
        $('.render-e-f-t-accounts').html('<tr class="align-center"><td colspan="2">Loading... </td></tr>');
        $.get('/get-data/companies/end-free-trial-summary', function(data) {    
            $('.render-e-f-t-accounts').html(data.output);
            $('.total-e-f-t-accounts').html(data.data.total);
        }); 
    }
    
    $(document).on('click', '.bo-numbers', function(e){
        e.preventDefault();
        $('#boPhoneNumbers').modal('show');   
        $('.bo-date').click();
    });
    $(document).on('change', '.bo-date', function(e){
        e.preventDefault();   
        $('.render-bo-numbers').html('Loading..');
        var date = $(this).val();
        date = date.split('/').join('-');
        $.get('/get-data/bo-numbers/'+date, function(data) {    
            if ($.isEmptyObject(data.owners)) {
                $('.render-bo-numbers').html("<div>No Account Created</div>");
            } else {
                $('.render-bo-numbers').html("<ol></ol>");
                var location = "";
                for (let i = 0; i < data.owners.length; i++) {
                    if (data.owners[i]['rname']) {
                        location = data.owners[i]['dname']+', '+data.owners[i]['rname'];
                    } else {
                        location = data.owners[i]['location'];
                    }
                    $('.render-bo-numbers ol').append("<li>0"+data.owners[i]['phone']+" "+data.owners[i]['cname']+" - "+location+"</li>");                    
                }
            }
        }); 
    });
    
    $(document).on('click', '.monthly-revenues', function(e){
        e.preventDefault();
        $('#monthlyRevenues').modal('show');   
        
        var monthNames = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ];

        var varDate = new Date();
        var month = varDate.getMonth()+1;
        var currentDay = varDate.getDate();

        $('.render-monthly-revenues').html("");

        for ( var i = 0; i <= 11; i++) {
            var now = new Date();
            now.setDate(1);
            var date = new Date(now.setMonth(now.getMonth() - i));
            var datex = ("0" + date.getDate()).slice(-2) + "-" + ("0" + (date.getMonth() + 1)).slice(-2) + "-" + date.getFullYear();
            var monthyear = monthNames[date.getMonth()] + "-" + date.getFullYear();
            $('.render-monthly-revenues').append('<tr><th colspan="2" class="pt-2 pb-0" style="border-top:none">'+monthyear+'</th></tr>'
                +'<tr class="'+monthyear+'">'
                +'<th class="accounts"></th>'
                +'<th class="amount"></th>'
                +'</tr>');
            $.get('/get-data/accounts-monthly-revenues/'+monthyear, function(data) {   
                $.when( 
                    // appendTr(data.monthyear)
                 ).then(function () {
                    for (var j = 0; j < data.numbers.length; j++) {
                        $('.'+data.monthyear+' .accounts').html("Accounts - "+data.numbers[j]['total_accounts']);
                        $('.'+data.monthyear+' .amount').html("<h5>"+Number(data.numbers[j]['paid_amount']).toLocaleString('en')+"</h5>");
                    }
                });
            }); 
        }
        return true;
    });  

    $(document).on('submit', '.new-company', function(e){
        e.preventDefault();
        $('.submit-new-company').prop('disabled', true).html('submiting..');
        var name = $('.new-company [name="name"]').val();
        if (name.trim() == null || name.trim() == '') {
            $('.submit-new-company').prop('disabled', false).html('Submit');
        }
        if (name.trim() == null || name.trim() == '') {
            $('.new-company [name="name"]').addClass('parsley-error').focus(); return;}

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData(this);
        formdata.append('status','new company');
        $.ajax({
            type: 'POST',
            url: '/submit-data',
            processData: false,
            contentType: false,
            data: formdata,
            success: function(data) {
                $('.submit-new-company').prop('disabled', false).html('Submit');
                if (data.status == "success") {
                    popNotification('success',"Success! New Company created successfully.");
                    $('.new-company')[0].reset();
                    $('#newCompany').modal('hide');      
                    getCompanies();
                } else {
                    popNotification('warning',"Error! Failed to create new Company, please try again.");
                }
            }
        });
    });

    $(document).on('submit', '.search-accounts-form', function(e){
        e.preventDefault();
        $('.render-searched-accounts').html('<i class="fa fa-spin fa-spinner"></i>');
        $('.search-accounts-btn').prop('disabled', true).html('<i class="fa fa-spin fa-spinner"></i>');
        
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData(this);
        formdata.append('status','search accounts');
        $.ajax({
            type: 'POST',
            url: '/submit-data',
            processData: false,
            contentType: false,
            data: formdata,
            success: function(data) {
                $('.render-searched-accounts').html('');
                $('.search-accounts-btn').prop('disabled', false).html('<i class="fa fa-search"></i>');
                if(data.type == "accounts") {
                    if(data.data.accounts.length > 0) {
                        $(data.data.accounts).each(function(index, value) {
                            $('.render-searched-accounts').append('<div class="py-1"><a href="/admin/accounts/'+value.id+'">'+value.name+' <i class="fa fa-arrow-right pl-2"></i></a></div>');
                        });
                    } else {
                        $('.render-searched-accounts').html('<div><i>No matches</i></div>');  
                    } 
                }
                if(data.type == "users") {
                    if(data.data.users.length > 0) {
                        $(data.data.users).each(function(index, value) {
                            $('.render-searched-accounts').append('<div class="py-1"><a href="/admin/accounts/'+value.company_id+'">'+value.username+' <i class="fa fa-arrow-right pl-2"></i></a></div>');
                        });
                    } else {
                        $('.render-searched-accounts').html('<div><i>No matches</i></div>');  
                    }
                }
                if(data.type == "shops") {
                    if(data.data.shops.length > 0) {
                        $(data.data.shops).each(function(index, value) {
                            $('.render-searched-accounts').append('<div class="py-1"><a href="/admin/accounts/'+value.company_id+'">'+value.name+' <i class="fa fa-arrow-right pl-2"></i></a></div>');
                        });
                    } else {
                        $('.render-searched-accounts').html('<div><i>No matches</i></div>');  
                    }
                }
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

    $(document).on('click', '.update-buying-price', function(e){
        e.preventDefault();
        $.get('/get-data/buying-cost/22222', function(data) {    
            
            console.log('success');
        }); 
    });

    $(document).on('click', '.edit-company-btn', function(e){
        $('.edit-company')[0].reset();
        $('.conf-link').css('display','none');
        $('#editCompany').modal('toggle');
        var cid = $(this).attr('cid');
        $('.edit-company [name="cid"]').val(cid);
        $.get('/get-data/company/'+cid, function(data) {    
            $('.cname').val(data.company.name);
            $('.cenabled').val(data.company.status);
            if (data.company.contact_person == null) {
                $('.conf-link').css('display','block');
                $(".pa").html("<p><?php echo $hyper_text; ?>://<?php echo $_SERVER['HTTP_HOST']; ?>/company/configuration/"+data.enc_id+"</p>").css({'overflow-y': 'auto'});
            }
        }); 
    });

    $(document).on('submit', '.edit-company', function(e){
        e.preventDefault();
        $('.submit-edit-company').prop('disabled', true).html('updating..');
        var name = $('.edit-company [name="name"]').val();
        if (name.trim() == null || name.trim() == '') {
            $('.submit-edit-company').prop('disabled', false).html('Update');
        }
        if (name.trim() == null || name.trim() == '') {
            $('.edit-company [name="name"]').addClass('parsley-error').focus(); return;}

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData(this);
        formdata.append('status','edit company');
        $.ajax({
            type: 'POST',
            url: '/submit-data',
            processData: false,
            contentType: false,
            data: formdata,
            success: function(data) {
                $('.submit-edit-company').prop('disabled', false).html('Update');
                if (data.status == "success") {
                    popNotification('success',"Success! Company has been updated successfully.");
                    $('.edit-company')[0].reset();
                    $('#editCompany').modal('hide');      
                    getCompanies();
                } else {
                    popNotification('warning',"Error! Failed to edit Company info, please try again.");
                }
            }
        });
    });

    $(document).on('submit', '.new-currency', function(e){
        e.preventDefault();
        $('.submit-new-currency').prop('disabled', true).html('submiting..');
        var name = $('.new-currency [name="name"]').val();
        var code = $('.new-currency [name="code"]').val();
        if (name.trim() == null || name.trim() == '' || code.trim() == null || code.trim() == '') { 
            $('.submit-new-currency').prop('disabled', false).html('Submit'); }
        if (name.trim() == null || name.trim() == '') {
            $('.new-currency [name="name"]').addClass('parsley-error').focus(); return;}
        if (code.trim() == null || code.trim() == '') {
            $('.new-currency [name="code"]').addClass('parsley-error').focus(); return;}

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData(this);
        formdata.append('status','new currency');
        $.ajax({
            type: 'POST',
            url: '/submit-data',
            processData: false,
            contentType: false,
            data: formdata,
            success: function(data) {
                $('.submit-new-currency').prop('disabled', false).html('Submit');
                if (data.status == "success") {
                    popNotification('success',"Success! New Currency created successfully.");
                    $('.new-currency')[0].reset();
                    $('#newCurrency').modal('hide');      
                    getCurrencies();
                } else {
                    popNotification('warning',"Error! Failed to create new Currency, please try again.");
                }
            }
        });
    });

    $(document).on('submit', '.new-payment-method', function(e){
        e.preventDefault();
        $('.submit-new-pay-method').prop('disabled', true).html('submiting..');
        var name = $('.new-payment-method [name="name"]').val();

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData(this);
        formdata.append('status','new payment method');
        $.ajax({
            type: 'POST',
            url: '/submit-data',
            processData: false,
            contentType: false,
            data: formdata,
            success: function(data) {
                $('.submit-new-pay-method').prop('disabled', false).html('Submit');
                if (data.status == "success") {
                    popNotification('success',"Success! New Payment Method created successfully.");
                    $('.new-payment-method')[0].reset();
                    $('#newPayMethod').modal('hide');      
                    getPaymentMethods();
                } else {
                    popNotification('warning',"Error! Failed to create new payment method, please try again.");
                }
            }
        });
    });

    $(document).on('submit', '.new-setting', function(e){
        e.preventDefault();
        $('.submit-new-setting').prop('disabled', true).html('submiting..');
        var name = $('.new-setting [name="name"]').val();
        if (name.trim() == null || name.trim() == '') { 
            $('.submit-new-setting').prop('disabled', false).html('Submit'); }
        if (name.trim() == null || name.trim() == '') {
            $('.new-setting [name="name"]').addClass('parsley-error').focus(); return;}

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData(this);
        formdata.append('status','new setting');
        $.ajax({
            type: 'POST',
            url: '/submit-data',
            processData: false,
            contentType: false,
            data: formdata,
            success: function(data) {
                $('.submit-new-setting').prop('disabled', false).html('Submit');
                if (data.status == "success") {
                    popNotification('success',"Success! New Setting created successfully.");
                    $('.new-setting')[0].reset();
                    $('#newSetting').modal('hide');      
                    getSettings();
                } else {
                    popNotification('warning',"Error! Failed to create new Setting, please try again.");
                }
            }
        });
    });

    $(document).on('submit', '.broadcast-sms-form', function(e){
        e.preventDefault();
        $('.broadcast-sms-form .btn').prop('disabled', true).html('Submiting..');
        
        var formdata = new FormData(this);
        formdata.append('status','broadcast sms');
        $.ajax({
            type: 'POST',
            url: '/submit-data',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.broadcast-sms-form .btn').prop('disabled', false).html('Submit');
                    if (data.status == "success") {
                        popNotification('success','Success! SMS sent successfully.');
                    } else {
                        popNotification('warning','Error! Failed to send SMS.');
                    }
                }
        });
    });
    
    $(document).on('click', '.close-supplier-year', function(e){ 
        e.preventDefault();
        $.get("/suppliers/supplier-close-year-balance/all-suppliers", function(data){
            
            if(data.status == 'success') {
                console.log('success');
            }
        });
    });
    
    // $(document).on('click', '.update-sale-table', function(e){ 
    //     e.preventDefault();
    //     $.get("/suppliers/update-sale-table/all", function(data){
            
    //         console.log('success');
    //     });
    // });
</script>
@endsection

