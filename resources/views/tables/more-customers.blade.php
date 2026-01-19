
@include("layouts.translater")

        <?php 
            $lastid = 0;
        ?>
    @if($data['customers']->isNotEmpty())
    @foreach($data['customers'] as $value)
    <?php  
        $lastid = $value->id;
    ?>
        <tr class="c-<?php echo $value->id; ?>">
            <td class="first-td" style="white-space: normal !important;word-wrap: break-word;">
                @if($value->gender == 'Female')
                    <?php $profile = 'images/xs/woman2.png'; ?>
                @else
                    <?php $profile = 'images/xs/man.png'; ?>
                @endif
                
                <span style="display:inline-flex;">
                    <img src="{{ asset($profile) }}" class="rounded-circle avatar mr-2" alt="">
                    <span style="display: inline-block;">
                        <h6 class="margin-0 pb-1"><a href="#" class="customer-detail" cid="{{$value->id}}">{{$value->name}}</a></h6>
                        <small><i class="fa fa-map-marker"></i> {{$value->location}}</small>
                    </span>
                </span>
            </td>
            <td  class="pl-4 ddb-{{$value->id}}">
                <div class="dot-flashing"></div>
            </td>
            <!-- <td>
                <span class="phone"><i class="fa fa-phone fa-lg m-r-10"></i>{{$value->phone}}</span>
            </td>   -->
            @if(Auth::user()->isCEOorAdminorCashier())
            <td>  
                <a href="#" class="btn btn-info btn-sm edit-customer-btn" cid="{{$value->id}}" cname="{{$value->name}}" cphone="{{$value->phone}}" cgender="{{$value->gender}}" clocation="{{$value->location}}"><i class="fa fa-edit"></i></a>
                <button class="btn btn-danger delete-customer btn-sm" cname="{{$value->name}}" cid="{{$value->id}}"><i class="icon-trash"></i></button>
            </td>
            @endif
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="3" align="center">-- No customer --</td>                                    
        </tr>
        @endif
    
    @if($data['count'] > 5)
    <tr class="more-cust-tr"><td colspan="3" align="center" class="py-2">
        <button class="btn btn-info more-customers" lastid="{{$lastid}}" style="margin-top: 10px !important;"><?php echo $_GET['show-more']; ?></button>
    </td></tr>
    @endif