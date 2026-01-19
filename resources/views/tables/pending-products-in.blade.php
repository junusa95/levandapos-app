
<?php
if(Cookie::get("language") == 'en') {
    $_GET['edit'] = "Edit";
    $_GET['delete'] = "Delete";
} else {
    $_GET['edit'] = "Badili";
    $_GET['delete'] = "Futa";
}
?>

@if($data['pendingstock']->isNotEmpty())
    @foreach($data['pendingstock'] as $value)
        <?php 
        $total = $value->added_quantity * $value->buying_price;
        ?>
        <tr class="pqr-{{$value->id}}">
            <td>
                {{$value->product->name}} 
                <?php if(Auth::user()->isCEOorAdminorBusinessOwner()) { ?>
                    <div class="mt-1">
                        <b class="b_q pq-{{$value->id}}" style="font-weight: bolder;">{{sprintf('%g',$value->added_quantity)}}</b><span>x</span><span><?php echo number_format($value->buying_price); ?></span><span>=</span><span class="pp-{{$value->id}}">{{number_format($total)}}</span>
                    </div>
                <?php } else { ?>
                    <span class="px-1 ml-1 pq-{{$value->id}}" style="background-color: aqua;font-weight: bolder;">{{sprintf('%g',$value->added_quantity)}}</span>
                <?php } ?>
            </td>                                     
            <td>
                @if($value->sender)
                    {{$value->sender->username}} <br> <small>{{date('d/m/Y H:i', strtotime($value->sent_at))}}</small>
                @endif                
            </td>    
            <td class="pending-items pi-{{$value->id}}" align="right">
                <div class="dropdown">
                    @if($data['from'] == "shop")
                        @if($value->shop->is_cashier(Auth::user()->id))
                        <a href="#" class="btn btn-success btn-sm py-1 receive-added-quantity" val="{{$value->id}}" style="font-size:16px;"><i class="fa fa-check"></i></a>
                        @endif
                    @else 
                        @if($value->store->is_storemaster(Auth::user()->id))
                        <a href="#" class="btn btn-success btn-sm py-1 receive-added-quantity" val="{{$value->id}}" style="font-size:16px;"><i class="fa fa-check"></i></a>
                        @endif
                    @endif

                    @if($value->user_id == Auth::user()->id)
                    <a class="btn btn-sm" href="#" role="button" id="dropdownMenuLink{{$value->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        More <i class="fa fa-caret-down"></i>
                    </a>    
                    <div class="dropdown-menu py-0" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item bg-warning text-dark edit-added-quantity py-2" val="{{$value->id}}" pname="{{$value->product->name}}" qty="{{$value->added_quantity}}" style="border-radius: 5px 5px 0px 0px;" href="#"><i class="fa fa-pencil"></i> <?php echo $_GET["edit"]; ?></a>
                        <a class="dropdown-item bg-danger text-light delete-added-quantity py-2" val="{{$value->id}}" pname="{{$value->product->name}}" style="border-radius: 0px 0px 5px 5px;" href="#"><i class="fa fa-times"></i> <?php echo $_GET["delete"]; ?></a>
                    </div>
                    @endif
                </div>
            </td>
        </tr>
    @endforeach
@else
<tr class="empty-row"><td colspan="2" align="center"><i>-- No pending stock --</i></td></tr>
@endif