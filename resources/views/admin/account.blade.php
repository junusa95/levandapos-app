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
                                <div class="card">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="header pb-0"><h2>General info:</h2><hr> </div>
                                            <div class="body pt-0">
                                                <ul class="pl-2" style="list-style: none;">
                                                    <li><b>Account name:</b><span style="font-weight: bold;font-size: 18px;"> {{$data['account']->name}}</span></li>
                                                    <li><b>Contact person:</b><span> @if($data['account']->contactPerson){{$data['account']->contactPerson->username." (0".$data['account']->contactPerson->phone.")"}}@endif</span></li>
                                                    <?php 
                                                        $cdate = new DateTime($data['account']->created_at); 
                                                        $scolor = "warning";
                                                        if($data['account']->status == "free trial") {
                                                            $scolor = "primary";
                                                        }
                                                        if($data['account']->status == "active") {
                                                            $scolor = "success";
                                                        }
                                                    ?>
                                                    <li><b>Created at:</b><span> {{$cdate->format('d/m/Y h:i A')}}</span></li>
                                                    <li><b>Status:</b><span class="bg-{{$scolor}} ml-1 pb-1 pr-1"> {{ucfirst($data['account']->status)}}</span></li>
                                                </ul>                                                
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="header pb-0"><h2>Payments:</h2><hr> </div>
                                            <div class="body pt-0">
                                                <ul class="pl-2" style="list-style: none;">
                                                    <li><b>Last paid date:</b><span> </span></li>
                                                    <li><b>When to renew:</b><span> </span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 mb-3">
                        <button class="btn btn-info btn-sm add-payment">Add payment</button>
                        <button class="btn btn-primary btn-sm prev-payments">Payments</button>
                        <button class="btn btn-success btn-sm send-sms-report" style="float:right;">Send SMS Report</button>
                    </div>

                    <div class="col-lg-12 col-md-12">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="header">
                                        <h2>Shops:</h2> 
                                    </div>
                                    <div class="body pt-0">
                                        <div class="table-responsive">
                                            <table class="table m-b-0 c_list">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Name</th>                      
                                                        <th>Last activity</th> 
                                                        <th>Created date</th>                
                                                        <th style="text-align: center;">Payment status</th>   
                                                    </tr>
                                                </thead>
                                                <tbody class="render-shops">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-12 col-md-12">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="header">
                                        <h2>Stores:</h2>
                                    </div>
                                    <div class="body pt-0">
                                        <div class="table-responsive">
                                            <table class="table m-b-0 c_list">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Name</th>                        
                                                        <th>Last activity</th> 
                                                        <th>Created date</th>              
                                                        <th style="text-align: center;">Payment status</th>  
                                                    </tr>
                                                </thead>
                                                <tbody class="render-stores">
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                    <div class="col-lg-12 col-md-12">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="header">
                                        <h2>Users:</h2>
                                    </div>
                                    <div class="body pt-0">
                                        <div class="table-responsive">
                                            <table class="table m-b-0 c_list">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Name</th>                   
                                                        <th>Status</th>                      
                                                        <th>Last login</th>               
                                                        <th>Created at</th>   
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if($data['account']->users)
                                                    <?php $num = 1; ?>
                                                    @foreach($data['account']->users as $user)
                                                    <tr>
                                                        <td>{{$num}}</td>
                                                        <td>
                                                            <span style="display: inline-block;"><h6 class="margin-0">{{$user->name}}</h6><span>( <a href="#">{{$user->username}}</a> )</span></span>
                                                        </td>
                                                        <td>{{$user->status}}</td>
                                                        <td>{{$user->updated_at}}</td>
                                                        <td>{{$user->created_at}}</td>
                                                        <td><a href="#" class="edit-user-btn" uid="{{$user->id}}" uname="{{$user->username}}">Manage user</a></td>
                                                    </tr>
                                                    <?php $num++; ?>
                                                    @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-12 col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="body">
                                        <div class="row">
                                            <div class="col">
                                                <p class="mb-0"><b>Created product categories</b></p>    
                                                <h3 class="render-p-c">-</h3>       
                                                <p class="mb-0 mt-3"><b>Created products</b></p>    
                                                <h3 class="render-p">-</h3>         
                                            </div>               
                                            <div class="col" style="">
                                                <p class="mb-0"><b>Created customers</b></p>    
                                                <h3 class="render-c">-</h3>      
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

<!-- reset password modal -->
<div class="modal fade" id="resetPwd" tabindex="-1" role="dialog" aria-labelledby="resetPwdModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">Manage user</h4>
                <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9">
                    <button class="btn btn-danger btn-sm">x</button>
                </span>
            </div>
            <div class="modal-body"> 
                <div class="row">
                    <div class="col-md-6">
                        <div><h5>Reset password</h5></div>
                        <form id="basic-form" class="reset-pwd-frm">
                            @csrf
                            <div class="">
                                <input type="hidden" name="uid" value="">
                                <div class="form-group">
                                    <label>User name</label>
                                    <input type="text" class="form-control" name="uname" value="" disabled>
                                </div>
                                <div class="form-group pass_show">
                                    <label class="mb-0">Enter New Password</label>
                                    <input type="password" class="form-control" name="pwd" value="" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary submit-reset-pwd px-5">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <div class="render-roles" align="right">

                        </div>
                        <div class="mt-4" align="right">
                            <button class="btn btn-info assign-business-owner-role">Assign B.O role</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- add payment modal -->
<div class="modal fade" id="addPayment" tabindex="-1" role="dialog" aria-labelledby="addPaymentdModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">Add payment</h4>
                <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9">
                    <button class="btn btn-danger btn-sm">x</button>
                </span>
            </div>
            <div class="modal-body render-shops-stores-payments mb-4">  

            </div>
        </div>
    </div>
</div>

<!-- prev payments modal -->
<div class="modal fade" id="prevPayments" tabindex="-1" role="dialog" aria-labelledby="prevPaymentsdModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">Previous payments</h4>
                <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9">
                    <button class="btn btn-danger btn-sm">x</button>
                </span>
            </div>
            <div class="modal-body mb-4 px-0 pt-0"> 
                <div class="table-responsive">
                    <table class="table m-b-0 c_list">
                        <thead class="thead-light">
                            <tr>
                                <th><?php echo $_GET['amount']; ?></th>
                                <th><?php echo $_GET['description']; ?></th>
                                <th><?php echo $_GET['paid-date']; ?></th>
                            </tr>
                        </thead>
                        <tbody class="render-prev-payments">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- send sms report modal -->
<div class="modal fade" id="sendSMSReport" tabindex="-1" role="dialog" aria-labelledby="sendSMSReportdModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">Send SMS Report</h4>
                <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9">
                    <button class="btn btn-danger btn-sm">x</button>
                </span>
            </div>
            <div class="modal-body mb-4 px-0 pt-0"> 
                <form id="basic-form" class="send-sms-report-form">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 offset-md-3 sms-loader" style="display:none;">
                            <i class="fa fa-spinner fa-spin"></i>
                        </div>
                        <div class="col-md-6 offset-md-3 mt-2">
                            <div class="form-group">
                                <label>Pick shop</label>
                                <select class="form-control" name="smsshop">
                                    <!-- <option value="all">All</option> -->
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Who to send</label>
                                <select class="form-control" name="smswho">
                                    <!-- <option value="all">All</option> -->
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Choose date</label>
                                <input type="date" class="form-control" name="smsdate">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success">Submit</button>
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
    
    $(function () { 
        $('.render-shops, .render-stores').html('<tr class="align-center"><td colspan="6">Loading... </td></tr>');
        accountShops();
    });

    function accountShops(){
        $.get('/get-data/account-shops/<?php echo $data["account"]->id; ?>', function(data) {    
            if(data.shops) {
                $('.render-shops').html(data.shops);
            } else {
                $('.render-shops').html('<tr class="align-center"><td colspan="6">No shops created</td></tr>');
            }          
            accountStores();   
        });         
    }
    
    function accountStores(){
        $.get('/get-data/account-stores/<?php echo $data["account"]->id; ?>', function(data) {    
            if(data.stores) {
                $('.render-stores').html(data.stores);
            } else {
                $('.render-stores').html('<tr class="align-center"><td colspan="6">No stores created</td></tr>');
            }          
            countProductsCatsCust();
        });   
    }

    function countProductsCatsCust() {
        $.get('/get-data/count-account-p-cats/<?php echo $data["account"]->id; ?>', function(data) {    
            $('.render-p-c').html(data.total); 
        }); 
        $.get('/get-data/count-account-products/<?php echo $data["account"]->id; ?>', function(data) {    
            $('.render-p').html(data.total); 
        }); 
        $.get('/get-data/count-account-customers/<?php echo $data["account"]->id; ?>', function(data) {    
            $('.render-c').html(data.total); 
        }); 
    }

    $(document).ready(function(){
        $('.pass_show').append('<span class="ptxt">Show</span>');  
    });

    $(document).on('click','.pass_show .ptxt', function(){
        $(this).text($(this).text() == "Show" ? "Hide" : "Show"); 
        $(this).prev().attr('type', function(index, attr){return attr == 'password' ? 'text' : 'password'; }); 
    });  

    $(document).on('click', '.edit-user-btn', function(e){
        e.preventDefault();
        $('.render-roles').html("<i class='fa fa-spinner fa-spin fa-2x'></i>");
        $('.reset-pwd-frm')[0].reset();
        $('#resetPwd').modal('toggle');
        var uid = $(this).attr('uid');
        var uname = $(this).attr('uname');
        $('.assign-business-owner-role').attr('uid',uid);
        $('.reset-pwd-frm [name="uname"]').val(uname);
        $('.reset-pwd-frm [name="uid"]').val(uid);
        
        $.get('/get-data/user-roles/'+uid, function(data) {   
            $('.render-roles').html(""); 
            if(data.roles) {
                $.each(data.roles, function(key, val) {
                    $('.render-roles').append(val.name+"<br>");
                });
            }            
        }); 
    });
    
    $(document).on('click', '.assign-business-owner-role', function(e){
        e.preventDefault();
        $(this).prop('disabled', true).html("<i class='fa fa-spinner fa-spin'></i> Updating..");
        var uid = $(this).attr('uid');
        
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData();
        formdata.append('user',uid);
        formdata.append('check','assign-bo-role');
        $.ajax({
            type: 'POST',
            url: '/edit-user',
            processData: false,
            contentType: false,
            data: formdata,
            success: function(data) {
                $('.assign-business-owner-role').prop('disabled', false).html('Assign B.O role');
                console.log(data.status);
                if (data.status == "success") {
                    popNotification('success',"Success! B.O role assigned successfully.");
                } else {
                    popNotification('warning',"Error! Failed to assign B.O role, please try again.");
                }
            }
        });
    });

    $(document).on('submit', '.reset-pwd-frm', function(e){
        e.preventDefault();
        $('.submit-reset-pwd').prop('disabled', true).html('updating..');
        var uid = $('.reset-pwd-frm [name="uid"]').val();
        var password = $('.reset-pwd-frm [name="pwd"]').val();
        if (password.trim() == null || password.trim() == '' || password.length<4) {
            $('.submit-reset-pwd').prop('disabled', false).html('Update');
            $('.reset-pwd-frm [name="pwd"]').addClass('parsley-error').focus(); return;
        } else {
            var pass = password.trim();
            var count = pass.length;
            const regex = /^(?=.*[0-9])(?=.*[A-Za-z])[A-Za-z0-9]+$/; //check for alphanumeric
            const regex2 = /[a-zA-Z0-9]+[(@!#\$%\^\&*\)\(+=._-]{1,}/; // check for alphanumeric + special characters
            if (count < 4) {
                $('.submit-update-pwd').prop('disabled', false).html('Update'); $('.error2-alert').css('display',"").children('.badge').html("-- Password has to start with 4 digits, Must be alphanumeric, you can use special characters.");
                $('.reset-pwd-frm [name="pwd"]').removeClass('parsley-success').addClass('parsley-error').focus(); return;
            } else {
                if( regex.test(pass) ) {
                    $('.reset-pwd-frm [name="pwd"]').removeClass('parsley-error');
                } else {
                    if( regex2.test(pass) ) {
                        $('.reset-pwd-frm [name="pwd"]').removeClass('parsley-error');
                    } else {
                        $('.submit-update-pwd').prop('disabled', false).html('Update'); $('.error2-alert').css('display',"").children('.badge').html("-- Password has to start with 4 digits, Must be alphanumeric, you can use special characters.");
                        $('.reset-pwd-frm [name="pwd"]').removeClass('parsley-success').addClass('parsley-error').focus(); return;
                    }
                }
            }
        }

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData(this);
        formdata.append('password',password);
        formdata.append('user',uid);
        formdata.append('check','update user password');
        $.ajax({
            type: 'POST',
            url: '/edit-user',
            processData: false,
            contentType: false,
            data: formdata,
            success: function(data) {
                $('.submit-reset-pwd').prop('disabled', false).html('Update');
                if (data.status == "success") {
                    popNotification('success',"Success! User password has been updated successfully.");
                    $('.reset-pwd-frm')[0].reset();
                    $('#resetPwd').modal('hide');    
                } else {
                    popNotification('warning',"Error! Failed to reset user password, please try again.");
                }
            }
        });
    });
    
    $(document).on('click', '.add-payment', function(e){
        $('.render-shops-stores-payments').html("<div align='center'>Loading..</div>");
        $('#addPayment').modal('toggle');
        $.get('/get-data/shops-stores-payments/<?php echo $data["account"]->id; ?>', function(data) {    
            if(data.view) {
                $('.render-shops-stores-payments').html(data.view);
            } 
        });         
    });

    $(document).on('click', '.prev-payments', function(e){
        $('.render-prev-payments').html("<div align='center'>Loading..</div>");
        $('#prevPayments').modal('toggle');
        $.get('/get-data/company-prev-payments/<?php echo $data["account"]->id; ?>', function(data) {    
            if(data.view) {
                $('.render-prev-payments').html(data.view);
            } 
        });         
    });

    $(document).on('click', '.send-sms-report', function(e){
        $('.render-prev-payments').html("<div align='center'>Loading..</div>");
        $('#sendSMSReport').modal('toggle');
        $('.sms-loader').css('display','block');
        $.get('/get-data/sms-report-data/<?php echo $data["account"]->id; ?>', function(data) {  
            $('.sms-loader').css('display','none');
            if ($.isEmptyObject(data.data.shops)) { } else {
                for (var i = 0; i < data.data.shops.length; i++) {
                    $('[name="smsshop"]').append('<option value="'+data.data.shops[i]["id"]+'">'+data.data.shops[i]["name"]+'</option>');
                }
            }
            if ($.isEmptyObject(data.data.bowners)) { } else {
                for (var j = 0; j < data.data.bowners.length; j++) {
                    $('[name="smswho"]').append('<option value="'+data.data.bowners[j]["uid"]+'">'+data.data.bowners[j]["uname"]+'</option>');
                }
            }
        });         
    });

    $(document).on('submit', '.send-sms-report-form', function(e){
        e.preventDefault();
        $('.send-sms-report-form .btn').prop('disabled', true).html('Submiting..');
        
        // var shops = new Array();
        // $('[name="sms-shop"] option').each(function() {
        //     shops.push($(this).val());
        // });
        
        var formdata = new FormData(this);
        formdata.append('status','send sms report');
        $.ajax({
            type: 'POST',
            url: '/submit-data',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.send-sms-report-form .btn').prop('disabled', false).html('Submit');
                    if (data.status == "success") {
                        popNotification('success','Success! SMS sent successfully.');
                    } else if (data.status == "no sales") {
                        popNotification('warning','Error! No Sales in this Date.');
                    } else {
                        popNotification('warning','Error! Failed to send SMS.');
                    }
                }
        });
    });
    
    $(document).on('submit', '.sh-st-payment-frm', function(e){
        e.preventDefault();
        $('.sh-st-payment-btn').prop('disabled', true).html('Submiting..');
        
        var user = $('.sh-st-payment-frm [name="user"]').val();

        // calculate sum of paid amount
        var sum = 0;
        $('.sh-st-payment-frm .pamount').each(function(){            
            if(this.value) {
                sum += parseFloat(this.value);
            }            
        });

        if (sum == '' || sum == 0 || sum == null || isNaN(sum)) {
            $('.sh-st-payment-btn').prop('disabled', false).html('Submit');
            popNotification('warning','Please fill amount with expire date first');
        } else {
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            var formdata = new FormData(this);
            formdata.append('status','subscription payment');
            formdata.append('sum',sum);
            $.ajax({
            type: 'POST',
            url: '/submit-data',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.sh-st-payment-btn').prop('disabled', false).html('Submit');
                    if (data.status == 'empty') {
                        popNotification('warning','Please fill amount with expire date first');
                    } else {
                        popNotification('success','Payment submitted successfully'); 
                        $(document).ajaxSuccess(function(){
                            window.location.reload();
                        });
                    }
                }
            });        
        }
    });




</script>
@endsection