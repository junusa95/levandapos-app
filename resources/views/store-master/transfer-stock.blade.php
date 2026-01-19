@extends('layouts.app')
@section('css')
<style type="text/css">
    .transfer-form .col-6 {padding-left: 5px;padding-right: 5px;}
    .select2-selection__rendered {
        line-height: 31px !important;
    }
    .select2-container .select2-selection--single {
        height: 35px !important;
    }
    .select2-selection__arrow {
        height: 34px !important;
    }
    .select2-container {
        /*text-align: center;*/
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
                    <div class="col-lg-7 col-md-12">
                        <div class="card">      
                            <div class="header" style="border-bottom:1px solid #ddd;">
                                <h2>Transfer Item(s):</h2>
                            </div>     
                            <div class="body">
                                <form id="basic-form" class="transfer-form">
                                    @csrf
                                    <input type="hidden" name="from" value="store">
                                    <input type="hidden" name="fromid" value="{{$data['store']->id}}">
                                    <input type="hidden" name="transferno" value="null">
                                    <input type="hidden" name="transferval" value="">
                                    <div class="row clearfix">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Select shop/store</label>
                                                <select class="form-control shopstore" name="shopstore" required>
                                                    <option value="">- select -</option>
                                                    <option class="bg-success text-light" disabled>-- Shops</option>
                                                    @if($data['shops'])
                                                        @foreach($data['shops'] as $shop)
                                                            <option value="shop-{{$shop->id}}">{{$shop->name}}</option>
                                                        @endforeach
                                                    @else
                                                        <option disabled><i>- null -</i></option>
                                                    @endif
                                                    <option class="bg-success text-light" disabled>-- Stores</option>
                                                    @if($data['stores'])
                                                        @foreach($data['stores'] as $store)
                                                            <option value="store-{{$store->id}}">{{$store->name}}</option>
                                                        @endforeach
                                                    @else
                                                        <option disabled><i>- null -</i></option>
                                                    @endif
                                                </select>
                                                <input type="hidden" name="whereto" value="">
                                                <input type="hidden" name="shostoval" value="">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Select shipper</label>
                                                <select class="form-control shipper" name="shipper" required>
                                                    <option value="">- select -</option>
                                                    @if($data['users'])
                                                        @foreach($data['users'] as $user)
                                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                                        @endforeach
                                                    @else
                                                        <option disabled><i>- no user -</i></option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Select product</label>
                                                <select class="form-control select2 product" name="product" required>
                                                    <option value="">- select -</option>
                                                    @if($data['products'])
                                                        @foreach($data['products'] as $product)
                                                            <option value="{{$product->id}}">{{$product->name}}</option>
                                                        @endforeach
                                                    @else
                                                        <option disabled><i>- no product -</i></option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Quantity</label>
                                                <input type="number" class="form-control" placeholder="Quantity" name="quantity" step="0.01" value="1" style="width:75%" required>
                                                <span class="text-success aquantity" style="float: right;margin-top: -20px;font-weight: bold;">0</span>
                                            </div>
                                        </div>
                                        <!-- <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea name="description" class="form-control" placeholder="Description"></textarea>
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-sm-12 mt-3">
                                            <button type="submit" class="btn btn-primary submit-transfer" style="width: inherit;">Add to cart</button>
                                        </div>
                                    </div>
                                </form>
                            </div>                            
                        </div>
                    </div>

                    <div class="col-lg-5 col-md-12">
                        <div class="card">      
                            <div class="header">
                                <h2>Products cart:</h2>
                            </div>     
                            <div class="body">
                                <div style="margin-top: -20px;margin-bottom: 20px;">
                                    <div>
                                        <strong>Sent to:</strong><span class="bg-dark text-light px-2 py-1 ml-2 shostoname"></span>
                                    </div>
                                    <div class="mt-1">
                                        <strong>Shipper:</strong><span class="bg-dark text-light px-2 py-1 ml-2 shippername"></span>
                                    </div>   
                                </div>
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table m-b-0 c_list" style="border-bottom: 1px solid #ddd;">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Qty</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody class="render-cart">

                                            </tbody>
                                        </table>
                                        <div class="pull-right mt-2">
                                            <i class="fa fa-spinner fa-spin" style="font-size:20px;display: none;"></i>
                                            <button class="btn btn-danger btn-sm clear-transfer-cart">Clear all </button>
                                            <button class="btn btn-success btn-sm submit-transfer-cart">Done <i class="fa fa-check"></i></button>
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

    <!-- modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body align-center text-danger">
                    <p class="error-modal"></p>
                </div>
                <div class="py-2" style="text-align:center; border-top: 1px solid #ddd;">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Decline</button>
                    <button type="button" class="btn btn-primary btn-sm clear-transfer-cart">Accept</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
<script type="text/javascript">

    $('.select2').select2();

    var store_id = $('[name="fromid"]').val();

    $(function () {
        $.get('/pending-transfer/store/'+store_id, function(data){
            if (data.item.status == 'edit') {
                $('.editing-no-h').css('display','');
                $('.editing-no').html('Editing Transfer #: '+data.item.transfer_no);
                $('[name="transferno"]').val(data.item.transfer_no);
                $('[name="transferval"]').val(data.item.transfer_val);
            } 
            $('.shopstore').val(data.item.destination+'-'+data.item.destination_id).change();
            $('.shipper').val(data.shipper.id).change();
            $('[name="whereto"]').val(data.item.destination);
            $('[name="shostoval"]').val(data.item.destination_id); 
            $('.render-cart').html(data.cart);
        });
    });

    $(".shopstore").on('change', function(e) {
        e.preventDefault();
        var shopstoreval = $(this).val();
        var shostoname = $(this).find('option:selected').text();
        var split = shopstoreval.split("-");
        var whereto = split[0]; 
        shopstoreval = split[1];
        $.get('/shopstore/store/'+store_id+'/'+whereto+'/'+shopstoreval, function(data){
            if (data.error) {
                $('.error-modal').html(data.error);
                $('#exampleModal').modal('toggle');
                // alert(data.error)
            } else {       
                $('[name="whereto"]').val(whereto);  
                $('[name="shostoval"]').val(shopstoreval);  
                $('.shostoname').html(shostoname+' ('+whereto+')');   
            }
        });
    });

    $(".shipper").on('change', function(e) {
        e.preventDefault();
        var name = $(this).find('option:selected').text();
        $('.shippername').html(name);
    });

    $(".product").on('change', function(e) {
        e.preventDefault();
        var pid = $(this).val();
        $.get('/shopstore/store/'+store_id+'/'+pid, function(data){
            $('.aquantity').html(data.quantity);
        });
    });

    $(document).on('submit', '.transfer-form', function(e){
        e.preventDefault();
        $('.submit-transfer').prop('disabled', true).html('Adding..');
        var quantity = $('[name="quantity"]').val();
        var aquantity = $('.aquantity').text();
        if (parseInt(quantity) < 1) {
            $('.submit-transfer').prop('disabled', false).html('Add to cart');
            popNotification('warning','Sorry! Quantity must be greater than 0.');
            $('[name="quantity"]').addClass('parsley-error').focus(); return;
        }
        if (parseInt(quantity) > parseInt(aquantity)) {
            $('.submit-transfer').prop('disabled', false).html('Add to cart');
            popNotification('warning','Sorry! The quantity cant exceed what we have in stock.');
            $('[name="quantity"]').addClass('parsley-error').focus(); return;
        }

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData(this);
        $.ajax({
            type: 'POST',
            url: '/submit-transfer',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.submit-transfer').prop('disabled', false).html('Add to cart');
                    if (data.error) {
                        if (data.error == 'This item is already in cart') {
                            $('.ptr-'+data.id).addClass('l-parpl');
                            setTimeout(function(){
                                $('.ptr-'+data.id).removeClass('l-parpl');
                            },5000);
                        }
                        popNotification('warning',data.error);
                    } else {
                        $('.render-cart').append('<tr class="ptr-'+data.row.id+'"><td>'+data.pname+'</td>'+
                            '<td>'+data.row.quantity+'</td>'+
                            '<td><span class="p-1 text-danger remove-item" val="'+data.row.id+'" style="cursor: pointer;"><i class="fa fa-times"></i></span>'+
                            '</td></tr>');
                        popNotification('success','Added.');
                        // window.location = "/"+urlArray[1]+"/users";
                    }
                }
        });
    });

    $(document).on('click', '.clear-transfer-cart', function(e) {
        e.preventDefault();
        var store_id = $('[name="fromid"]').val();
        $('button').prop('disabled', true);
        $('.fa-spin').css('display','');
        $.get('/clear-transfer-cart/store/'+store_id, function(data){
            location.reload();
        });
    });

    $(document).on('click', '.remove-item', function(e){
        e.preventDefault();
        var id = $(this).attr('val');
        $.get('/remove-transfer-row/'+id, function(data){
            if (data.error) {
                popNotification('warning',data.error);
            }
            if (data.success) {
                $('.ptr-'+data.id).closest("tr").remove();
            }            
        });
    });

    $(document).on('click', '.submit-transfer-cart', function(e){
        e.preventDefault();
        var store_id = $('[name="fromid"]').val();
        var transferno = $('[name="transferno"]').val();
        if (transferno) {} else {
            transferno = 'null';
        }
        $('button').prop('disabled', true);
        $('.fa-spin').css('display','');
        $.get('/submit-transfer-cart/store/'+store_id+'/'+transferno, function(data){
            // alert(data.success);
            location.reload();
        });
    });
</script> 
@endsection