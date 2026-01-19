

@include("layouts.translater") 


<style type="text/css">
    .sa-block {
        margin-top:auto;margin-bottom: 10px;
    }
    .sa-block .body {padding: 10px;}
    .titems {
        display:inline-block;
    }
    @media screen and (max-width: 767px) {
        .nav-tabs-new2 {margin-left: 0px !important;}
    }
</style>


    <div class="" style="margin-left:-15px;margin-right:-15px">     
        <div class="">
            <ul class="nav nav-tabs-new2">
                <li class="nav-item"><a class="nav-link adjust-in-form active show" data-toggle="tab" href="#adjustInForm"><?php echo $_GET['adjust-stock-menu']; ?></a></li>
                <li class="nav-item itemA"><a class="nav-link adjust-in-records" data-toggle="tab" href="#adjustInRecords"><?php echo $_GET['adjustment-records']; ?></a></li>
            </ul> 
        </div>

        <div class="tab-content p-0" style="background-color: #f9f6f2;">
            <div class="tab-pane show active" id="adjustInForm">
                <div class="body">
                    <div class="form-group">
                        <label class="mb-0"><?php echo $_GET['choose-shop-store']; ?></label><br>
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

            <div class="tab-pane" id="adjustInRecords">                 
                <div class="body">
                    <div class="row render-sa-summary mb-2">
                        
                    </div>
                    <div class="form-group">
                        <label class="mb-0"><?php echo $_GET['choose-shop-store']; ?></label><br>
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
                                <thead class="thead-light">
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
                                <tbody class="render-us-items">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
              
    </div>


    
<script type="text/javascript">
    $(function () {
        $('.adjust-in-form').click();
    });
    
    $(document).on('click', '.adjust-in-form', function(e) {
        e.preventDefault();
        $('#adjustInForm').addClass('active');
        $("#adjustInForm .shopstore").change();
    });
    
    $("#adjustInForm .shopstore").on('change', function(e) {
        e.preventDefault();
        var shopstore = $(this).val();
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
    
    $(document).on('click', '.adjust-in-records', function(e) {
        e.preventDefault();
        $('#adjustInRecords').addClass('active');
        $("#adjustInRecords .shopstore").change();
    });
    
    $("#adjustInRecords .shopstore").on('change', function(e) {
        e.preventDefault();
        $('.render-us-items').html('<tr class="asloader"><td><i class="fa fa-spinner fa-spin" style="font-size:15px;"></i> Loading...</td></tr>');
        $.get('/stock/records/all/all', function(data) { 
            $('.render-sa-summary').html(data.items);
        });   
        var shopstore = $(this).val();
        appendUpdatedStock(shopstore);
    });
    
    function appendUpdatedStock(shopstore) {
        var split = shopstore.split("-");
        shopstore = split[0]; 
        shopstoreval = split[1];
        $.get('/stock/records/'+shopstore+'/'+shopstoreval, function(data) {  
            if(data.items) {
                $('.render-us-items').html(data.items);
            } else {
                $('.render-us-items').html('<tr class="asloader"><td colspan="7"><i>-- No records --</i></td></tr>');
            }            
        });   
    }
    
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