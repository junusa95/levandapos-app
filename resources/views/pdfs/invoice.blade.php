
<!-- <!DOCTYPE html>
<html>
  <head>
    <title>Hello world!</title>
  </head>
  <body style="fontFamily:'Arial, Helvetica, sans-serif';">

    <div style="width:760px;">
      <h2>About Us</h2>
      <p>We help software developers do more with PDFs. PDF.js Express gives a flexible and modern UI to your PDF.js viewer while also adding out-of-the-box features like annotations, form filling and signatures.</p>

        <div>
            <iframe id="pdf-js-viewer" src="/web/viewer.html?file=%2assets%2pdf%2Fmy-pdf-file.pdf" title="webviewer" frameborder="0" width="500" height="600"></iframe>
        </div>

    </div>

  </body>
</html> -->


<!DOCTYPE html>
<html>
  <head>
    
    <style>
        #invoice{
    padding: 30px;
}

.invoice {
    position: relative;
    background-color: #FFF;
    min-height: 680px;
    padding: 15px
}

.invoice header {
    padding: 10px 0;
    margin-bottom: 20px;
    border-bottom: 1px solid #3989c6
}

.logo-col img {
    width: 80px;height: 80px;object-fit: cover;
}

.invoice .company-details {
    text-align: right;float: right;
}

.invoice .company-details .name {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .contacts {
    margin-bottom: 20px
}

.invoice .invoice-to {
    text-align: left
}

.invoice .invoice-to .to {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .invoice-details {
    text-align: right;float: right;
}

.invoice .invoice-details .invoice-id {
    margin-top: 0;
    color: #3989c6
}

.invoice main {
    padding-bottom: 50px
}

.invoice main .thanks {
    /* margin-top: -100px; */
    font-size: 2em;
    margin-bottom: 50px
}

.invoice main .notices {
    padding-left: 6px;
    border-left: 6px solid #3989c6
}

.invoice main .notices .notice {
    font-size: 1.2em
}

.invoice table {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
    margin-bottom: 20px
}

.invoice table td,.invoice table th {
    padding: 15px;
    background: #eee;
    border-bottom: 1px solid #fff
}

.invoice table th {
    white-space: nowrap;
    font-weight: 400;
    font-size: 16px
}

.invoice table td h3 {
    margin: 0;
    font-weight: 400;
    color: #3989c6;
    font-size: 1.2em
}

.invoice table td.text-left {
    font-size: 1.2em
}

.invoice table .qty,.invoice table .total,.invoice table .unit {
    text-align: right;
    font-size: 1.2em
}

.invoice table .no {
    color: #fff;
    font-size: 1.6em;
    background: #3989c6
}

.invoice table .qty {
    background: #ddd
}

.invoice table .total {
    background: #3989c6;
    color: #fff
}

.invoice table tbody tr:last-child td {
    border: none
}

.invoice table tfoot td {
    background: 0 0;
    border-bottom: none;
    white-space: nowrap;
    text-align: right;
    padding: 10px 20px;
    font-size: 1.2em;
    border-top: 1px solid #aaa
}

.invoice table tfoot tr:first-child td {
    border-top: none
}

.invoice table tfoot tr:last-child td {
    /* color: #3989c6; */
    color: #000;
    font-size: 1.4em;
    /* border-top: 1px solid #3989c6 */
    border-bottom: 1px solid #000;
}

.invoice table tfoot tr td:first-child {
    border: none
}

.invoice footer {
    width: 100%;
    text-align: center;
    color: #777;
    border-top: 1px solid #aaa;
    padding: 8px 0
}

@media print {
    .invoice {
        font-size: 11px!important;
        overflow: hidden!important
    }

    .invoice footer {
        position: absolute;
        bottom: 10px;
        page-break-after: always
    }

    .invoice>div:last-child {
        page-break-before: always
    }
}
    </style>
  </head>

  <body>
    <div id="invoice">

        @if($data['sale'])
        <div class="invoice overflow-auto">
            <div style="min-width: 600px">
                <header>
                    <div class="row">
                        <div class="col logo-col" style="display: inline-block;">
                            <!-- <a href="#" style=""> -->
                                @if($data['company']->logo)
                                    <img src="images/companies/{{$data['company']->folder}}/company-profiles/{{$data['company']->logo}}">                              
                                @else
                                    <img src="#" style="visibility:hidden;">
                                @endif
                            <!-- </a> -->
                        </div>
                        <div class="col company-details" style="display: inline-block;">
                            <h2 class="name" style="color: #3989c6;">
                                {{$data['sale']->shop->name}}
                            </h2>
                            <div>
                                @if($data['sale']->shop->district)
                                    {{$data['sale']->shop->ward->name}}, {{$data['sale']->shop->district->name}}
                                @else 
                                    {{$data['sale']->shop->location}}
                                @endif
                            </div>
                            <div>+{{Auth::user()->phonecode.' '.Auth::user()->phone}}</div>
                            <!-- <div>company@example.com</div> -->
                        </div>
                    </div>
                </header>
                <main>
                    <div class="row contacts">
                        <div class="col invoice-to" style="display: inline-block;">
                            <div class="text-gray-light">INVOICE TO:</div>
                            @if($data['sale']->customer)
                            <h2 class="to">{{$data['sale']->customer->name}}</h2>
                            <div class="address">{{$data['sale']->customer->location}}</div>
                            <div class="phone">{{$data['sale']->customer->phone}}</div>
                            @else 
                            <h3>CUSTOMER</h3>
                            @endif 
                        </div>
                        <div class="col invoice-details" style="display: inline-block;">
                            <h2 class="invoice-id">INVNO-{{$data['sale']->sale_val}}</h2>
                            <div class="date">Date of Invoice: <?php echo date('d/m/Y'); ?></div>
                            <!-- <div class="date">Due Date: 30/10/2018</div> -->
                        </div>
                    </div>
                    <table border="0" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th class="text-left" style="text-align: left;">ITEM</th>
                                <th class="text-right">QTY</th>
                                <th class="text-right">PRICE</th>
                                <th class="text-right">TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($data['sales']->isNotEmpty())
                            @foreach($data['sales'] as $sale)
                            <?php
                            $quantity = $sale->quantity + 0;
                            ?>
                            <tr>
                                <td class="text-left">
                                    {{$sale->product->name}}                                    
                                </td>
                                <td class="qty">{{$quantity}}</td>
                                <td class="unit">{{number_format($sale->selling_price)}}</td>
                                <td class="total">{{number_format($sale->sub_total)}}</td>
                            </tr>
                            @endforeach
                            @endif
                            <!-- <tr>
                                <td class="text-left"><h3>Website Design</h3>Creating a recognizable design solution based on the company's existing visual identity</td>
                                <td class="unit">$40.00</td>
                                <td class="qty">30</td>
                                <td class="total">$1,200.00</td>
                            </tr> -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="1"></td>
                                <td colspan="2">TOTAL</td>
                                <td>{{number_format($data['sump'])}}</td>
                            </tr>
                            <!-- <tr>
                                <td colspan="1"></td>
                                <td colspan="2">TAX 25%</td>
                                <td>$1,300.00</td>
                            </tr>
                            <tr>
                                <td colspan="1"></td>
                                <td colspan="2">GRAND TOTAL</td>
                                <td>$6,500.00</td>
                            </tr> -->
                        </tfoot>
                    </table>
                    <!-- <div class="thanks">Thank you!</div> -->
                    <!-- <div class="notices">
                        <div style="visibility: hidden;">NOTICE:</div>
                        <div class="notice">THANK YOU for choosing us!</div>
                    </div> -->
                </main>
                <footer>
                    THANK YOU for choosing us!
                </footer>
            </div>
            <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
            <div></div>
        </div>
        @endif
    </div>
  </body>
</html>