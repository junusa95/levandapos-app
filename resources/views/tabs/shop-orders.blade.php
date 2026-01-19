

@include("layouts.translater") 

<?php  
    // check if is cashier or shop seller 
    $isCashier = \DB::table('user_shops')->where('user_id',Auth::user()->id)->where('shop_id',$data['shop']->id)->where('who','cashier')->first();
 ?>
<style>
    .date-range {padding-left: 20px !important;background-color: transparent !important;}
    .p-s-order .card .header, .s-s-order .card .header {padding-left: 0px;padding-bottom: 10px !important;}
/*    .totaloP {font-size: 20px !important}*/
    @media screen and (max-width: 767px) {
        .s-s-order .card {
            margin-top: -30px !important;
        }
    }
    @media screen and (max-width: 480px) {
        .date-range button {margin-top: 30px !important;}
    }
</style>
<input type="hidden" name="shopid" value="{{$data['shop']->id}}">

    <div class="row clearfix">
        <div class="col-md-6 p-s-order">
            <div class="card" style="box-shadow: none;">      
                <div class="header">
                    <h6><?php echo $_GET['saved-orders']; ?>:</h6>
                </div>     
                <div class="body pt-0 px-0">
                    <div class="table-responsive" style="background-color: #f9f6f2;">
                        <table class="table m-b-0">
                            <thead style="background-color: #f0f0f0;">
                                <tr>
                                    <th><?php echo $_GET['order']; ?> #</th>
                                    <th><?php echo $_GET['quantity']; ?></th>
                                    <th><?php echo $_GET['amount']; ?></th>
                                </tr>
                            </thead>
                            <tbody class="render-oitems">

                            </tbody>
                        </table>
                    </div>
                </div>  
            </div>
        </div>

        <div class="col-md-6 s-s-order">
            <div class="card" style="box-shadow: none;">      
                <div class="header">
                    <h6><?php echo $_GET['sold-orders']; ?>:</h6>
                </div>     
                <div class="body pt-0 px-0" style="background-color: #f9f6f2;">
                    <div class="row clearfix date-range">
                        <div class="col-sm-3 col-4 b">
                            <div class="form-group">
                                <label><?php echo $_GET['from']; ?></label>
                                <input type="text" data-provide="datepicker" data-date-autoclose="true" class="form-control from-date form-control-sm" placeholder="From" value="<?php echo date('d/m/Y'); ?>">
                            </div>
                        </div>
                        <div class="col-sm-3 col-4 ml-2 b">
                            <div class="form-group">
                                <label><?php echo $_GET['to']; ?></label>
                                <input type="text" data-provide="datepicker" data-date-autoclose="true" class="form-control to-date form-control-sm" placeholder="To" value="<?php echo date('d/m/Y'); ?>">
                            </div>
                        </div>
                        <div class="col-3">
                            <button type="button" class="btn btn-info btn-sm check-o-sales">Check</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table m-b-0">
                            <thead style="background-color: #f0f0f0;">
                                <tr>
                                    <th><?php echo $_GET['order']; ?> #</th>
                                    <th><?php echo $_GET['quantity']; ?></th>
                                    <th><?php echo $_GET['amount']; ?></th>
                                </tr>
                            </thead>
                            <tbody class="render-soitems">

                            </tbody>
                        </table>
                    </div>
                </div>  
            </div>
        </div>
    </div>

    <!-- order modal -->
    <div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="min-height:90vh;">
                <div class="col-12 mt-3">
                    <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9;">
                        <button class="btn btn-danger btn-sm">x</button>
                    </span>
                    <div class="mt-4">
                        <h5 style="margin-bottom:0px;margin-left: 0px;">Order #: <span class="orderno" style="margin-left:7px"></span></h5>
                        <div>Created by: <b class="ordered_by" style="margin-left:10px"></b></div>
                        <div class="customer-order">Customer name: <b class="customer-order-name"></b></div>
                    </div>
                </div>
                <div class="modal-body p-0 pb-4 pt-3">
                    <div class="col-sm-12 col-12" style="height: 65vh;padding-bottom: 5vh; overflow-y: scroll;">
                        <!-- <div class="custom-o-nu-block">
                            <span>Custom order #</span>
                            <input type="text" class="form-control form-control-sm set-cutom-no" name="conu" placeholder="0" value="">
                        </div> -->
                        <div class="table-responsive">
                            <table class="table table-borderless m-b-0 c_list">
                                <thead class="thead-light th-n-sold">
                                    <tr>
                                        <th>ITEMS LIST</th>
                                    </tr>
                                </thead>
                                <thead class="thead-light th-sold">
                                    <tr>
                                        <th>ITEM</th><th><div  align="center">Qty</div> </th><th><div align="right">TOTAL</div></th>
                                    </tr>
                                </thead>
                                <tbody class="order-list sold-products2">
                                    
                                </tbody>
                                <tbody class="total-row" style="display: none;">
                                    <tr>
                                        <td>
                                            <div class="row jumla-b" style="margin:0px;">
                                                <!-- <div class="jumla-o"><?php echo $_GET['total']; ?></div> -->
                                                <div class="jumla-n">
                                                    <div>
                                                        <span style="padding-right: 3px;font-weight: 100;">
                                                            <?php echo $_GET['quantity-full']; ?> 
                                                        </span>:<span class="pl-1 totaloQ"></span>
                                                    </div>
                                                    <div>
                                                        <span  style="padding-right: 8px;font-weight: 100;"><?php echo $_GET['amount']; ?></span>:<span class="pl-1 totaloP"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div style="width: 100%;" class="pr-1 pt-1 t-o-block" align="right">
                                <table>
                                    <thead>                                    
                                        <tr><td class="pr-1">Total Amount:</td><th class="totaloP"></th></tr>
                                        <tr class="pa-tr"><td class="pr-1">Paid Amount:</td><th class="totalSPA"></th></tr>
                                        <tr class="ch-tr"><td class="pr-1">Change:</td><th class="totalCH"></th></tr>
                                    </thead>
                                </table>
                            </div>

                            @if($isCashier)
                            <!-- <div class="scustomer2 mb-4" align="center">
                                <br>
                                <h5>Paid amount </h5>
                                <input type="number" name="paidamount2" class="form-control paidamount2 px-0" style="margin-left: auto;margin-right: auto;text-align: center;font-size: 2rem;">
                            </div> -->
                            @endif
                        </div>
                    </div>           
                    <div class="col-12 paid-change-blk" align="center">
                        <h5 style="display:none;"><span style="font-size:13px;padding-right:10px">Total:</span><span class="o-amounttopay"></span></h5>
                        <div class="form-group" align="left" style="display: inline-block;">
                            <small><?php echo $_GET['paid-amount']; ?></small>
                            <input type="number" name="" class="form-control o-paidamount" value="0" style="font-size: 18px;width: 120px;">
                        </div>
                        <div class="spacer mx-2" style="display: inline-block;"></div>
                        <div class="change-blc" align="left" style="display: none">
                            <label>Change</label>
                            <h5 class="o-change">0</h5>
                        </div>
                    </div>
                    <div class="col-12 align-center order-footer">
                        @if($isCashier)
                            <!-- <button class="btn btn-info btn-sm pay-order-btn ml-3">Pay <i class="fa fa-dollar"></i></button> -->
                            <button type="button" class="btn btn-success submit-saleo"><?php echo $_GET['sell']; ?> <i class="fa fa-shopping-cart pl-1"></i></button>
                            <a href="#" class="btn btn-primary ml-2 invoice-a" target="_blank">Invoice <i class="fa fa-print pl-1"></i></a>
                            <!-- <button type="button" class="btn btn-success btn-sm submit-saleo-print">Sell and print <i class="fa fa-shopping-cart"></i></button> -->
                        @endif
                        <span class="hidden-btn" style="display:none">
                            <!-- <a href="" class="btn btn-info btn-sm edit-sorder">Update changes <i class="fa fa-check"></i></a> -->
                            <!-- <button class="btn btn-primary ml-2 download-invoice">Invoice <i class="fa fa-print pl-1"></i></button> -->
                            <!-- <button class="btn btn-info ml-2 pr-android" onClick="printOrder2();"><?php echo $_GET['print-order']; ?> <i class="fa fa-print pl-1"></i></button> -->
                            <!-- <button class="btn btn-primary ml-2 pr-others" onClick="printOrder();"><?php echo $_GET['print-order']; ?> <i class="fa fa-print pl-1"></i></button> -->
                            <button type="button" class="btn btn-danger delete-sorder"><?php echo $_GET['delete-order']; ?> <i class="fa fa-times pl-1"></i></button>
                        </span>
                    </div>
                    <!-- print btn for sold orders -->
                    <div class="col-12 align-center order-sold-footer" style="display:none">
                        <button class="btn btn-secondary close-modal"><i class="fa fa-arrow-left pr-2"></i> <?php echo $_GET['back-to-orders']; ?></button>
                        <!-- <button class="btn btn-info ml-2" onClick="printOrder2();"><?php echo $_GET['print']; ?> 2 <i class="fa fa-print"></i></button> -->
                        <button class="btn btn-info ml-2 pr-android" onClick="printOrder2();"><?php echo $_GET['print-order']; ?> <i class="fa fa-print pl-1"></i></button>
                        <button class="btn btn-info ml-2 pr-others" onClick="printOrder();"><?php echo $_GET['print']; ?> <i class="fa fa-print pl-1"></i></button>
                    </div>

                    <!-- printed area -->
                    <div class="col-sm-12 col-12" style="display: none;">
                        <div id="printed-order">
                            <div class="printed-order">
                                <div class="head" style="font-size: 12px;">
                                    <p style="text-align: center;background-color: #000;">
                                        <b>{{$data['shop']->name}}</b> <br>
                                        {{$data['shop']->location}} <br> 
                                        @if($data['shop']->company->tin)
                                        TIN: {{$data['shop']->company->tin}} <br>
                                        @endif 
                                        @if($data['shop']->company->vrn)
                                        VRN: {{$data['shop']->company->vrn}} <br>
                                        @endif 
                                        <?php echo '+'.Auth::user()->phonecode.' '.Auth::user()->phone; ?>
                                    </p>
                                </div> 
                                <div style="text-align:left;font-size: 10px;">
                                    <div>ORDER #: <span class="orderno"></span></div>
                                    <div>CASHIER: <span class="">{{Auth::user()->name}}</span></div>
                                    <div class="customer-order">CUSTOMER: <span class="customer-order-name"></span></div>
                                    <!-- <div class="show-custom-no" style="margin-top: 20px;display: none;"><span style="font-size:2rem;font-weight:bolder;margin-bottom: 0px;padding-bottom: 0px;">A42</span></div> -->
                                </div>
                                <div style="margin-top: 10px;text-align:left;font-size: 10px;border-bottom: 1px solid #000;">
                                    ITEMS
                                </div>
                                <div class="">
                                    <table style="width: 100%;">
                                        <thead class="render-orders-to-print" style="color: #000;font-size: 10px;">
                                            
                                        </thead>
                                    </table>
                                    <table style="width: 100%;border-bottom: 1px solid #000;border-top: 1px solid #000;font-size: 10px;" align="right">
                                        <tbody>
                                            <tr>
                                                <th style="text-align: right;">TOTAL AMOUNT</th><th>:</th><th class="totaloP" align="left"></th>
                                            </tr>
                                            <tr class="pa-tr"><th style="text-align: right;">PAID AMOUNT</th><th>:</th><th class="totalSPA" align="left"></th></tr>
                                            <tr class="ch-tr"><th style="text-align: right;">CHANGE</th><th>:</th><th class="totalCH" align="left"></th></tr>
                                        </tbody>
                                    </table>
                                    <div class="p-thanks" style="margin-top: 30px;text-align: center;font-size: 10px;">
                                        Thank you!
                                    </div>
                                    <div style="text-align: center;font-size: 10px;"><?php echo date('d M, Y, g:i a'); ?></div>
                                </div>
                            </div>
                        </div>                        
                    </div>
                            

                    <!-- printable block -->
                    <div class="col-12 py-5" style="display: none;">
                        <div id="printable_div_id_2" style="font-size: 3rem;font-weight: bolder;color: #000 !important; font-family: Arial;">
                            
                            <p class="centered" style="font-size: 2.6rem;color: #000;" align="center">
                                <!-- <img src="https://pos.levanda.co.tz/images/pos_logo3.png" width="100" alt="Logo"> <br> -->
                                <span style="font-size: 3rem;">{{$data['shop']->name}}</span>
                                <br>{{$data['shop']->location}}
                                @if($data['shop']->company->tin)
                                <br>TIN: {{$data['shop']->company->tin}} 
                                @endif 
                                @if($data['shop']->company->vrn)
                                <br>VRN: {{$data['shop']->company->vrn}} 
                                @endif 
                                <br><?php echo '+'.Auth::user()->phonecode.' '.Auth::user()->phone; ?></p>
                            <table>
                                <thead style="color: #000;font-size: 2.6rem;">
                                    <tr><th>ORDER #</th><th>:</th><th class="orderno"></th></tr>
                                    <tr><th>CASHIER</th><th>:</th><th>{{Auth::user()->name}}</th></tr>
                                    <tr class="customer-order"><th>CUSTOMER</th><th>:</th><th class="customer-order-name"></th></tr>
                                </thead>
                            </table>
                            <table style="width: 100%;font-size: 2.6rem;margin-top: 30px;">
                                <thead>
                                    <tr style="border-bottom: 1px solid #000;">
                                        <th>ITEM</th><th><div style="text-align: center;">Qty</div></th><th><div align="right">TOTAL</div></th>
                                    </tr>
                                </thead>
                                <thead class="render-orders-to-print" style="color: #000;border-bottom: 1px solid #000;font-size: 2.6rem;">
                                    
                                </thead>
                            </table>
                            <div style="width: 100%;margin-top: 15px;margin-bottom: 15px;" align="right">
                                <table>
                                    <thead style="color: #000;font-size: 2.6rem;">
                                        <tr><th style="text-align: right;">TOTAL AMOUNT</th><th style="padding-left: 10px;padding-right: 10px;">:</th><th class="totaloP"></th></tr>
                                        <tr class="pa-tr"><th style="text-align: right;">PAID AMOUNT</th><th style="padding-left: 10px;">:</th><th class="totalSPA"></th></tr>
                                        <tr class="ch-tr"><th style="text-align: right;">CHANGE</th><th style="padding-left: 10px;">:</th><th class="totalCH"></th></tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="p-thanks" style="width: 100%;font-size: 2.3rem;border-top: 1px solid #000;" align="center">Thanks for your purchase!</div>
                            <div style="width: 100%;font-size: 2.3rem;" align="center"><?php echo date('d M, Y, g:i a'); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
    $('.select2').select2();
    $('.sell-t').css('background','');$('.order-t').css('background','#dcf5ef');

    var fromdate = $('.from-date').val();
    fromdate = fromdate.split('/').join('-');
    var todate = $('.to-date').val();
    todate = todate.split('/').join('-');

    var shop_id = $('[name="shopid"]').val();
    
    $(function () {
        $('.returned-items,.render-oitems').html("<tr><td colspan='3' align='center'>Loading...</td></tr>");
        
        if(getOS() == "Android") {
            $('.pr-android').css('display','');
            $('.pr-others').css('display','none');
        } else {
            $('.pr-android').css('display','none');
            $('.pr-others').css('display','');
        }

        $.get('/pendingorders/shop/'+shop_id, function(data){ 
            $('.render-oitems').html(data.items);
            soldorders(shop_id,fromdate,todate);
        });
        
    });

    function pendingOrders(shop_id) { // call this if you want only pending orders.. 
        $('.render-oitems').html("<tr><td colspan='3' align='center'>Loading...</td></tr>");
        $.get('/pendingorders/shop/'+shop_id, function(data){ 
            $('.render-oitems').html(data.items);
        });
    }

    function soldorders(shop_id,fromdate,todate) {
        $('.render-soitems').html("<tr><td colspan='3' align='center'>Loading...</td></tr>");
        shopdate = shop_id+"~"+fromdate+"~"+todate;
        $.get('/soldorders/shop/'+shopdate, function(data){ 
            $('.render-soitems').html(data.items);
        });
    }
    
    $(document).on('click', '.download-invoice', function(e) {
        e.preventDefault();
        var element = document.getElementById('invoice_div_id_2');
        var fname = "sss";
        var opt = {
        margin:       1,
        filename:     fname+'.pdf',
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2 },
        jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
        };
        html2pdf().set(opt).from(element).save();
        // html2pdf(element);  
    });

    $(document).on('click', '.pay-order-btn', function(e) {
        e.preventDefault();
        if($(this).hasClass('show')) {
            $(this).removeClass('show');
            $('.order-pay-block').css('display','none');
        } else {
            $(this).addClass('show');
            $('.order-pay-block').css('display','block');
        }        
    });

    $(document).on('click', '.check-o-sales', function(e) {
        e.preventDefault();
        var fromdate = $('.from-date').val();
        fromdate = fromdate.split('/').join('-');
        var todate = $('.to-date').val();
        todate = todate.split('/').join('-');
        soldorders(shop_id,fromdate,todate);
    });

    $(document).on('click', '.print-order-btn', function(e) { // this in not used anymore
        e.preventDefault();     
        var ono = $(this).attr('order');
        var custom_ono = $('.set-cutom-no').val();        
        ono = ono+"~"+custom_ono;
        $.get('/order-items/list-printable/'+ono, function(data){     
            if (custom_ono) {
                $('.show-custom-no').css('display','block'); $('.show-custom-no span').html(custom_ono);
            }         
            $('.render-order-to-print').html(data.items);
            $('.totaloQ').html(parseFloat(data.data.totaloQ));
            $('.totaloP, .o-amounttopay').html(data.subtotal);
            $('.ordered_by').html(data.data.creator);
            $('.totaloPA').html(Number($('.o-paidamount').val()).toLocaleString("en"));
            $('.totaloCA').html($('.o-change').text().toLocaleString("en"));

            var divContents = document.getElementById("printed-order").innerHTML;
            var a = window.open('', 'height=500, width=500');
        a.document.open();
            a.document.write('<html>');
            a.document.write('<body onload="window.print()">');
            a.document.write(divContents);
            a.document.write('</body></html>');
            a.document.close();
            // a.print();
            // a.close();
        setTimeout(function() {
            a.close();
        }, 10);

            $.get('/pendingorders/shop/'+shop_id, function(data){ 
                $('.render-oitems').html(data.items);
            });
        });
    });

    function detectOS() {
        const userAgent = navigator.platform.toLowerCase();

        if (userAgent.includes('android')) {
            return 'Android';
        } else if (userAgent.includes('win')) {
            return 'Windows';
        } else if (userAgent.includes('mac')) {
            return 'Mac';
        } else if (userAgent.includes('linux')) {
            return 'Linux';
        }
      
        return 'Unknown OS';
    }
    function getOS() {
        var uA = navigator.userAgent || navigator.vendor || window.opera;
        
        if ( /Android/i.test(navigator.userAgent) ) { 
            return 'Android'; 
        } else { 
            return 'Other OS'; 
        }
        // if (window.matchMedia("(max-width: 768px)").matches) {
        //     if ( /Android/i.test(navigator.userAgent) ) { 
        //         return 'Android'; 
        //     } else { 
        //         return 'Other OS'; 
        //     }
        // } else {
        //     return 'Other OS';
        // }        
    }
    
    function printOrder() { 

        $('#printable_div_id_2').print(); 

        // below is working in computer and ios 
            // var $printerDiv = $('<div class="printContainer"></div>'); // create the div that will contain the stuff to be printed
            // var new_str = document.getElementById('printable_div_id_2').innerHTML;
            // $printerDiv.html(new_str); // add the content to be printed
            // $('body').append($printerDiv).addClass("printingContent"); // add the div to body, and make the body aware of printing (we apply a set of css styles to the body to hide its contents)

            // window.print(); // call print
            // $printerDiv.remove(); // remove the div
            // $('body').removeClass("printingContent");
    }
    
    function printOrder2() {      
        
        // working for mobile android
            var divContents = document.getElementById("printed-order").innerHTML;
            // var a = window.open('', '', 'height=500, width=500');
            var a = window.open('', '', 'Print-Window');
            a.document.write('<html>');
            a.document.write('<body class="p-58mm">');
            a.document.write(divContents);
            a.document.write('</body></html>');
            a.document.close();
            a.print();

        // var divToPrint = document.getElementById('printable_div_id_2');
        // var newWin = window.open('', 'Print-Window');
        // newWin.document.open();
        // newWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');
        // newWin.document.close();
        // setTimeout(function() {
        //     newWin.close();
        // }, 10);
    }
    
    $(document).on('click', '.remove-sor', function(e){
        e.preventDefault();
        var id = $(this).attr('val');
        $.get('/remove-sale-row/order/'+shop_id+'/'+id, function(data){
            if (data.error) {
                popNotification('warning',data.error);
            }
            if (data.success) {
                $('.sor-'+data.id).closest("tr").remove();
                $('.totaloQ').html(parseFloat(data.data.totaloQ));
                $('.totaloP, .o-amounttopay').html(data.subtotal); $('.o-paidamount').val(data.subtotal.replace(/,/g, ''));
                $('.o-change').html(0);
                $('.paidamount2').val(data.data.totaloP);
            }            
        });
    });

    $(document).on('keyup', '.o-paidamount', function(e){
        e.preventDefault();
        var paid = $(this).val();
        $('.o-change').html(Number(Number(paid) - Number($('.t-o-block .totaloP').text().replace(/,/g, ''))).toLocaleString("en"));
    });

</script>