

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

        <div>
            <h3 style="margin-bottom: 0px;">SALES REPORT AT {{$data['shopname']}}</h3>
        </div>
        <div><h4>Month: {{$data['thismonth']}}</h4></div>
    
        <table>
            <thead>
                <tr>
                    <th class="text-left">DATE</th>
                    <th class="text-left">QNTY</th>
                    <th class="text-left">SALES</th>
                    <!-- <th class="text-left">BUYING C</th> -->
                    <th class="text-left">PROFIT</th>
                    <th class="text-left">EXPENSES</th>
                </tr>
            </thead>
            <tbody>
                <?php for($i = 0; $i < count($sales); $i++) { ?>
                    <tr><?php echo $sales[$i]; ?></tr> 
                <?php } ?>
            </tbody>
        </table>
    </div>
    
  </body>
</html>