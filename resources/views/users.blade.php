@extends('layouts.app')
@section('css')
<style type="text/css">
    .vh-100 {
        min-height: 50vh;
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
                        <div class="card">      
                            <div class="header">
                                <h2><?php echo $_GET['users']; ?>:</h2>
                                <ul class="header-dropdown">
                                    <li>
                                        <?php
                                            $role = '-';
                                            if (Session::get('role') == "CEO") {
                                                $role = "ceo";
                                            } elseif (Session::get('role') == "Business Owner") {
                                                $role = "business-owner";
                                            } 
                                        ?>
                                        <a href="/users/create" class="btn btn-primary btn-sm"><?php echo $_GET['create-user']; ?> </a>
                                    </li>
                                </ul>
                            </div>     
                            <div class="body pt-0">
                                <div class="row">
                                    <div class="table-responsive vh-100">
                                        <table class="table m-b-0 c_list">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Name</th>                                   
                                                    <th>Contacts</th>                              
                                                    <th>Roles</th>
                                                    <th style="text-align: right;">Status</th>
                                                </tr>
                                            </thead>
                                                <tbody>
                                                @if($data['users'])
                                                @foreach($data['users'] as $value)
                                                    <tr>
                                                        <td>
                                                            <?php 
                                                                $url = "-";
                                                                if (Session::get('role') == 'CEO') {
                                                                    $url = "ceo";
                                                                }
                                                                if (Session::get('role') == 'Business Owner') {
                                                                    $url = "business-owner";
                                                                }
                                                            ?>
                                                            <span style="display:inline-flex;">
                                                                @if($value->profile)
                                                                <?php $src = 'images/companies/'.$value->company->folder.'/profiles/'. $value->profile; ?>
                                                                @else
                                                                    @if($value->gender == 'Female')
                                                                    <?php $src = "images/companies/woman2.png"; ?>
                                                                    @else
                                                                    <?php $src = "images/companies/man.png"; ?>
                                                                    @endif
                                                                @endif
                                                                <img src="{{ asset($src) }}" class="rounded-circle avatar mr-3" alt="">
                                                                <span style="display: inline-block;"><h6 class="margin-0">{{$value->name}}</h6><span>( <a href="/users/{{$value->id}}">{{$value->username}}</a> )</span></span>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <small>Email: </small><span>{{$value->email}}</span><br>
                                                            <small>Phone: </small><span class="phone">+{{$value->phonecode.' '.$value->phone}}</span>
                                                        </td>                                
                                                        <td>
                                                        @if($value->roles()->get()->isNotEmpty())
                                                            @foreach($value->roles()->get() as $role)
                                                                <span class="badge badge-success">{{$role->name}}</span>
                                                            @endforeach
                                                        @endif
                                                        </td>
                                                        <td>  
                                                            <!-- <a href="/{{$url}}/users/{{$value->id}}" class="btn btn-info btn-sm edit-user"><i class="fa fa-edit"></i></a> -->
                                                            <?php  
                                                                $color = "";
                                                                $sname = "";
                                                                if ($value->status == 'active') {
                                                                    $color = "btn-success";
                                                                    $sname = "Active";
                                                                } elseif ($value->status == "blocked") {
                                                                    $color = "btn-secondary";
                                                                    $sname = "Blocked";
                                                                } elseif ($value->status == "inactive") {
                                                                    $color = "btn-secondary";
                                                                    $sname = "Not Active";
                                                                }
                                                            ?>
                                                            
                        <div class="dropdown">
                            <a class="btn {{$color}} btn-sm" href="#" role="button" id="dropdownMenuLink{{$value->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="float: right;">
                                {{$sname}} <i class="fa fa-caret-down"></i>
                            </a>    
                            <div class="dropdown-menu py-0" aria-labelledby="dropdownMenuButton" style="margin-top:0px;margin-right: 0px;border-radius:5px">
                                <a class="dropdown-item bg-success text-light change-status" action="Activate" uid="{{$value->id}}" select="<?php if ($value->status == 'active') {echo "true";} else {echo "false";} ?>" style="border-radius: 5px 5px 0px 0px;" href="#">Active</a>
                                <a class="dropdown-item bg-secondary text-light change-status" action="Block" uid="{{$value->id}}" select="<?php if ($value->status == 'blocked') {echo "true";} else {echo "false";} ?>" href="#">Block</a>
                                <a class="dropdown-item bg-danger text-light change-status" action="Delete" uid="{{$value->id}}" select="<?php if ($value->status == 'deleted') {echo "true";} else {echo "false";} ?>" style="border-radius: 0px 0px 5px 5px;" href="#">Delete</a>
                            </div>
                        </div>
                                                        </td>
                                                    </tr>
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

            </div>
        </div>
    </div>
@endsection

@section('js')
<script type="text/javascript">

    $(document).on('click', '.change-status', function(e) {
        e.preventDefault();
        var action = $(this).attr('action');
        var selected = $(this).attr('select');
        var uid = $(this).attr('uid');
       
        if (selected == 'true') {
            
        } else {
            if(confirm("Click OK to confirm that you "+action+" this user.")){
                $('.full-cover').css('display','block');
                $('.full-cover .inside').html('Processing...');
                $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
                var formdata = new FormData();
                formdata.append('uid',uid);
                formdata.append('action',action);
                formdata.append('check','update user status');
                $.ajax({
                    type: 'POST',
                    url: '/edit-user',
                    processData: false,
                    contentType: false,
                    data: formdata,
                    success: function(data) {
                        $('.full-cover').css('display','none');
                        if (data.status == 'error') {
                            popNotification('warning',"Something went wrong! Please try again.");
                        } 
                        if(data.status == 'success') {
                            popNotification('success',"Success! "+data.uname+"'s status is updated successfully.");
                            $(document).ajaxSuccess(function(){
                                window.location.reload();
                            });
                        }
                    }
                });
            }
            return;
        }
    });

</script>
@endsection