@extends('layouts.app')

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
                            <div class="header" style="border-bottom:1px solid #ddd;">
                                <h2>Stock Adjustment:
                                    <small class="text-info">Any adjustment of quantity will be recorded.</small>
                                </h2>
                                <ul class="header-dropdown">
                                    <li>
                                        <a href="/ceo/stock/adjust-records" class="btn btn-primary btn-sm">Adjustment Records</a>
                                    </li>
                                </ul>
                            </div>     
                            <div class="body">
                                <div class="form-group">
                                    <select class="form-control-sm shopstore" name="shopstore">
                                        <option class="bg-success text-light" disabled>-- Shops</option>
                                        @if($data['shops'])
                                        @foreach($data['shops'] as $shop)
                                            <option value="shop-{{$shop->id}}">{{$shop->name}}</option>
                                        @endforeach
                                        @endif
                                        <option class="bg-success text-light" disabled>-- Stores</option>
                                        @if($data['stores'])
                                        @foreach($data['stores'] as $store)
                                            <option value="store-{{$store->id}}">{{$store->name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table m-b-0 c_list">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>#</th> 
                                                    <th>Item</th>   
                                                    <th>Av. Quantity</th>  
                                                    <th style="width:150px">New Quantity</th>   
                                                    <th>Description</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody class="render-st-items">
                                                
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

    $(function () {
        var shopstore = $('.shopstore').val();
        appendStockList(shopstore); 
    });

    function appendStockList(shopstore) {
        $('.render-st-items').html('<tr class="asloader"><td><i class="fa fa-spinner fa-spin" style="font-size:15px;"></i> Loading...</td></tr>');
        var split = shopstore.split("-");
        shopstore = split[0]; 
        shopstoreval = split[1];
        $.get('/stock/adjust/'+shopstore+'/'+shopstoreval, function(data) {  
            $('.render-st-items').html(data.items);
        });   
    }

    $(".shopstore").on('change', function(e) {
        e.preventDefault();
        var shopstore = $(this).val();
        var shostoname = $(this).find('option:selected').text();
        appendStockList(shopstore);
    });

    $(document).on("click", ".update-stc", function(e) {
        e.preventDefault();
        $(this).prop('disabled', true).html('updating..');
        var id = $(this).attr("row");
        var status = $(this).attr("status");
        var quantity = $('.q-'+id).val();
        var desc = $('.d-'+id).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var formdata = new FormData();
        formdata.append('id',id);
        formdata.append('quantity',quantity);
        formdata.append('desc',desc);
        formdata.append('status',status);
        $.ajax({
            type: 'POST',
            url: '/update-adjust-stock',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.u-'+data.id).prop('disabled', false).html('Update');
                    if (data.error) {
                        popNotification('warning',data.error);
                    } else {
                        $('.q-'+data.id).val("");
                        $('.d-'+data.id).val("");
                        $('.aq-'+data.id).html(data.quantity);
                        popNotification('success','Successful updated');
                    }
                }
        });
    });

</script>
@endsection