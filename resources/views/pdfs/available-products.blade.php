

<!DOCTYPE html>
<html>
  <head>
    <style>
        .invoice{
            padding: 30px;
        }
        .invoice .text-left {text-align: left;}

        .invoice table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px
        }

        .invoice table th {
            padding: 15px;
            background: #01b2c6;color: #fff;
            white-space: nowrap;
            font-weight: bolder;
            font-size: 16px
        }
        .invoice table td {
            padding: 10px 15px;
            background: #eee;
            border-bottom: 1px solid #fff
        }
    </style>
  </head>

  <body>
    <div class="invoice">

        <div style="margin-bottom: 20px;">
            <h3 style="margin-bottom: 0px;">AVAILABLE PRODUCTS AT {{$shopname}}</h3>
        </div>
    
        <table>
            <thead>
                <tr>
                    <th class="text-left">NAME</th>
                    <th class="text-left">BUYING PRICE</th>
                    <th class="text-left">SELLING PRICE</th>
                    <th class="text-left">QUANTITY</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $p)
                <tr><td>{{$p->name}}</td><td>{{number_format($p->buying_price, 0)}}</td><td>{{number_format($p->selling_price, 0)}}</td><td>{{$p->quantity + 0}}</td></tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
  </body>
</html>