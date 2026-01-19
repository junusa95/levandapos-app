
@include('layouts.translater')

<style type="text/css">
    .top-b .select {padding-left: 10px;}
    .top-b label {margin-bottom: 0px;}
    .top-b button {margin-top: 20px;}
    .top-b .from, .top-b .to {padding-left: 5px;padding-right: 5px;}
    .header h2 {font-size: 18px;}
    @media screen and (max-width: 997px) {
        .top-b .select {margin-left: 20px;}
    }
    @media screen and (max-width: 861px) {
        .top-b .select {margin-left: 30px;}
    }
    @media screen and (max-width: 800px) {
        .top-b .select {margin-left: 35px;}
    }
    select.select2 {
        width: 150px !important;height: 100px !important;
    }
    @media screen and (max-width: 767px) {
        .top-b .select {padding-left: 0px;margin-left: 5px;}
        select.select2 { width: 180px !important; }
        .top-b .sel1 {padding-left: 5px;padding-right: 5px;}
        .top-b .sel1 select {width: 100%;}
        .top-b .from, .top-b .to, .ts-btn {margin-top: -7px;}
    }
    @media screen and (max-width: 480px) {
        .top-b .select {margin-left: 0px !important;}
        select.select2 { width: 150px !important; }
        .top-b button {margin-top: 18px;}
    }
</style>

<?php 

if ($data['item']) {
    $item = $data['item']->product_id;
} else {
    $item = 0;
}

?>
    <div class="row pt-3 pb-2 top-b" style="background:#f4f7f6">
        <div class="col-12">     
            <div class="header p-0 mb-3">
                <h2><?php echo $_GET['item-activities']; ?>:</h2>
            </div>  
        </div>
        <div class="col-md-2 col-sm-4 col-5 sel1">
            <div class="form-group">
                <label>Shop/store</label><br>
                <select class="form-control-sm change-shopstore2" name="" style="width: 100%;">
                    <option value="all">All</option>
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
        </div>
        <div class="col-md-2 col-sm-4 col-5 select">
            <div class="form-group">
                <label>Item name</label>
                <select class="form-control-sm change-product select2" name="">
                    <option value="select">Select item</option>
                    @if($data['products'])
                    @foreach($data['products'] as $product)
                        <option value="{{$product->id}}">{{$product->name}}</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="col-md-2 col-4 offset-md-1 from">
            <div class="form-group">
                <label>From</label>
                <input type="text" name="date_fa" data-provide="datepicker" data-date-autoclose="true" class="form-control form-control-sm" placeholder="From" value="<?php echo date('d/m/Y', mktime(0, 0, 0, date("m") , date("d") - 5, date("Y"))); ?>">
            </div>            
        </div>
        <div class="col-md-2 col-4 align-left to">
            <div class="form-group">
                <label>To</label>
                <input type="text" name="date_ta" data-provide="datepicker" data-date-autoclose="true" class="form-control form-control-sm" placeholder="From" value="<?php echo date('d/m/Y'); ?>">
            </div>            
        </div>
        <div class="col-md-2 col-2 ts-btn">
            <button class="btn btn-info btn-sm check-i-activities">Check</button>
        </div>
    </div>

    <div class="row mt-3">
        <div class="table-responsive">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th>Date</th>
                        <th>Activities</th>
                        <th>Stock Balance</th>
                    </tr>
                </thead>
                <tbody class="render-activities" style="background-color: #f4f7f6;">

                </tbody>
            </table>
        </div>
    </div>


    <script type="text/javascript">
        $('.select2').select2();

        $(function () {
            var item = "<?php echo $item; ?>";
            if (item != 0) {
                $('.change-product').val(item).change();
                $('.check-i-activities').click();
            }
        });

        $(document).on('click','.check-i-activities',function(e){
            e.preventDefault();
            var fdate = $('input[name="date_fa"]').val();
            var tdate = $('input[name="date_ta"]').val();
            var shopstore = $('.change-shopstore2').val();
            var product = $('.change-product').val();
            fdate = fdate.split('/').join('-');
            tdate = tdate.split('/').join('-');
            productActivities(shopstore,product,fdate,tdate);
        });

        function productActivities(shopstore,item,from,to) {
            var shopstoreitem = shopstore+"~"+item;
            $('.render-activities').html('<tr><td colspan="3">Loading... <br> Itachukua muda kidogo..</td></tr>');
            $.get('/report-by-date-range/product-activities/'+from+'/'+to+'/'+shopstoreitem, function(data){ 
                if(data.output.length > 0) {
                    $('.render-activities').html(data.output);
                } else {
                    $('.render-activities').html('<tr><td colspan="3" align="center"><i>-- Empty records --</i></td></tr>');
                }                
            });
        }
    </script>