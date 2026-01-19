@extends('layouts.app')
@section('css')
<style type="text/css">
    
.cashier-row {max-width: 300px;}
@media screen and (max-width: 480px) {
    .cashier-row {max-width: 200px;}
    .reduce-padding-2 {padding-left:5px;padding-right:5px;}
    .card .reduce-padding {padding-left:0px;padding-right:0px;}
    .c_list tr td.action-btn .btn {display:block;width:35px;margin-bottom:8px !important}
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

                    <div class="col-md-12 reduce-padding-2">
                        <div class="card">      
                            <div class="header">
                                <h2><?php echo $_GET['stores']; ?>:</h2>
                                @if(Auth::user()->isCEOorAdminorBusinessOwner())
                                <ul class="header-dropdown">
                                    <li>
                                        <button class="btn btn-info btn-sm add-store-2">
                                            <b style=""><?php echo $_GET['create-new-store']; ?></b>
                                        </button>
                                    </li>
                                </ul>
                                @endif
                            </div>     
                            <div class="body pt-0">
                                <div class="row">
                                    <div class="col-12 reduce-padding">
                                        <div class="table-responsive">
                                            <table class="table m-b-0 c_list">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th><?php echo $_GET['store-name']; ?></th>               
                                                        <!-- <th>Location</th>                                -->
                                                        <th><?php echo $_GET['store-master']; ?></th>                                             
                                                        @if($data['isCEO'] == "no")

                                                        @else
                                                        <th><?php echo $_GET['action']; ?></th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                    <tbody>
                                                    @if($data['stores'])
                                                    @foreach($data['stores'] as $value)
                                                        <tr>
                                                            @if($data['isCEO'] == "no")     
                                                            <td style="white-space: normal !important;word-wrap: break-word;">
                                                                <a href="/stores/<?php echo $value->sid; ?>">
                                                                <svg class="w-6 h-6 text-gray-800 dark:text-white" style="width:15px;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                                                </svg> {{$value->name}} </a> <br>
                                                                <i class="fa fa-map-marker"></i> {{$value->location}}
                                                            </td>                                 
                                                            <!-- <td>
                                                                {{$value->location}}
                                                            </td>                              -->
                                                            <td>
                                                            <div class="row">
                                                                <div class="col-md-6 cashier-row">
                                                                    <div class="row">
                                                                        <?php $stores = \DB::table('users')->join('user_stores','user_stores.user_id','users.id')->where('users.company_id',Auth::user()->company_id)->where('user_stores.store_id',$value->store_id)->where('user_stores.who','store master')->get(); ?>
                                                                        @if($stores)
                                                                        @foreach($stores as $store)
                                                                        <span class="badge badge-info mb-2" style="text-align: left;text-transform: capitalize;">{{$store->username}}</span><br>
                                                                        @endforeach
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>             
                                                            </td>
                                                            @else   
                                                            <td style="white-space: normal !important;word-wrap: break-word;">
                                                                <a href="/stores/<?php echo $value->id; ?>">
                                                                <svg class="w-6 h-6 text-gray-800 dark:text-white" style="width:15px;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                                                </svg> {{$value->name}} </a> <br>
                                                                <i class="fa fa-map-marker"></i> {{$value->location}}
                                                            </td>                                                    
                                                            <!-- <td>
                                                                {{$value->location}}
                                                            </td>                                   -->
                                                            <td>
                                                            <div class="row">
                                                                <div class="col-md-6 cashier-row">
                                                                    <div class="row">
                                                                    @if($value->smasters()->isNotEmpty())
                                                                    @foreach($value->smasters() as $smaster)
                                                                        <span class="badge badge-info mb-2" style="text-align: left;text-transform: capitalize;">{{$smaster->username}}</span>
                                                                    @endforeach
                                                                    @endif
                                                                    </div>
                                                                </div>
                                                            </div>              
                                                            </td>   
                                                            <td class="action-btn">  
                                                                <a href="#editStore{{$value->id}}" class="btn btn-info btn-sm edit-store" data-toggle="modal" data-target="#editStore{{$value->id}}"><i class="fa fa-edit"></i></a>
                                                                <a href="#deleteStore{{$value->id}}" class="btn btn-danger btn-sm delete-store" data-toggle="modal" data-target="#deleteStore{{$value->id}}"><i class="fa fa-trash"></i></a>
                                                            </td>
                                                            @endif  
                                                        </tr>
                                                       
@if($data['isCEO'] == "no")

@else
        <!-- edit modal -->
        <div class="modal fade" id="editStore{{$value->id}}" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="title" id="largeModalLabel">Edit store</h4>
                    </div>
                    <div class="modal-body" class="edit-store"> 
                        <!-- <form id="basic-form" class="edit-store" store="{{$value->id}}">
                            @csrf -->
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Store Name</label>
                                        <input type="text" class="form-control" placeholder="Name" name="esname{{$value->id}}" value="{{$value->name}}" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Location</label>
                                        <input type="text" class="form-control" placeholder="Location" name="eslocation{{$value->id}}" value="{{$value->location}}" required>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <label>Store Master(s)</label>
                            @if($value->smasters()->isNotEmpty())
                                @foreach($value->smasters() as $smaster)
                                    <div class="row mb-2" id="rsmaster<?php echo $value->id.$smaster->id; ?>">
                                        <div class="col-sm-6 col-9">
                                            <input type="text" class="form-control form-control-sm" placeholder="Group Name" name="smaster{{$value->id}}" value="{{$smaster->username}}" disabled>
                                        </div>
                                        <div class="col-sm-2 col-3 pl-0">
                                            <button class="btn btn-outline-danger btn-sm untouch-store-master" val="{{$smaster->id}}" store="{{$value->id}}" smaster="{{$smaster->name}}"><i class="fa fa-times"></i> remove </button>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <div class="row mt-4 clearfix">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary submit-edit-store" store="{{$value->id}}" style="width: inherit;">Submit</button>
                                </div>
                            </div>
                        <!-- </form> -->
                        <br>
                    </div>
                    <div class="modal-footer">
                        <!-- <button type="button" class="btn btn-primary">SAVE CHANGES</button> -->
                        <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- delete modal -->
        <div class="modal fade" id="deleteStore{{$value->id}}" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <!-- <h4 class="title" id="largeModalLabel">Edit shop</h4> -->
                        <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9;padding: 0px;margin-top: 1px;margin-right: 1px;margin-bottom: 1px;">
                            <button class="btn btn-danger btn-sm">x</button>
                        </span>
                    </div>
                    <div class="modal-body"> 
                            <div class="row clearfix load-deleting">
                                <div class="col-12">
                                    <p class="text-danger">Do you want to delete <b class="text-info">{{$value->name}}</b> store ?</p> 
                                    By deleting this: <br>
                                    All the information connected to this store will be deleted too permanently <br>
                                    1. Stock records <br>
                                    2. Item(s) transfer records <br>
                                </div>                            
                            </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center align-content-center">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Dont delete</button>
                        <button type="button" class="btn btn-danger btn-sm delete-store2" store="{{$value->id}}">Delete</button>
                    </div>
                </div>
            </div>
        </div>
@endif
                                                    @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 mb-4 reduce-padding">
                                        <div class="accordion" id="accordion" style="margin-top: 80px;">
                                            <div class="">
                                                <div class="card-header" id="headingOne">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link collapsed show-customer" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                            <i class="fa fa-info-circle fa-2x" style="float: left;"></i>
                                                            <div style="float: left;font-weight: bold;padding-top: 5px;padding-left: 10px;"> Maelezo kuhusu stoo</div> 
                                                            <i class="fa fa-angle-down fa-2x" style="float: right;"></i>
                                                        </button>
                                                    </h5>
                                                </div>                                
                                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion" style="border: 2px solid #eee;">
                                                    <div class="card-body" style="padding-bottom: 10px;padding-top: 10px;">                
                                                        <div> <br>
                                                            <b>Stoo/Godown</b> ni sehem ambayo unaitumia kuhifadhia bidhaa zako. <br><br>
                                                            Kama kwenye biashara yako unatumia stoo kuhifadhia bidhaa zako na kuzitoa kidogo kidogo kuzipeleka dukani zinapohitajika basi unaweza kutengeneza stoo hapa ili <br><br> 
                                                            1. Uweze kujua kwa urahisi idadi ya bidhaa zilizopo kwa stoo yako <br>
                                                            2. Uweze kutunza taarifa zote za uingizaji wa stock mpya kwenye stoo yako <br>
                                                            3. Uweze kutunza taarifa zote za uhamishaji (Transfer) wa bidhaa kutoka stoo kwenda dukani/stoo AU kutoka dukani/stoo kuja stoo <br><br>
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
        </div>
    </div>

    
    @include('modals.new-store')


@endsection

@section('js')
<script type="text/javascript">
    
    $(document).on('click', '.add-store-2', function(e){
        e.preventDefault();
        // $('.new-shop')[0].reset();
        $('.check-location-level').html('<input type="hidden" class="user-location2" value="store-page">');
        $('#newStore').modal('toggle');
    });


    $(document).on('click', '.submit-edit-store', function(e){
        e.preventDefault();
        $(this).prop('disabled', true).html('submiting..');
        var store = $(this).attr('store');
        var name = $('[name="esname'+store+'"]').val();
        var location = $('[name="eslocation'+store+'"]').val();
        if (name.trim() == null || name.trim() == '' || location.trim() == null || location.trim() == '') {
            $('.submit-edit-store').prop('disabled', false).html('Submit');
        }
        if (name.trim() == null || name.trim() == '') {
            $('[name="esname'+store+'"]').addClass('parsley-error').focus(); return;}
        if (location.trim() == null || location.trim() == '') {
            $('[name="eslocation'+store+'"]').addClass('parsley-error').focus(); return;}

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData();
        formdata.append('store',store);
        formdata.append('name',name);
        formdata.append('location',location);
        $.ajax({
            type: 'POST',
            url: '/edit-store',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.submit-edit-store').prop('disabled', false).html('Submit');
                    if (data.error) {
                        popNotification('warning',data.error);
                    } else {
                        popNotification('success',data.success);
                        window.location = "/"+urlArray[1]+"/stores";
                    }
                }
        });
    });

    $(document).on('click', '.untouch-store-master', function(e){
        var smaster = $(this).attr('smaster');
        if(confirm("Click OK to confirm that "+smaster+" is no longer store master in this store.")){
            e.preventDefault();
            $('.full-cover').css('display','block');
            var uid = $(this).attr('val');
            var store = $(this).attr('store');

            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            var formdata = new FormData();
            formdata.append('uid',uid);
            formdata.append('store',store);
            $.ajax({
                type: 'POST',
                url: '/untouch-store-master',
                processData: false,
                contentType: false,
                data: formdata,
                    success: function(data) {
                        $('.full-cover').css('display','none');
                        if (data.error) {
                            popNotification('warning',data.error);
                        } else {
                            popNotification('success',data.success);
                            $('#rsmaster'+data.store+data.id).remove();
                        }
                    }
            });
        }
        return;
    });

    $(document).on('click', '.delete-store2', function(e){
        e.preventDefault();
        $('button').prop('disabled',true);
        $('.load-deleting').html('<p><i class="fa fa-spinner fa-spin" style="font-size:20px;"></i> <span style="padding-left:10px">Deleting...</span></p><p style="font-size:16px;color:red">It will take sometime</p>').addClass('padding');
        var store_id = $(this).attr('store');

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData();
        formdata.append('status','delete store');
        formdata.append('store_id',store_id);
        $.ajax({
            type: 'POST',   
            url: '/delete',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    if (data.status == "success") {
                        popNotification('success',"Store deleted successfully.");
                        $(document).ajaxSuccess(function(){
                            window.location.reload();
                        });
                    } else {
                        popNotification('warning','Error.. Something went wrong, please try again.');
                        $(document).ajaxSuccess(function(){
                            window.location.reload();
                        });
                    }
                }
        });
    });
</script>
@endsection