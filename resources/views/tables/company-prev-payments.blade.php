


        @if($data['payments']->isEmpty())
        <tr>
            <td colspan="3" align="center">No payments recorded</td>
        </tr>
        @else 
            @foreach($data['payments'] as $payment)
            <tr>
                <td>{{number_format($payment->paid_amount)}}</td>
                <td>
                    @if($payment->paymentsdesc)
                    @foreach($payment->paymentsdesc as $pdes)
                    <?php $edate = new DateTime($pdes->expire_date); $idate = new DateTime($pdes->paid_date); ?>
                    @if($pdes->paid_for == "shop")
                        <span>{{$pdes->shop->name}} :</span> <b>{{number_format($pdes->paid_amount)}}</b> <small style="font-weight: bold;">({{$idate->format("d/m/Y")}} - {{$edate->format("d/m/Y")}})</small> <br>
                    @endif
                    @if($pdes->paid_for == "store")
                        <span>{{$pdes->store->name}} :</span> <b>{{number_format($pdes->paid_amount)}}</b> <small style="font-weight: bold;">({{$idate->format("d/m/Y")}} - {{$edate->format("d/m/Y")}})</small> <br>
                    @endif
                    @endforeach
                    @endif
                </td>
                <td>
                    <?php $cdate = new DateTime($payment->created_at); ?>
                    {{$cdate->format("d/m/Y")}}
                </td>
            </tr>
            @endforeach
        @endif