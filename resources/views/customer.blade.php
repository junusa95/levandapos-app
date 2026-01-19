@extends('layouts.app')
@section('css')
<style type="text/css">
    @media screen and (max-width: 560px) {
        input, select, select option {padding-left: 4px !important;padding-right: 5px !important;padding-top: 5px !important;padding-bottom: 5px !important;}
        input {text-align: center;}
        .row .card .header {padding-left: 5px !important;padding-top: 8px;}
        select {
            height: 33px !important;
        }
        .card .body .row {padding: 0px !important;}
        .card .body .row .col-3, .card .body .row .col-12 {padding: 0px 4px 0px 4px !important;}
    }
    @media screen and (max-width: 500px) {
        .header-dropdown {display: block;position: relative !important;text-align: right;right: 0px !important;}
    }
    @media screen and (max-width: 400px) {
        input {font-size: 13px !important;padding-left: 3px !important;padding-right: 3px !important;}
        select {font-size: 13px !important;}
    }
</style>
@endsection

@section('content')
<?php 
    $today = date('d/m/Y');
    $daysago = date('d/m/Y',strtotime("-30 days"));

    if (isset($data['shop'])) {
        $shop_id = $data['shop']->id;
    } else {
        $shop_id = "all";
    }
    $customer_id = $data['customer']->id;
?>
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
                            <div class="header" style="border-bottom: 1px solid #ddd;">
                                <h2>Customer:</h2>
                                <h2 style="font-size:1.3em"><b>{{$data['customer']->name}}</b></h2>
                                <ul class="header-dropdown" style="top: 12px;">
                                	<li>
                                        <button class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#payDModal">
                                            <b style="">Kuweka pesa</b>
                                        </button>
                                        <button class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#borrowMModal">
                                            <b style="">Kopesha/refund</b>
                                        </button>
                                	</li>
                                </ul>
                            </div>
                            <div class="body">
			                    <div class="row filter-c-rec pl-1">
			                        <div class="col-md-3 c col-3">
			                            <select class="form-control form-control-sm change-shop" name="">
			                            @if(isset($data['shop'])) 
			                                <option value="{{$data['shop']->id}}">{{$data['shop']->name}}</option>
			                            @else
			                                <option value="all">All</option>
			                                @if($data['shops'])
			                                @foreach($data['shops'] as $shop)
			                                    <option value="{{$shop->id}}">{{$shop->name}}</option>
			                                @endforeach
			                                @endif
			                            @endif
			                            </select>
			                        </div>
			                        <div class="col-md-2 col-3 d">
			                            <input type="text" name="date_f" data-provide="datepicker" data-date-autoclose="true" class="form-control form-control-sm" placeholder="From" value="<?php echo $daysago; ?>">
			                        </div>
			                        <span style="padding-top: 5px;">to</span>
			                        <div class="col-md-2 col-3 d align-left">
			                            <input type="text" name="date_t" data-provide="datepicker" data-date-autoclose="true" class="form-control form-control-sm" placeholder="From" value="<?php echo $today; ?>">
			                        </div>
			                        <div class="col-md-2 col-2 b" style="">
			                            <button class="btn btn-info btn-sm debt-rec-btn">Check</button>
			                        </div>
			                    </div>
                                <div class="row mt-3">
                                    <!-- <div class="col-sm-12 col-12 mt-3 c-rec-body p-0" style="background:lime"> -->
                                        <div class="table-responsive">
                                            <table class="table table-borderless m-b-0 c_list">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Tarehe</th>
                                                        <th>Tukio</th>
                                                        <th>Deni/Balance</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="render-debt-rec">
                                                    <tr><td></td></tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    <!-- </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- mteja kaweka pesa -->
    <div class="modal fade" id="payDModal" tabindex="-1" role="dialog" aria-labelledby="payDModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Mteja kaweka pesa</h4>
                    <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9">
                        <button class="btn btn-danger btn-sm">x</button>
                    </span>
                </div>
                <div class="modal-body">
                    <form class="lipa-hela-form">
                        <div class="col-md-6" style="margin-left: auto;margin-right: auto;">
                            <div class="form-group">
                                <label class="mb-0">Shop</label>
                                <select class="form-control form-control-sm shop-l-h" name="shop_l_h">
                                @if(isset($data['shop'])) 
                                    <option value="{{$data['shop']->id}}">{{$data['shop']->name}}</option>
                                @else
                                    <option value="">- select -</option>
                                    @if($data['shops'])
                                    @foreach($data['shops'] as $shop)
                                        <option value="{{$shop->id}}">{{$shop->name}}</option>
                                    @endforeach
                                    @endif
                                @endif
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label class="mb-0">Amount</label>
                                <input type="number" class="form-control form-control-sm" name="lipa-amount">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success btn-sm lipa-hela" style="width:100%">Add Payment</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- kopesha / rudisha pesa -->
    <div class="modal fade" id="borrowMModal" tabindex="-1" role="dialog" aria-labelledby="borrowMModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4><?php echo $_GET['lend-refund-head']; ?></h4>
                    <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9">
                        <button class="btn btn-danger btn-sm">x</button>
                    </span>
                </div>
                <div class="modal-body">
                    <form class="basic-form kopesha-form"> 
                        <div class="col-md-6" style="margin-left: auto;margin-right: auto;">
                            <div class="form-group">
                                <label class="mb-0"><?php echo $_GET['shop']; ?></label>
                                <select class="form-control form-control-sm shop-k-h change-shop" name="shop_k_h">
                                @if(isset($data['shop'])) 
                                    <option value="{{$data['shop']->id}}">{{$data['shop']->name}}</option>
                                @else
                                    <option value="">- select -</option>
                                    @if($data['shops'])
                                    @foreach($data['shops'] as $shop)
                                        <option value="{{$shop->id}}">{{$shop->name}}</option>
                                    @endforeach
                                    @endif
                                @endif
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label class="mb-0"><?php echo $_GET['purpose']; ?></label>
                                <select class="form-control purpose" name="purpose" style="width: 100%;">
                                    <option value="refund"> <?php echo $_GET['refund']; ?> </option>
                                    <option value="pay debt"> <?php echo $_GET['pay-debt']; ?> </option>
                                    <option value="lend money"> <?php echo $_GET['lend-money']; ?> </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="mb-0"><?php echo $_GET['amount']; ?></label>
                                <input type="number" class="form-control form-control-sm" name="kopesha_amount">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success btn-sm kopesha-btn" style="width:100%">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script type="text/javascript">
    $('.select2').select2({
        dropdownParent: $('#payDModal')
    });
    $('.select3').select2({
        dropdownParent: $('#borrowMModal')
    });

    var shop_id = "<?php echo $shop_id; ?>";
    var customer_id = "<?php echo $customer_id; ?>";
    var fdate = $('input[name="date_f"]').val();
    var tdate = $('input[name="date_t"]').val();
    fdate = fdate.split('/').join('-');
    tdate = tdate.split('/').join('-');

    $(function () {
        var shop_id = $('.change-shop').val();
        getDebtRecords(fdate,tdate,customer_id,shop_id);
    });

    function getDebtRecords(from,to,customer_id,shop_id) {
        var shopcustomer = shop_id+"~"+customer_id;
        $('.render-debt-rec').html('<tr><td colspan="3">Loading... </td></tr>');
        $.get('/report-by-date-range/debt-records/'+from+'/'+to+'/'+shopcustomer, function(data){ 
            $('.render-debt-rec').html(data.output);
        });
    }

    $(document).on('click', '.debt-rec-btn', function(e){
        e.preventDefault();
        $('.cname').html($(this).text());
        var fdate = $('input[name="date_f"]').val();
        var tdate = $('input[name="date_t"]').val();
        fdate = fdate.split('/').join('-');
        tdate = tdate.split('/').join('-');
        var shop_id = $('.change-shop').val();
        getDebtRecords(fdate,tdate,customer_id,shop_id);
    });

    $(document).on('submit', '.kopesha-form', function(e){
        e.preventDefault();
        $('.kopesha-btn').prop('disabled', true).html('submitting..');
        $('select, input').removeClass('parsley-error');
        var shop_id = $('.shop-k-h').val();
        var purpose = $('.purpose').val();
        var amount = $('input[name="kopesha_amount"]').val();
        if (shop_id.trim() == null || shop_id.trim() == '' || amount.trim() == null || amount.trim() == '' || amount.trim() < 0) {
            $('.kopesha-btn').prop('disabled', false).html('Submit');
        }
        if (shop_id.trim() == null || shop_id.trim() == '') {
            $('.shop-k-h').addClass('parsley-error').focus(); return;}
        if (amount.trim() == null || amount.trim() == '' || amount.trim() < 0) {
            $('input[name="kopesha_amount"]').addClass('parsley-error').focus(); return;}

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData(this);
        formdata.append('status','kopesha pesa');
        formdata.append('customer_k_h',customer_id);
        $.ajax({
            type: 'POST',
            url: '/submit-data',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.kopesha-btn').prop('disabled', false).html('Submit');
                    if (data.error) {
                        popNotification('warning',data.error);
                    } else {
                        popNotification('success',data.success);
                        $('.kopesha-form')[0].reset();
                        $('.modal').modal('hide');      
                        getDebtRecords(fdate,tdate,customer_id,shop_id);
                    }
                }
        });
    });

    $(document).on('submit', '.lipa-hela-form', function(e){
        e.preventDefault();
        $('.lipa-hela').prop('disabled', true).html('adding..');
        $('select, input').removeClass('parsley-error');
        var shop_id = $('.shop-l-h').val();
        var amount = $('input[name="lipa-amount"]').val();
        if (shop_id.trim() == null || shop_id.trim() == '' || amount.trim() == null || amount.trim() == '' || amount.trim() < 0) {
            $(this).prop('disabled', false).html('Add Payment');
        }
        if (shop_id.trim() == null || shop_id.trim() == '') {
            $('.shop-l-h').addClass('parsley-error').focus(); return;}
        if (amount.trim() == null || amount.trim() == '' || amount.trim() < 0) {
            $('input[name="lipa-amount"]').addClass('parsley-error').focus(); return;}

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData(this);
        formdata.append('status','lipa hela');
        formdata.append('customer_l_h',customer_id);
        formdata.append('amount',amount);
        $.ajax({
            type: 'POST',
            url: '/submit-data',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.lipa-hela').prop('disabled', false).html('Submit');
                    if (data.error) {
                        popNotification('warning',data.error);
                    } else {
                        popNotification('success',data.success);
                        $('.lipa-hela-form')[0].reset();
                        $('.modal').modal('hide');      
                        getDebtRecords(fdate,tdate,customer_id,shop_id);
                    }
                }
        });
    });
</script>
@endsection