

@include("layouts.translater")

<?php
if(Cookie::get("language") == 'en') {
    $_GET['expense-name-desc'] = "<small>Example of daily expenses are: <b>Allowance, food, electricity</b> e.t.c</small>";
} else {
    $_GET['expense-name-desc'] = "<small>Mfano wa matumizi ya kila siku ni kama: <b>Posho, chakula, umeme,</b> n.k</small>";
}
?>
<style type="text/css">
    .tab_btn {background-color: #eee;padding: 10px;padding-bottom: 7px; border-radius: 50%;cursor: pointer;}
    .tab_btn i {font-size: 1.3rem;}
    .tab_btn:hover {background-color: #dee2e6;}
    .table-responsive .c_list {
        font-size: 14px;
    }
    .render-s-expenses .list {
        border-bottom: 1px solid #ddd;
        padding-top: .25rem;padding-bottom: .25rem;
    }
    .render-s-expenses .list .name {
        display: inline-block;width: 80% !important;
    }
    .render-s-expenses .list span {
        padding-top: 2px;padding-bottom: 2px;cursor: pointer;
    }
    .ex.date-range .col-3 {margin-top: 26px;}
    .ex-table table .desc-td {
        white-space: normal !important;
        word-wrap: break-word;
    }
    
    .reduce-padding {padding: 5px 25px;}
    @media screen and (max-width: 766px) {
        .reduce-padding {padding: 0px 15px;}
    }
    @media screen and (max-width: 480px) {
        .tab_btn {padding-top: 13px;}
        .reduce-padding {padding-left:8px;padding-right:8px;}
        .table-responsive .c_list {
            font-size: 12px;
        }
        .ex.date-range .col-3 {margin-top: 31px;}
    }
</style>

<?php 
if(Cookie::get("language") == 'en') { 
    $_GET['exp-descs'] = "Daily expenses in your shop i.e Electricity, Food, Allowance e.t.c";
    $_GET['register-expenses'] = "Register Expenses";
} else {
    $_GET['exp-descs'] = "Matumizi ya kila siku dukani kwako. Mfano: Umeme, chakula, posho n.k";
    $_GET['register-expenses'] = "Sajili Matumizi";
}
?>

    <input type="hidden" name="shopid" value="{{$data['shop']->id}}">

    <div class="row clearfix">
        <div class="col-md-4 reduce-padding">
            <div class="card">
                <div class="header py-2" style="background-color: #e9ecef;">
                    <h2><?php echo $_GET['register-expenses']; ?></h2>
                </div>
                <div class="body">
                    <div>
                        <?php echo $_GET['exp-descs']; ?>
                    </div>
                    <div class="">
                        <div class="accordion" id="accordion" style="margin-top: 40px;">
                            <div>
                                <div class="card-header" id="headingOne">
                                    <h6 class="mb-0">
                                        <button class="btn btn-link collapsed py-1" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                            <i class="fa fa-eye"></i>
                                            <span style="font-weight: bold;padding-top: 5px;padding-left: 10px;"> <?php echo $_GET['show']; ?> - <span class="total-ex">{{$data['expenses']->count()}}</span></span> 
                                            <i class="fa fa-angle-down" style="float: right;font-size: 1.3rem !important;margin-top: 3px;"></i>
                                        </button>
                                    </h6>
                                </div>                                
                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion" style="border: 2px solid #eee;">
                                    <div class="card-body" style="padding-bottom: 10px;padding-top: 10px;">                
                                        <div>
                                            <form id="basic-form" class="new-expense">
                                                @csrf
                                                <div class="row clearfix">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label><?php echo $_GET['add-expense-type']; ?></label>
                                                            <input type="text" class="form-control" placeholder="<?php echo $_GET['name']; ?>" name="name" required>
                                                            <div class="mt-2 mb-0" style="display: none;">
                                                                <?php echo $_GET['expense-name-desc']; ?>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                <div class="row clearfix">
                                                    <div class="col-sm-12">
                                                        <button type="submit" class="btn btn-primary submit-new-expense" style="width: inherit;"><?php echo $_GET['add']; ?></button>
                                                    </div>
                                                </div>
                                            </form>
                                            <br>
                                            <h6><b><?php echo $_GET['registered-expenses']; ?></b></h6> 
                                            <div class="render-s-expenses">
                                                @if($data['expenses']->isNotEmpty())
                                                    @foreach($data['expenses'] as $expense)
                                                        <div class="list">
                                                            <div class="name">{{$expense->name}}</div> 
                                                            <div style="float: right;">
                                                                <span class="bg-warning edit-expense px-1" eid="{{$expense->id}}" ename="{{$expense->name}}"><i class="fa fa-pencil"></i></span>
                                                                <span style="margin-left: .15rem;" class="bg-danger delete-expense text-white px-1" eid="{{$expense->id}}" ename="{{$expense->name}}"><i class="fa fa-times"></i></span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else 
                                                <div><small><i>-No Expenses Regirstered-</i></small></div>
                                                @endif
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>                 
                </div>
            </div>
            <div class="card">
                <div class="header py-2" style="background-color: #e9ecef;">
                    <h2><?php echo $_GET['record-expenses']; ?>:</h2>                    
                </div>
                <div class="body">
                    <form id="basic-form" class="expense-record">
                        @csrf
                        <input type="hidden" name="shop_id" value="{{$data['shop']->id}}">
                        <div class="row clearfix">
                            <div class="col-sm-12 col-12">
                                <div class="form-group <?php if($data['shop']->checkSaleBackDate()) { echo ''; $bdays = $data['shop']->checkSaleBackDate()->sale_days_back; } else { echo 'displaynone'; $bdays = 0; } ?>">                                    
                                    <input type="text" name="expense_date" data-provide="datepicker" data-date-autoclose="true" class="form-control expense-date" value="{{date('d/m/Y')}}">
                                </div>
                                <div class="form-group" style="width: 80%;">
                                    <label><?php echo $_GET['expense-name-f']; ?> *</label>
                                    <select class="form-control expense select2" name="expense_id" required>
                                        <option value="">- <?php echo $_GET['select']; ?> -</option>
                                        @if($data['expenses'])
                                            @foreach($data['expenses'] as $expense)
                                                <option value="{{$expense->id}}">{{$expense->name}}</option>
                                            @endforeach
                                        @else
                                            <option disabled><i>- no expense -</i></option>
                                        @endif
                                    </select>
                                </div>
                                <div style="float: right;margin-top: -43px;"><a class="tab_btn" title="Add new" data-toggle="modal" data-target="#addExpense">
                                    <i class="fa fa-plus text-success"></i>
                                </a></div>
                                <div class="form-group">
                                    <label><?php echo $_GET['amount']; ?> *</label>
                                    <input type="number" class="form-control form-control-sm" name="amount" required>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $_GET['description']; ?></label>
                                    <textarea name="description" class="form-control" placeholder=""></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <button class="btn btn-success expense-record-btn" style="width: inherit;">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8 reduce-padding">
            <div class="card">      
                <div class="header py-2" style="background-color: #e9ecef;">
                    <h2><?php echo $_GET['expenses-records']; ?>:</h2>
                </div>     
                <div class="body">
                    <form id="basic-form" class="form" style="display: none;">
                        <select class="form-control-sm col-md-1 col-3 this-y-2" style="padding:0px">
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        </select>
                        <select class="form-control-sm col-md-2 col-5 this-m-2">
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                        </select>
                        <select class="form-control-sm col-md-1 col-3 this-d-2">
                        
                        </select>
                    </form>
                    <div class="row clearfix ex date-range" style="background-color: #fff;">
                        <div class="col-sm-3 col-4 b">
                            <div class="form-group">
                                <label class="mb-0"><?php echo $_GET['from']; ?></label>
                                <input type="text" data-provide="datepicker" data-date-autoclose="true" class="form-control from-date form-control-sm" placeholder="From" value="<?php echo date('d/m/Y',strtotime('-5 days')); ?>">
                            </div>
                        </div>
                        <div class="col-sm-3 col-4 ml-2 b">
                            <div class="form-group">
                                <label class="mb-0"><?php echo $_GET['to']; ?></label>
                                <input type="text" data-provide="datepicker" data-date-autoclose="true" class="form-control to-date form-control-sm" placeholder="To" value="<?php echo date('d/m/Y'); ?>">
                            </div>
                        </div>
                        <div class="col-3">
                            <button type="button" class="btn btn-info btn-sm check-r-expenses">Check</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="pt-1 pb-3">
                                <span><?php echo $_GET['total-expenses']; ?>:</span><b class="bg-dark text-light total-expenses px-2 py-1 ml-2">-</b>
                            </div>
                        </div>
                        <div class="col-12 px-0">
                            <div class="table-responsive ex-table">
                                <table class="table m-b-0 c_list">
                                    <thead class="thead-light" style="display: none;">
                                        <tr>
                                            <th><?php echo $_GET['expense-name-f']; ?></th>
                                            <th><?php echo $_GET['amount']; ?></th>
                                            <th><?php echo $_GET['description']; ?></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody class="expenses-report">
        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>                            
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="addExpense" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <h4 class="title" id="largeModalLabel">Add expense</h4> -->
                    <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body"> 
                    <form id="basic-form" class="new-expense-2">
                        @csrf
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label><?php echo $_GET['add-expense-name']; ?></label>
                                    <input type="text" class="form-control" placeholder="<?php echo $_GET['name']; ?>" name="name" required>
                                    <div class="mt-2 mb-0">
                                        <?php echo $_GET['expense-name-desc']; ?>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary submit-new-expense" style="width: inherit;"><?php echo $_GET['add']; ?></button>
                            </div>
                        </div>
                    </form>
                    <br>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
                </div> -->
            </div>
        </div>
    </div>
    
    @include('modals.edit-expense-cost')

    
<script type="text/javascript">
    $('.select2').select2();
    var shop_id = $('[name="shop_id"]').val();

    var fromdate = $('.ex .from-date').val();
    fromdate = fromdate.split('/').join('-');
    var todate = $('.ex .to-date').val();
    todate = todate.split('/').join('-');

    $(function () {
        $('.today-summary, .week-summary, .month-summary').html('<i class="fa fa-spinner fa-spin" style="font-size:15px;"></i> Loading...');
        var d = new Date();
        var date = d.getDate();
        var month = d.getMonth()+1;
        var year = d.getFullYear();
        $('.this-d-2 option[value="'+date+'"]').prop('selected', true);
        $('.this-m-2 option[value="'+month+'"]').prop('selected', true);
        $('.this-y-2 option[value="'+year+'"]').prop('selected', true);
        // getDatesRange(date,month,year);
        getRecordedExpenses(shop_id,fromdate,todate);
    });

    function getDatesRange(thisdate,month,year) {
        var date = new Date();
        var firstDay = new Date(date.getFullYear(), month, 1);
        var lastDay = new Date(date.getFullYear(), month, 0);
        var firstDate = firstDay.getDate();
        var lastDate = lastDay.getDate();
        
        $('.this-d-2').html('');
        for (var i = 1; i <= lastDate; i++) {
            $('.this-d-2').append($('<option>', {value:i, text:i}));
            $('.this-d-2 option[value="'+thisdate+'"]').prop('selected', true);
        }
        expensesByDate(thisdate,month,year,shop_id);
    }

    function getSExpenses() {
        $('.render-s-expenses').html("<div class='mt-2'><i class='fa fa-spinner fa-spin fa-2x'></i></div>"); // get data
        $.get("/get-data/registered-expenses/shop", function(data){
            $('.total-ex').html(data.total);
            $('.render-s-expenses').html(data.expenses);        
        });
    }

    // limit no of days back to record sales 
    var ssdate = new Date();
    var bdays = "<?php echo $bdays; ?>";
    ssdate.setDate(ssdate.getDate()-bdays);
    $('.expense-date').datepicker({ 
        startDate: ssdate,
        endDate: '+0d'
    });

    $(document).on('change','.this-m-2',function(e){
        e.preventDefault();
        var month = $(this).val();
        var year = $(".this-y-2 option:selected").val();
        var date = $(".this-d-2 option:selected").val();
        getDatesRange(date,month,year);
    });
    $(document).on('change','.this-y-2',function(e){
        e.preventDefault();
        var year = $(this).val();
        var month = $(".this-m-2 option:selected").val();
        var date = $(".this-d-2 option:selected").val();
        getDatesRange(date,month,year);
    });
    $(document).on('change','.this-d-2',function(e){
        e.preventDefault();
        var date = $(this).val();
        var year = $(".this-y-2 option:selected").val();
        var month = $(".this-m-2 option:selected").val();
        getDatesRange(date,month,year);
    });
    
    $(document).on('click', '.check-r-expenses', function(e) {
        e.preventDefault();
        var fromdate = $('.ex .from-date').val();
        fromdate = fromdate.split('/').join('-');
        var todate = $('.ex .to-date').val();
        todate = todate.split('/').join('-');
        getRecordedExpenses(shop_id,fromdate,todate);
    });
    function getRecordedExpenses(shop_id,fromdate,todate) {
        $('.expenses-report').html("<tr><td colspan='4' align='center'><i class='fa fa-spinner fa-spin fa-2x'></i> Loading...</td></tr>");
        shopdate = shop_id+"~"+fromdate+"~"+todate;
        $.get('/get-data/recorded-expenses/'+shopdate, function(data){ 
            $('.total-expenses').html(data.data.total_ex);
            $('.expenses-report').html(data.expenses);
        });
    }

    function expensesByDate(date,month,year,shop_id){
        $('.expenses-report').html("<tr><td colspan='5'>Loading...</td></tr>");
          $.get('/expenses-in-shop/cashier/'+date+'/'+month+'/'+year+'/'+shop_id, function(data) {
            $('.expenses-report').html(data.view);
          });
    }
    
</script>