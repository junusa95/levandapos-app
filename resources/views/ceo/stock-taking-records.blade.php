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
<style type="text/css">    
    @media screen and (max-width: 767px) {
        .asblocks .body {margin-bottom: 20px;}
    }
    @media screen and (max-width: 555px) {
        .asblocks .body {padding-left: 10px;padding-right: 10px;}
    }
    @media screen and (max-width: 476px) {
        .asblocks .st, .asblocks .rd {padding-left: 0px;}
        .asblocks .nd, .asblocks .th {padding-right: 0px;}
    }
</style>
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12">
                        <div class="card">      
                            <div class="header" style="border-bottom:1px solid #ddd;">
                                <h2>Stock Taking Records:</h2>
                                <ul class="header-dropdown">
                                    @if(Auth::user()->isCEOorAdmin())
                                    <li>
                                        <a href="/ceo/stock/taking" class="btn btn-primary btn-sm">Stock Taking</a>
                                    </li>
                                    @endif
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
                                <div class="row asblocks">
                                    <div class="col-lg-3 col-md-3 col-6 st" style="">
                                        <div class="body xl-turquoise">     
                                            <br>                                 
                                            <!-- <h4>3,845</h4> -->
                                            <span>Stock taking from <h5 class="titems" style="display:inline-block;"></h5> items</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-6 nd">
                                        <div class="body xl-slategray">                                        
                                            <h5 class="balance">0</h5>
                                            <span>Times the stock has balanced.</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-6 rd">
                                        <div class="body xl-khaki">                                        
                                            <h5 class="increase">0</h5>
                                            <span>Total increase.</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-6 th">
                                        <div class="body xl-salmon">                                        
                                            <h5 class="decrease">0</h5>
                                            <span>Total loss.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="table-responsive mt-3">
                                        <table class="table">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>#</th> 
                                                    <th>Item</th>   
                                                    <th>Av. Quantity</th>  
                                                    <th>New Quantity</th>   
                                                    <th>Impact</th> 
                                                    <th>Updated by</th>
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
        appendStockList(shopstore); 
    });

    function appendStockList(shopstore) {
        $('.render-st-items').html('<tr class="asloader"><td><i class="fa fa-spinner fa-spin" style="font-size:15px;"></i> Loading...</td></tr>');
        $('.balance').html("--"); $('.increase').html("--"); $('.decrease').html("--");
        var split = shopstore.split("-");
        shopstore = split[0]; 
        shopstoreval = split[1];
        $.get('/stock/st-records/'+shopstore+'/'+shopstoreval, function(data) {  
            $('.balance').html(data.data.balance); $('.increase').html(data.data.increase); $('.decrease').html(data.data.decrease); $('.titems').html(data.data.titems);
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