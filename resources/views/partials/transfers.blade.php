


@if($data['check'] == 'pending')
    @if($data['items']->isNotEmpty()) <!-- pending to my location -->
        @foreach($data['items'] as $item)
        <?php 
            // find where is this transfer from
            $from = '';
            $status = '';
            $badge = '';
            if ($item->from == 'store') {
                $from = $item->fstore->name;
            }
            if ($item->from == 'shop') {
                $from = $item->fshop->name;
            }
            if ($item->status == 'sent') {
                $badge = 'info';
                $status = 'Pending';
            }
        ?>
            <tr>
                <td>
                    <b><a href="#" class="transfer-items" transfer="{{$item->transfer_no}}">{{$item->transfer_no}}</a></b>
                </td>
                <td>{{sprintf('%g',$item->sumQ)}}</td>
                <td><b>From: </b>{{$from}}</td>
                <td><span class="badge badge-<?php echo $badge; ?>">{{$status}}</span></td>
                <td class="table-details"><b>Sender: </b> @if($item->sender){{$item->sender->name}}@endif <br><b>Sent at: </b> {{date("d/m/Y h:i A",strtotime($item->sent_at))}} <br><b>Shipper: </b>@if($item->shipper){{$item->shipper->name}}@endif</td>
                
            </tr>
        @endforeach
    @else
        @if($data['items2']->isEmpty())
            <tr>
                <td>- No transfers -</td>
            </tr>
        @endif
    @endif
    @if($data['items2']->isNotEmpty()) <!-- pending from my location to others -->
        @foreach($data['items2'] as $item)
        <?php 
            // find where is this transfer to
            $destination = '';
            $status = '';
            $badge = '';
            if ($item->destination == 'store') {
                $destination = $item->dstore->name;
            }
            if ($item->destination == 'shop') {
                $destination = $item->dshop->name;
            }
            if ($item->status == 'sent') {
                $badge = 'info';
                $status = 'Pending';
            }
        ?>
            <tr>
                <td>
                    <b><a href="#" class="transfer-items" transfer="{{$item->transfer_no}}">{{$item->transfer_no}}</a></b>
                </td>
                <td>{{sprintf('%g',$item->sumQ)}}</td>
                <td><b>To: </b>{{$destination}}</td>
                <td><span class="badge badge-<?php echo $badge; ?>">{{$status}}</span></td>
                <td class="table-details"><b>Sender: </b> @if($item->sender){{$item->sender->name}}@endif <br><b>Sent at: </b> {{date("d/m/Y h:i A",strtotime($item->sent_at))}} <br><b>Shipper: </b>@if($item->shipper){{$item->shipper->name}}@endif</td>
                
            </tr>
        @endforeach
    @endif
@endif


@if($data['check'] == 'received')
    @if($data['items']->isNotEmpty())
        @foreach($data['items'] as $item)
        <?php 
            // find where is this transfer from
            $from = '';
            $status = '';
            $badge = '';
            if ($item->from == 'store') {
                $from = $item->fstore->name;
            }
            if ($item->from == 'shop') {
                $from = $item->fshop->name;
            }
            if ($item->status == 'sent') {
                $badge = 'info';
                $status = 'Pending';
            }
            if ($item->status == 'received') {
                $badge = 'success';
                $status = 'Received';
            }
            if ($item->status == 'deleted') {
                $badge = 'danger';
                $status = 'Deleted';
            }
            if ($item->status == 'edit') {
                $badge = 'warning';
                $status = 'Editing';
            }
        ?>
            <tr>
                <td>
                    <b><a href="#" class="transfer-items" transfer="{{$item->transfer_no}}">{{$item->transfer_no}}</a></b>
                </td>
                <td>{{sprintf('%g',$item->sumQ)}}</td>
                <td>{{$from}}</td>
                <td><span class="badge badge-<?php echo $badge; ?>">{{$status}}</span></td>
                <td class="table-details">
                    <b>Sender: </b> @if($item->sender){{$item->sender->name}}@endif <br><b>Sent at: </b> {{date("d/m/Y h:i A",strtotime($item->sent_at))}} <br>
                    <b>Shipper: </b>@if($item->shipper){{$item->shipper->name}}@endif <br><b>Receiver: </b> @if($item->receiver){{$item->receiver->name}}@endif <br>
                    <b>Received at: </b> {{date("d/m/Y h:i A",strtotime($item->received_at))}}
                </td>
                
            </tr>
        @endforeach
    @else
        <tr>
            <td>- No transfers -</td>
        </tr>
    @endif
@endif


@if($data['check'] == 'sent')
    @if($data['items']->isNotEmpty())
        @foreach($data['items'] as $item)
        <?php 
            // find where is this transfer to
            $destination = '';
            $status = '';
            $badge = '';
            if ($item->destination == 'store') {
                $destination = $item->dstore->name;
            }
            if ($item->destination == 'shop') {
                $destination = $item->dshop->name;
            }
            if ($item->status == 'sent') {
                $badge = 'info';
                $status = 'Sent';
            }
            if ($item->status == 'received') {
                $badge = 'success';
                $status = 'Received';
            }
            if ($item->status == 'deleted') {
                $badge = 'danger';
                $status = 'Deleted';
            }
            if ($item->status == 'edit') {
                $badge = 'warning';
                $status = 'Editing';
            }
        ?>
            <tr>
                <td>
                    <b><a href="#" class="transfer-items" transfer="{{$item->transfer_no}}">{{$item->transfer_no}}</a></b>
                </td>
                <td>{{sprintf('%g',$item->sumQ)}}</td>
                <td>{{$destination}}</td>
                <td><span class="badge badge-<?php echo $badge; ?>">{{$status}}</span></td>
                <td class="table-details">
                    <b>Sender: </b> @if($item->sender){{$item->sender->name}}@endif <br><b>Sent at: </b> {{date("d/m/Y h:i A",strtotime($item->sent_at))}} <br>
                    <b>Shipper: </b>@if($item->shipper){{$item->shipper->name}}@endif <br><b>Receiver: </b> @if($item->receiver){{$item->receiver->name}}@endif <br>
                    <b>Received at: </b> {{date("d/m/Y h:i A",strtotime($item->received_at))}}
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td>- No transfers -</td>
        </tr>
    @endif
@endif


@if($data['check'] == 'transfer-items')    
    <div>
        <!-- check if it is from my store or from others --> 
        <?php  $status = ''; ?>
        @if($data['transfer']->from == $data['sshop'] && $data['transfer']->from_id == $data['sid'])
            <h6>To: @if($data['transfer']->destination)<span style="font-weight: 200;">@if($data['transfer']->destination == 'store') {{$data['transfer']->dstore->name}} @else {{$data['transfer']->dshop->name}} @endif</span></h6>
            <h6>Shipper: <span style="font-weight: 200;">@if($data['transfer']->shipper){{$data['transfer']->shipper->name}}@endif</span> @endif</h6>
            <h6>Status:                 
                    <?php if ($data['transfer']->status == 'sent') { ?>
                            <span class="bg-info text-light px-1 pb-1" style="font-weight: 200;"> Not received yet </span>
                    <?php } elseif ($data['transfer']->status == 'received') { ?>
                            <span class="bg-success text-light px-1 pb-1" style="font-weight: 200;"> Received </span>
                    <?php } elseif ($data['transfer']->status == 'deleted') { ?>
                            <span class="bg-danger text-light px-1 pb-1" style="font-weight: 200;"> Deleted </span>
                    <?php } elseif ($data['transfer']->status == 'edit') { ?>
                            <span class="bg-warning text-light px-1 pb-1" style="font-weight: 200;"> Editing </span>
                    <?php  } ?>
                </span>
            </h6>
            @if($data['transfer']->status == 'received')
                <h6>Received by: <span style="font-weight: 200;">@if($data['transfer']->receiver){{$data['transfer']->receiver->name}}@endif</span></h6>
            @endif
        @else
            <h6>From: <span style="font-weight: 200;">@if($data['transfer']->from == 'store') {{$data['transfer']->fstore->name}} @else {{$data['transfer']->fshop->name}} @endif</span></h6>
            <h6>Shipper: <span style="font-weight: 200;">@if($data['transfer']->shipper){{$data['transfer']->shipper->name}}@endif</span></h6>
            <h6>Status:             
                    <?php if ($data['transfer']->status == 'sent') { ?>
                            <span class="bg-info text-light px-1 pb-1" style="font-weight: 200;"> Pending to you </span>
                    <?php } elseif ($data['transfer']->status == 'received') { ?>
                            <span class="bg-success text-light px-1 pb-1" style="font-weight: 200;"> Received </span>
                    <?php  } ?>
            </h6>
        @endif
    </div>
    <div class="table-responsive">
        <table class="table table-hover m-b-0 c_list" style="border-top: none !important;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Qty</th>
                </tr>
            </thead>
            <tbody>
                @if($data['transfers'])
                <?php $num = 1; ?>
                    @foreach($data['transfers'] as $item)
                        <tr>
                            <td>{{$num}}</td>
                            <td>{{$item->product->name}}</td>
                            <td>{{sprintf('%g',$item->quantity)}}</td>
                        </tr>
                    <?php $num++; ?>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <div class="col-md-12 text-center mt-3">
        @if($data['transfer']->from == $data['sshop'] && $data['transfer']->from_id == $data['sid'])
            @if($data['transfer']->status == 'sent')
                @if($data['transfer']->sender_id == Auth::user()->id)
                    <button class="btn btn-sm btn-warning px-4 edit-transfer" transfer="{{$data['transfer']->transfer_no}}">Edit</button> 
                    <button class="btn btn-sm btn-danger px-4 delete-transfer" transfer="{{$data['transfer']->transfer_no}}">Delete</button>
                @endif
            @endif
        @else
            @if($data['transfer']->status == 'sent')
                <!-- <button class="btn btn-sm btn-warning px-2">Decline</button> -->
                <button class="btn btn-sm btn-success px-4 receive-stock" transfer="{{$data['transfer']->transfer_no}}">Receive</button>
            @endif
        @endif
    </div>

    <div style="text-align:center; display: none;" class="mt-3 p-2 border border-danger edit-error">
        Sorry! There is another transfer waiting for you to edit. <br> 
        Please click <a href="/store-master/{{$data['transfer']->from_id}}/transfer-form">HERE</a> to edit them first.
    </div>
@endif



 