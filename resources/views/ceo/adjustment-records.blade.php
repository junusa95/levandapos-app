@extends('layouts.app')

@section('css')
<style type="text/css">
    .sa-block {
        margin-top:auto;margin-bottom: 10px;
    }
    .titems {
        display:inline-block;
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
                            <div class="header" style="border-bottom:1px solid #ddd;">
                                <h2>Adjustment Records:</h2>
                                <ul class="header-dropdown">
                                    @if(Auth::user()->isCEOorAdmin())
                                    <li>
                                        <a href="/ceo/stock/adjust" class="btn btn-primary btn-sm">Stock Adjustment</a>
                                    </li>
                                    @endif
                                </ul>
                            </div>     
                            <div class="body">
                                <div class="row render-sa-summary">
                                    
                                </div>
                                <div class="form-group mt-5">
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
                                        <table class="table table-hover m-b-0 c_list">
                                            <thead>
                                                <tr>
                                                    <th>#</th> 
                                                    <th>Item</th>   
                                                    <th>Av. Quantity</th>  
                                                    <th>New Quantity</th>   
                                                    <th>Description</th> 
                                                    <th>Udjusted by</th>
                                                    <th>Date</th>
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
        $.get('/stock/records/all/all', function(data) { 
            $('.render-sa-summary').html(data.items);
        });   
        appendStockList(shopstore); 
    });

    function appendStockList(shopstore) {
        $('.render-st-items').html('<tr class="asloader"><td><i class="fa fa-spinner fa-spin" style="font-size:15px;"></i> Loading...</td></tr>');
        var split = shopstore.split("-");
        shopstore = split[0]; 
        shopstoreval = split[1];
        $.get('/stock/records/'+shopstore+'/'+shopstoreval, function(data) {  
            if(data.items) {
                $('.render-st-items').html(data.items);
            } else {
                $('.render-st-items').html('<tr class="asloader"><td colspan="7"><i>-- No records --</i></td></tr>');
            }            
        });   
    }

    $(".shopstore").on('change', function(e) {
        e.preventDefault();
        var shopstore = $(this).val();
        var shostoname = $(this).find('option:selected').text();
        appendStockList(shopstore);
    });

</script>
@endsection