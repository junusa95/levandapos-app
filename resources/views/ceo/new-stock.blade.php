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
                            <div class="header">
                                <h2><?php echo $_GET['pending-stock']; ?>:</h2>
                                <ul class="header-dropdown">
                                    <li>
                                        <!-- <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#newStock">
                                            <b style="">Add new stock</b>
                                        </button> -->
                                        <a href="/ceo/products?opt=new-stock" class="btn btn-info btn-sm"><?php echo $_GET['add-new-stock']; ?></a>
                                    </li>
                                </ul>
                            </div>     
                            <div class="body pt-0">
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table m-b-0 c_list">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th><?php echo $_GET['to-shop-store']; ?></th> 
                                                    <th><?php echo $_GET['quantity']; ?></th>  
                                                    <th><?php echo $_GET['date']; ?></th>   
                                                    <th>Status</th>
                                                    <th><?php echo $_GET['action']; ?></th>
                                                </tr>
                                            </thead>
                                                <tbody>
                                                @if(!$data['pendingstock']->isEmpty())
                                                @foreach($data['pendingstock'] as $value)
                                                    <tr>
                                                        <td>
                                                            @if($value->shop_id)
                                                            {{$value->shop->name}}
                                                            @endif
                                                            @if($value->store_id)
                                                            {{$value->store->name}}
                                                            @endif
                                                            ( @if($value->shop_id) shop @endif
                                                              @if($value->store_id) store @endif )
                                                        </td>                                     
                                                        <td>
                                                            @if($value->shop_id)
                                                                <?php echo App\Http\Controllers\ProductController::stockQuantity('shop',$value->shop_id); ?>
                                                            @endif
                                                            @if($value->store_id)
                                                                <?php echo App\Http\Controllers\ProductController::stockQuantity('store',$value->store_id); ?>
                                                            @endif
                                                            
                                                        </td>    
                                                        <td>
                                                            {{$value->updated_at}}
                                                        </td>
                                                        <td>
                                                            @if($value->status == 'sent')
                                                                <span class="badge badge-secondary pb-1">Pending</span>
                                                            @endif
                                                        </td>   
                                                        <td>  
                                                            <a href="#" class="btn btn-info btn-sm viewStock" val="{{$value->id}}"><i class="fa fa-eye"></i></a>                        
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @else
                                                <tr class="empty-row"><td colspan="6" align="center"><i>-- No pending stock --</i></td></tr>
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
                                                    <th><?php echo $_GET['item-name']; ?></th> 
                                                    <th><?php echo $_GET['quantity']; ?></th>   
                                                    <th><?php echo $_GET['shop-store']; ?></th>    
                                                    <th>Status</th>  
                                                    <th><?php echo $_GET['sent-time']; ?></th>   
                                                    <th><?php echo $_GET['sent-by']; ?></th>
                                                    <th><?php echo $_GET['received-time']; ?></th>   
                                                    <th><?php echo $_GET['received-by']; ?></th>
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
    @include('modals.new-stock-view')

@endsection

@section('js')
<script type="text/javascript">

    $(function () {
        $('.sold-products, .render-st-items').prepend('<tr class="asloader"><td><i class="fa fa-spinner fa-spin" style="font-size:15px;"></i> Rendering...</td></tr>');
        $('.received-stock').html('<tr class="asloader2"><td><i class="fa fa-spinner fa-spin" style="font-size:15px;"></i> Rendering...</td></tr>');
    
        $.get('/ceo/report/pending-stock/', function(data) {  
            $('.asloader').hide(); 
            $('.render-st-items').append(data.items);
            $('.totalStQ').html(data.totalStQ);    
            if (data.destid) {
                $('.shopstore').val(data.destid).change();
            }            
            $('.destname').html(data.whereto);    
            previousStock();
        });   
    });

    function previousStock() {
        $.get('/ceo/report/received-stock/', function(data) {  
            $('.asloader2').hide(); 
            $('.received-stock').append(data.items);
        });   
    }

    $(".shopstore").on('change', function(e) {
        e.preventDefault();
        $('.full-cover').css('display','block');
        $('.full-cover .inside').html('wait...');
        var shopstoreval = $(this).val();
        var shostoname = $(this).find('option:selected').text();
        var split = shopstoreval.split("-");
        var whereto = split[0]; 
        shopstoreval = split[1];
        $.get('/shopstore/ceo/0/'+whereto+'/'+shopstoreval, function(data){
            $('.full-cover').css('display','none');
            $('[name="whereto"]').val(whereto);  
            $('[name="shostoval"]').val(shopstoreval);  
            $('.destname').html(shostoname+' ('+whereto+')');  
        });
    });

    $(".viewStock").on('click', function(e) {
        e.preventDefault();
        $('.render-st-items2').html("");
        $('#newStockView').modal('toggle');
        var id = $(this).attr('val');
        $.get('/new-stock/view/'+id, function(data){
            $('.render-st-items2').append(data.items);
            $('.totalStQ').html(data.totalStQ);    
            $('.destname2').html(data.whereto);  
            $('.delete-p-stock').attr("delid",data.id);
        });
    });

    $(".edit-p-stock").on('click', function(e) {
        e.preventDefault();
        var check = $(this).attr('val');
        if (check == 'edit') {
            $('.st-quantity').prop("disabled", false).focus();
            $(this).attr('val','submit').html("Done");
        } else {
            location.reload(true);
        }
    });

    $(".delete-p-stock").on('click', function(e) {
        e.preventDefault();
        if(confirm("Click OK to confirm that you delete this transfer stock")){
            var id = $(this).attr('delid');
            $.get('/new-stock/delete/'+id, function(data){
                location.reload(true);  
            });
        }
    });
</script>
@endsection