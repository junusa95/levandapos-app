


@if($data['agents'])
    <?php $num = 1; ?>
    @foreach($data['agents'] as $agent)
    <?php 
        $cdate = new DateTime($agent->created_at);
        $phone = $agent->phonecode.''.str_replace(' ', '', $agent->phone);
    ?>

    <tr>
        <td>{{$num}}</td>
        <td><a href="/admin/agents/{{$agent->id}}">{{$agent->name}}</a> <br> <small>({{$phone}})</small> </td>
        <td>{{$agent->address}}</td>
        <td class="agent-acc-<?php echo $agent->id; ?>"><i class='fa fa-spinner fa-spin' style='font-size:15px;'></i></td>
        <td class="agent-sh-st-<?php echo $agent->id; ?>"><i class='fa fa-spinner fa-spin' style='font-size:15px;'></i></td>
        <td>{{$cdate->format('d/m/Y')}}</td>
    </tr>
    <?php $num++; ?>
    @endforeach
@endif



<script type="text/javascript">

    $(function () {        
        "<?php foreach($data['agents'] as $agent) { ?>"
            $.get('/agent/agent-accounts-count/<?php echo $agent->id; ?>', function(data) {   
                $('.agent-acc-'+data.aid).html('<small>All: </small>'+data.data.total_accounts+'<br> <small>Active: </small>'+data.data.total_active);
            }); 
            
            $.get('/agent/agent-accounts-sh-st/<?php echo $agent->id; ?>', function(data) {   
                $('.agent-sh-st-'+data.aid).html('<small>Shops: </small>'+data.data.total_shops+'<br> <small>Stores: </small>'+data.data.total_stores);
            }); 
        "<?php } ?>"
    });

</script>