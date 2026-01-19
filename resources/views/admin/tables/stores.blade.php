


@if($data['stores'])
    <?php $num = 1; ?>
    @foreach($data['stores'] as $store)
    <?php 
        $cdate = new DateTime($store->created_at);
    ?>

    <tr>
        <td>{{$num}}</td>
        <td>{{$store->name}} <br> <small>({{$store->location}})</small></td>
        <td class="last-activity-2-<?php echo $store->id; ?>">--</td>
        <td>{{$cdate->format('d/m/Y')}}</td>
        <td class="payment-status-2-<?php echo $store->id; ?>" align="center">--</td>
    </tr>
    <?php $num++; ?>
    @endforeach
@endif



<script type="text/javascript">

    $(function () {        
        "<?php foreach($data['stores'] as $store) { ?>"
            $.get('/get-data/store-last-activity/<?php echo $store->id; ?>', function(data) { 
                $('.last-activity-2-'+data.id).html(data.last_activity);
                $('.payment-status-2-'+data.id).html(data.payment_status);
            }); 
        "<?php } ?>"
    });

</script>