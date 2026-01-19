


@if($data['shops'])
    <?php $num = 1; ?>
    @foreach($data['shops'] as $shop)
    <?php 
        $cdate = new DateTime($shop->created_at);
    ?>

    <tr>
        <td>{{$num}}</td>
        <td>{{$shop->name}} <br> <small>({{$shop->location}})</small> </td>
        <td class="last-activity-<?php echo $shop->id; ?>">--</td>
        <td>{{$cdate->format('d/m/Y')}}</td>
        <td class="payment-status-<?php echo $shop->id; ?>" align="center">--</td>
    </tr>
    <?php $num++; ?>
    @endforeach
@endif



<script type="text/javascript">

    $(function () {        
        "<?php foreach($data['shops'] as $shop) { ?>"
            $.get('/get-data/shop-last-activity/<?php echo $shop->id; ?>', function(data) {   
                $('.last-activity-'+data.id).html(data.last_activity);
                $('.payment-status-'+data.id).html(data.payment_status);
            }); 
        "<?php } ?>"
    });

</script>