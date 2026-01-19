@extends('layouts.app')
@section('css')
<style type="text/css">
    
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
                                <h2><?php echo $_GET['pending-stock']; ?></h2>
                                <ul class="header-dropdown">
                                    @if(Auth::user()->isCEOorAdmin())
                                    <li>
                                        <!-- <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#newStock">
                                            <b style=""><?php //echo $_GET['add-new-stock']; ?></b>
                                        </button> -->
                                    </li>
                                    @endif
                                </ul>
                            </div>
                            <div class="body pt-0" style="">                                
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table m-b-0 c_list">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Item Name</th> 
                                                    <th>Qty</th>    
                                                    <th>Time Sent</th>   
                                                    <th>Status</th>  
                                                    <th></th>
                                                </tr>
                                            </thead>
                                                <tbody>
                                                @if($data['pendingstock']->isNotEmpty())
                                                @foreach($data['pendingstock'] as $value)
                                                    <tr>
                                                        <td>
                                                            {{$value->product->name}}
                                                        </td>
                                                        <td>
                                                            {{sprintf('%g',$value->added_quantity)}}
                                                        </td>                                     
                                                        <td>
                                                            {{$value->updated_at}}
                                                        </td>    
                                                        <td>
                                                            @if($value->status == 'sent')
                                                                <span class="badge badge-secondary pb-1 status<?php echo $value->id; ?>">Pending</span>
                                                            @endif
                                                            @if($value->status == 'updated')
                                                                <span class="badge badge-success pb-1 status<?php echo $value->id; ?>">Received</span>
                                                            @endif
                                                        </td>
                                                        <td>  
                                                            <a href="#" class="btn btn-warning btn-sm receiveStock btn{{$value->id}}" val="{{$value->id}}">Receive <i class="fa fa-arrow-down"></i></a>                        
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @else
                                                <tr><td colspan="5" style="text-align:center"><i>-- No pending stock --</i></td></tr>
                                                @endif
                                                </tbody>
                                        </table>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12">
                        <div class="card">      
                            <div class="header">
                                <h2><?php echo $_GET['previous-stock-records']; ?>:</h2>
                            </div>     
                            <div class="body pt-0">
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table m-b-0 c_list">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Item Name</th> 
                                                    <th>Qty</th>    
                                                    <th>Status</th>  
                                                    <th>Time Sent</th>   
                                                    <th>Sent By</th>
                                                    <th>Time Received</th>   
                                                    <th>Received By</th>
                                                </tr>
                                            </thead>
                                            <tbody class="received-stock">
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

    @include('modals.new-stock')

@endsection

    

@section('js')
<script type="text/javascript">
    
    var shop_id = $('[name="shopid"]').val();

    $(function () {
        $('.sold-products, .render-st-items').prepend('<tr class="asloader"><td><i class="fa fa-spinner fa-spin" style="font-size:15px;"></i> Rendering...</td></tr>');
        $('.received-stock').html('<tr class="asloader"><td><i class="fa fa-spinner fa-spin" style="font-size:15px;"></i> Rendering...</td></tr>');
    
        $.get('/new-stock/pending/shop/'+shop_id, function(data) {  
            $('.asloader').hide(); 
            $('.render-st-items').append(data.items);
            $('.totalStQ').html(data.totalStQ);    
        });   
        $.get('/new-stock/received/shop/'+shop_id, function(data) {              
            $('.received-stock').append(data.items);
        });   
    });
</script>
@endsection