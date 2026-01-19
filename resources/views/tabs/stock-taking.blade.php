

@include("layouts.translater") 


<style type="text/css">    
    .asblocks .body {padding: 15px;}
    @media screen and (max-width: 767px) {
        .asblocks .body {margin-bottom: 15px;}
        .nav-tabs-new2 {margin-left: 0px !important;}
    }
    @media screen and (max-width: 555px) {
        .asblocks .body {padding-left: 10px;padding-right: 10px;margin-left: -10px;margin-right: -10px;}
    }
    @media screen and (max-width: 476px) {
        .asblocks .body {margin-left: -10px;margin-right: -10px;margin-bottom: 10px;}
    }
</style>

    <div class="" style="margin-left:-15px;margin-right:-15px">     
        <div>
            <ul class="nav nav-tabs-new2">
                <li class="nav-item"><a class="nav-link taking-in-form active show" data-toggle="tab" href="#takingInForm"><?php echo $_GET['stock-taking-menu']; ?></a></li>
                <li class="nav-item itemA"><a class="nav-link taking-in-records" data-toggle="tab" href="#takingInRecords"><?php echo $_GET['stock-taking-records']; ?></a></li>
            </ul> 
        </div>

        <div class="tab-content p-0" style="background-color: #f9f6f2;">
            <div class="tab-pane show active" id="takingInForm">
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
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="render-stf-items">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane" id="takingInRecords">    
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
                                <tbody class="render-str-items">
                                    
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
        $('.taking-in-form').click();
    });
    
    $(document).on('click', '.taking-in-form', function(e) {
        e.preventDefault();
        $('#takingInForm').addClass('active');
        $("#takingInForm .shopstore").change();
    });

    $("#takingInForm .shopstore").on('change', function(e) {
        e.preventDefault();
        var shopstore = $(this).val();
        $('.render-stf-items').html('<tr class="asloader"><td><i class="fa fa-spinner fa-spin" style="font-size:15px;"></i> Loading...</td></tr>');
        var split = shopstore.split("-");
        shopstore = split[0]; 
        shopstoreval = split[1];
        $.get('/stock/taking/'+shopstore+'/'+shopstoreval, function(data) {  
            $('.render-stf-items').html(data.items);
        });   
    });

    $(document).on('click', '.taking-in-records', function(e) {
        e.preventDefault();
        $('#takingInRecords').addClass('active');
        $("#takingInRecords .shopstore").change();
    });

    $("#takingInRecords .shopstore").on('change', function(e) {
        e.preventDefault();
        $('.render-str-items').html('<tr class="asloader"><td><i class="fa fa-spinner fa-spin" style="font-size:15px;"></i> Loading...</td></tr>');
        $('.balance').html("--"); $('.increase').html("--"); $('.decrease').html("--");          
        var shopstore = $(this).val();
        var split = shopstore.split("-");
        shopstore = split[0]; 
        shopstoreval = split[1];
        $.get('/stock/st-records/'+shopstore+'/'+shopstoreval, function(data) {  
            $('.balance').html(data.data.balance); $('.increase').html(data.data.increase); $('.decrease').html(data.data.decrease); $('.titems').html(data.data.titems);
            if(data.items) {
                $('.render-str-items').html(data.items);
            } else {
                $('.render-str-items').html('<tr class="asloader"><td colspan="7"><i>-- No records --</i></td></tr>');
            }            
        });   
    });

    $(document).on("click", ".update-stt", function(e) {
        e.preventDefault();
        $(this).prop('disabled', true).html('updating..');
        var id = $(this).attr("row");
        var status = $(this).attr("status");
        var quantity = $('.qt-'+id).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var formdata = new FormData();
        formdata.append('id',id);
        formdata.append('quantity',quantity);
        formdata.append('status',status);
        $.ajax({
            type: 'POST',
            url: '/update-stock-taking',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.u-'+data.id).prop('disabled', false).html('Update');
                    if (data.error) {
                        popNotification('warning',data.error);
                    } else {
                        $('.qt-'+data.id).val("");
                        $('.d-'+data.id).val("");
                        $('.aq-'+data.id).html(data.quantity);
                        popNotification('success','Successful updated');
                    }
                }
        });
    });

</script>