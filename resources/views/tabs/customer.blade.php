
@include("layouts.translater")

<style type="text/css">
    
    .table-responsive .c_list {
        font-size: 14px;
    }
    li.nostyle {
        list-style-type: none;
    }
    .view-bought-items {padding: 5px;padding-left: 8px;padding-right: 8px; cursor: pointer;color: #17a2b8;}
    .xl-turquoise {background-color: #eceeef !important;}    
    .render-debt-rec .edit {color:red;cursor:pointer;}

    .supp-action {float: right;margin-top: -65px;}
    .supp-action button {display: block;}
    .supp-action button.btn-outline-danger {margin-top: 6px;}

    @media screen and (max-width: 560px) {
        input, select, select option {padding-left: 4px !important;padding-right: 5px !important;padding-top: 5px !important;padding-bottom: 5px !important;}
        input {text-align: center;}
        .row .card .header {
            padding-left: 5px !important;
            /* padding-top: 8px; */
        }
        select {
            height: 33px !important;
        }
        /* .card .body .row {padding: 0px !important;} */
        .card .body .row .col-3, .card .body .row .col-12 {padding: 0px 4px 0px 4px !important;}
    }
    @media screen and (max-width: 500px) {
        .header-dropdown {
            /* display: block;position: relative !important; */
            text-align: right;right: 0px !important;}
    }
    @media screen and (max-width: 480px) {
        .table-responsive .c_list {
            font-size: 12px;
        }
        .filter-c-rec .btn.btn-sm {padding: 0.26rem 0.5rem;}
        .header-dropdown {
            top: 20px !important;
        }
    }
    @media screen and (max-width: 400px) {
        input {font-size: 13px !important;padding-left: 3px !important;padding-right: 3px !important;}
        select {font-size: 13px !important;}
    }
</style>

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

<input type="hidden" name="customer_id" value="<?php echo $data['customer']->id; ?>">
<div class="row clearfix">
    <div class="col-lg-12 col-md-12">
        <div class="card">   
            <div class="body pt-0">
                <div class="row">
                    <div class="col-md-8 offset-md-2 cust-block">   
                        <div class="row">
                            <div class="col-12 px-0">
                                <div class="header px-0" style="border-bottom: 1px solid #ddd;">
                                    <a href="#" class="customers-tab px-1"><i class="fa fa-arrow-left pr-1"></i> </a> | <span class="pl-1"><?php echo $_GET['customers']; ?></span>
                                    <!-- <h2>Customer:</h2> -->
                                    <ul class="header-dropdown" style="top: 12px;right: 0px;">
                                        <li>
                                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#createCustomer">
                                                <i class="fa fa-plus text-white pr-1" style="font-size: 14px;"></i> <?php echo $_GET["new-customer"]; ?>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-3 px-0">
                                <div class="p-3" style="background: #f9f6f2;">
                                    <h5>{{$data['customer']->name}}</h5><div>{{$data['customer']->phone}}</div>
                                    <div style="margin-top: -2px;"><i class="fa fa-map-marker"></i> <small>{{$data['customer']->location}}</small></div>
                                    <div class="supp-action">
                                        <button class="btn btn-outline-warning edit-customer-btn" cid="{{$data['customer']->id}}" cname="{{$data['customer']->name}}" cphone="{{$data['customer']->phone}}" clocation="{{$data['customer']->location}}" cgender="{{$data['customer']->gender}}"><i class="fa fa-pencil"></i></button>
                                        <button class="btn delete-customer btn-outline-danger" cname="{{$data['customer']->name}}" cid="{{$data['customer']->id}}"><i class="fa fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">             
                                <div class="pt-4">
                                    <span class="curr-status">--</span>
                                    <h5><b class="curr-deni"></b></h5>
                                </div>                   
                                <div align="right" style="margin-top: -60px;">
                                    <button class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#payDModal">
                                        <b><?php echo $_GET['cash-in']; ?></b>
                                    </button> <br>
                                    <button class="btn btn-outline-info btn-sm mt-2" data-toggle="modal" data-target="#borrowMModal">
                                        <b><?php echo $_GET['cash-out']; ?></b>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row filter-c-rec pl-1 pt-4">
                            <div class="col-md-3 c col-3" style="display:none">
                                <select class="form-control form-control-sm change-shop2" name="">
                                    <option value="{{$data['shop']->id}}">{{$data['shop']->name}}</option>
                                </select>
                            </div>
                            <div class="col-md-2 col-4 pl-0 d">
                                <input type="text" name="date_f" data-provide="datepicker" data-date-autoclose="true" class="form-control form-control-sm" placeholder="From" value="<?php echo $daysago; ?>">
                            </div>
                            <span style="padding-top: 5px;">to</span>
                            <div class="col-md-2 col-4 pr-0 d align-left">
                                <input type="text" name="date_t" data-provide="datepicker" data-date-autoclose="true" class="form-control form-control-sm" placeholder="From" value="<?php echo $today; ?>">
                            </div>
                            <div class="col-md-2 col-2 b">
                                <button class="btn btn-info btn-sm debt-rec-btn" cid="{{$data['customer']->id}}">Check</button>
                            </div>
                        </div> -->
                        <div class="row mt-4">
                            <!-- <div class="col-sm-12 col-12 mt-3 c-rec-body p-0" style="background:lime"> -->
                                <div class="table-responsive">
                                    <table class="table table-borderless m-b-0 c_list">
                                        <thead class="thead-light">
                                            <tr>
                                                <!-- <th>Tarehe</th> -->
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

    <!-- edit customer  -->
    <div class="modal fade" id="editCustomer" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="largeModalLabel">Edit customer</h4>
                </div>
                <div class="modal-body"> 
                    <form id="basic-form" class="edit-customer-form" customer="">
                        @csrf
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $_GET["name"]; ?></label>
                                    <input type="text" class="form-control" name="name" placeholder="Full Name" value="" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $_GET["gender"]; ?></label>
                                    <select class="form-control show-tick gender" name="gender" required>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $_GET["phone-number"]; ?></label>
                                    <input type="text" class="form-control" name="phone" placeholder="Phone" value="" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $_GET["address"]; ?></label>
                                    <input type="text" class="form-control" name="location" placeholder="Location" value="" required>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12 mt-2">
                                <button type="submit" class="btn btn-primary submit-edit-customer" style="width: inherit;">Submit</button>
                            </div>
                        </div>
                    </form>
                    <br>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-primary">SAVE CHANGES</button> -->
                    <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- mteja kaweka pesa -->
    <div class="modal fade" id="payDModal" tabindex="-1" role="dialog" aria-labelledby="payDModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4><?php echo $_GET['cash-in']; ?></h4>
                    <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9">
                        <button class="btn btn-danger btn-sm">x</button>
                    </span>
                </div>
                <div class="modal-body">
                    <p class="text-info">Mteja analipa deni au anaweka pesa dukani kwako atakuja kuitumia baadae</p>
                    <form class="lipa-hela-form">
                        <div class="col-md-6" style="margin-left: auto;margin-right: auto;">
                            <div class="form-group">
                                <label class="mb-0">Shop</label>
                                <select class="form-control form-control-sm shop-l-h" name="shop_l_h">
                                    <option value="{{$data['shop']->id}}">{{$data['shop']->name}}</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label class="mb-0">Amount</label>
                                <input type="number" class="form-control form-control-sm" name="lipa-amount" placeholder="0">
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
                    <h4><?php echo $_GET['cash-out']; ?></h4>
                    <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9">
                        <button class="btn btn-danger btn-sm">x</button>
                    </span>
                </div>
                <div class="modal-body">
                    <p class="text-info">Toa pesa dukani kwa lengo la kulipa deni au kurejesha pesa ya mteja au kumkopesha mteja</p>
                    <form class="basic-form kopesha-form"> 
                        <div class="col-md-6" style="margin-left: auto;margin-right: auto;">
                            <div class="form-group">
                                <label class="mb-0"><?php echo $_GET['shop']; ?></label>
                                <select class="form-control form-control-sm shop-k-h" name="shop_k_h">
                                    <option value="{{$data['shop']->id}}">{{$data['shop']->name}}</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label class="mb-0"><?php echo $_GET['purpose']; ?></label>
                                <select class="form-control purpose" name="purpose" style="width: 100%;">
                                    <option value="pay debt"> <?php echo $_GET['pay-debt']; ?> </option>
                                    <option value="refund"> <?php echo $_GET['refund']; ?> </option>
                                    <option value="lend money"> <?php echo $_GET['lend-money']; ?> </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="mb-0"><?php echo $_GET['amount']; ?></label>
                                <input type="number" class="form-control form-control-sm" name="kopesha_amount" placeholder="0">
                            </div>
                            <div class="form-inline riba-block" style="display: none;">
                                <label class="mb-0" style="width: 65%;display: inline;"><?php echo $_GET['interest']; ?></label>
                                <span style="width: 35%;float: right;">
                                    <input type="number" class="form-control form-control-sm" name="interest" value="18" style="width: 75%;"><b style="padding-left: 3px;">%</b>
                                </span>                                
                            </div>
                            <div class="form-group mt-4">
                                <button class="btn btn-success btn-sm kopesha-btn" style="width:100%">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">
    $('.select2').select2({
        dropdownParent: $('#payDModal')
    });
    $('.select3').select2({
        dropdownParent: $('#borrowMModal')
    });
 
    var shop_id = "<?php echo $shop_id; ?>";
    var customer_id = "<?php echo $customer_id; ?>";
    // var fdate = $('input[name="date_f"]').val();
    // var tdate = $('input[name="date_t"]').val();
    // fdate = fdate.split('/').join('-');
    // tdate = tdate.split('/').join('-');

    $(function () {
        // var shop_id = $('.change-shop2').val();
        $('.curr-deni').html('<i class="fa fa-spin fa-spinner"></i>');
        getDebtRecords(customer_id,shop_id);
    });

    function getDebtRecords(customer_id,shop_id) {
        var shopcustomer = shop_id+"~"+customer_id;
        $('.render-debt-rec').html('<tr><td colspan="3">Loading... </td></tr>');
        $.get('/get-data/debt-records/'+shopcustomer+'/all', function(data){ 
            if (Number(data.data.curr_deni) > 0) {
                $('.curr-deni').html(Number(data.data.curr_deni).toLocaleString('en')).css('color','red');
                $('.curr-status').html("Anadaiwa");
            } else if (Number(data.data.curr_deni) < 0) {
                $('.curr-deni').html(Number(Math.abs(data.data.curr_deni)).toLocaleString('en')).css('color','green');
                $('.curr-status').html("Anadai");
            } else {
                $('.curr-deni').html("0");
                $('.curr-status').html("Balance");
            }
            
            if($.isEmptyObject(data.sum)) {
                $('.render-debt-rec').html('<tr><td colspan="3" align="center"><i>-- <?php echo $_GET["empty-records"]; ?> --</i></td></tr>');
            } else {
                $('.render-debt-rec').html("");
                var curr_deni = data.data.curr_deni;
                var totalAP = totalAS = "";
                
                for (let i = 0; i < data.sum.length; i++) {
                    var alinunua = paidA = debtA = paidAL = lendM = lendM2 = payD = refund = "";
                    var thisd = data.sum[i]['ddate'].split('-');
                    var thisdate = thisd[2]+'/'+thisd[1]+'/'+thisd[0];

                    if (Number(data.sum[i]['stock_value']) != 0) {
                        alinunua = "<b> Alinunua bidhaa: "+Number(data.sum[i]['stock_value']).toLocaleString('en')+" <span class='view-bought-items' cid='"+data.customer['id']+"' cname='"+data.customer['name']+"' sdate='"+data.sum[i]['ddate']+"'><i class='fa fa-eye'></i></span></b><br>";
                        if (Number(data.sum[i]['amount_paid']) != 0) {
                            paidA = "<b> Alilipa: "+Number(data.sum[i]['amount_paid']).toLocaleString('en')+"</b><br>";
                        }
                        if (Number(data.sum[i]['debt_amount']) != 0) {
                            if (Number(data.sum[i]['debt_amount']) < 0) {
                                debtA = "<b> Anadai: "+Number(Math.abs(data.sum[i]['debt_amount'])).toLocaleString('en')+"</b><br>";
                            }
                            if (Number(data.sum[i]['debt_amount']) > 0) {
                                debtA = "<b> Anadaiwa: "+Number(data.sum[i]['debt_amount']).toLocaleString('en')+"</b><br>";
                            }
                        }
                        alinunua = '<div class="xl-turquoise p-1">'+alinunua+''+paidA+''+debtA+'</div>';
                    }
                    if (Number(data.sum[i]['amount_paid2']) != 0) {
                        paidAL = '<div class="xl-turquoise p-1 mt-1"><b> Aliweka pesa: '+Number(data.sum[i]['amount_paid2']).toLocaleString('en')+'</b> <span class="ml-1 px-2 py-1 edit edit-aliweka" sdate="'+data.sum[i]['ddate']+'" amount="'+Number(data.sum[i]['amount_paid2'])+'" customer="'+data.customer['id']+'"><i class="fa fa-edit"></i></span></div>';
                    }
                    var mkopo = Number(data.sum[i]['debt_amount2']);
                    if (Number(data.sum[i]['debt_amount2']) != 0) {
                        if (Number(data.sum[i]['interest']) != 0) {
                            var total_w_int = mkopo = Number(data.sum[i]['debt_amount2']) + Number(data.sum[i]['total_interest']);
                            lendM = '<div class="xl-turquoise p-1 mt-1"> Alikopa: <b>'+Number(data.sum[i]['debt_amount2']).toLocaleString('en')+'</b><br> Riba: <b>'+Number(data.sum[i]['interest'])+'% </b> <br> Total Deni: <b>'+Number(total_w_int).toLocaleString('en')+'</b></div>';
                        } else {
                            lendM = '<div class="xl-turquoise p-1 mt-1"><b> Alikopa: '+Number(data.sum[i]['debt_amount2']).toLocaleString('en')+'</b></div>';
                        }                        
                    }
                    if (Number(data.sum[i]['pay_debt']) != 0) {
                        payD = '<div class="xl-turquoise p-1 mt-1"><b> Alilipwa: '+Number(data.sum[i]['pay_debt']).toLocaleString('en')+'</b> <span class="ml-1 px-2 py-1 edit edit-alilipwa" sdate="'+data.sum[i]['ddate']+'" amount="'+Number(data.sum[i]['pay_debt'])+'" customer="'+data.customer['id']+'"><i class="fa fa-edit"></i></span></div>';
                    }
                    if (Number(data.sum[i]['refund']) != 0) {
                        refund = '<div class="xl-turquoise p-1 mt-1"><b> Alirudishiwa pesa: '+Number(data.sum[i]['refund']).toLocaleString('en')+'</b> <span class="ml-1 px-2 py-1 edit edit-alirudishiwa" sdate="'+data.sum[i]['ddate']+'" amount="'+Number(data.sum[i]['refund'])+'" customer="'+data.customer['id']+'"><i class="fa fa-edit"></i></span></div>';
                    }
                    var deni = '<b>0</b>';
                    if (Number(curr_deni) > 0) {
                        deni = '<b class="text-danger">'+Number(curr_deni).toLocaleString('en')+'</b>';
                    }
                    if (Number(curr_deni) < 0) {
                        deni = '<b class="text-success">'+Number(Math.abs(curr_deni)).toLocaleString('en')+'</b>';
                    }
                    
                    $('.render-debt-rec').append('<tr><td colspan="2" class="pb-0 mb-0">'+thisdate+'</td></tr><tr><td class="pt-0">'+alinunua+''+paidAL+''+lendM+''+payD+''+refund+'</td><td class="pt-0">'+deni+'</td></tr>');

                    curr_deni = Number(curr_deni) - Number(data.sum[i]['debt_amount']) + Number(data.sum[i]['amount_paid2']) - mkopo - Number(data.sum[i]['pay_debt']) - Number(data.sum[i]['refund']);
                }
            }          

            // if($.isEmptyObject(data.output)) {
            //     $('.render-debt-rec').html('<tr><td colspan="3" align="center"><i>-- <?php echo $_GET["empty-records"]; ?> --</i></td></tr>');
            // } else {
            //     $('.render-debt-rec').html(data.output);
            // }            
        });
    }
    
    $(document).on('change', '.purpose', function(e){
        e.preventDefault();
        var val = $(this).val();
        if(val == 'lend money') {
            $('.riba-block').css('display','block');
        } else {
            $('.riba-block').css('display','none');
        }
    });
    
</script>