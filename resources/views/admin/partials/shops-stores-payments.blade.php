


        <div class="mb-2">
            <span>Account name:</span>
            <b>@if($data['account']) {{$data['account']->name}} @endif</b>
            <br>
            <small>Fill amount you pay to each shop/store</small>
        </div>
        <hr>
        <form id="sh-st-payment-frm" class="sh-st-payment-frm">
            @csrf
            <div class="row mb-3">
                <div class="com-md-4 col-6">
                    <label class="mb-0"><small>Who paid</small></label>
                    <select name="user" class="form-control">
                        @if($data['account']->users)
                        @foreach($data['account']->users as $user)
                        <option value="{{$user->id}}">{{$user->username}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-6">
                    <label class="mb-3" style="border-bottom: 2px solid #000;">
                        <b>Shops</b>
                    </label>
                    @if($data['shops']->isEmpty())
                    <div class="form-group">
                        <div style="color: red;">
                            No shop created 
                        </div>
                    </div>
                    @else
                    <input type="hidden" name="countshops" value="{{count($data['shops'])}}">
                    <?php $num = 1; ?>
                    @foreach($data['shops'] as $shop)
                    <?php 
                    $i_date = null;
                    if($shop->payments()->isNotEmpty()) {
                        $pay = \App\PaymentsDesc::where('paid_for','shop')->where('paid_item',$shop->id)->orderBy('id','desc')->first();                        
                        $i_date = date('Y-m-d', strtotime($pay->expire_date . ' +1 day'));
                    }
                    ?>
                    <div class="form-group">
                        <label class="mb-0">{{$shop->name}}</label>
                        <div class="row pb-2" style="background:#ddd">
                            <input type="hidden" name="shop{{$num}}" value="{{$shop->id}}">
                            <div class="col-6">
                                    <label class="mb-0"><small>Amount</small></label>
                                    <input type="number" class="form-control form-control-sm pamount" name="sha{{$num}}">
                                    <label class="mb-0"><small>No of months</small></label>
                                    <input type="number" class="form-control form-control-sm pmonths" name="shmonths{{$num}}" style="width:100px">
                            </div>
                            <div class="col-6">
                                <label class="mb-0"><small>Issued date</small></label>
                                <input type="date" class="form-control form-control-sm" name="shi{{$num}}" value="@if($i_date){{$i_date}}@endif">
                                <label class="mb-0"><small>Expire date</small></label>
                                <input type="date" class="form-control form-control-sm" name="shd{{$num}}">
                            </div>
                        </div>                        
                    </div>
                    <?php $num++; ?>
                    @endforeach
                    @endif
                </div>
                <div class="col-6">
                    <label class="mb-3" style="border-bottom: 2px solid #000;">
                        <b>Stores</b>
                    </label>
                    @if($data['stores']->isEmpty())
                    <div class="form-group">
                        <div style="color: red;">
                            No store created
                        </div>
                    </div>
                    @else
                    <input type="hidden" name="countstores" value="{{count($data['stores'])}}">
                    <?php $nums = 1; ?>
                    @foreach($data['stores'] as $store)
                    <?php 
                    $i_date = null;
                    if($store->payments()->isNotEmpty()) {
                        $pay = \App\PaymentsDesc::where('paid_for','store')->where('paid_item',$store->id)->orderBy('id','desc')->first();                       
                        $i_date = date('Y-m-d', strtotime($pay->expire_date . ' +1 day'));
                    }
                    ?>
                    <div class="form-group ml-1">
                        <label class="mb-0">{{$store->name}}</label>
                        <div class="row pb-2" style="background:#ddd">
                            <input type="hidden" name="store{{$nums}}" value="{{$store->id}}">
                            <div class="col-6 pl-1">
                                <label class="mb-0"><small>Amount</small></label>
                                <input type="number" class="form-control form-control-sm pamount" name="sta{{$nums}}">
                                    <label class="mb-0"><small>No of months</small></label>
                                    <input type="number" class="form-control form-control-sm pmonths" name="stmonths{{$nums}}" style="width:100px">
                            </div>
                            <div class="col-6 pr-1">
                                <label class="mb-0"><small>Issued date</small></label>
                                <input type="date" class="form-control form-control-sm" name="sti{{$nums}}" value="@if($i_date){{$i_date}}@endif">
                                <label class="mb-0"><small>Expire date</small></label>
                                <input type="date" class="form-control form-control-sm" name="std{{$nums}}">
                            </div>
                        </div>                        
                    </div>
                    <?php $nums++; ?>
                    @endforeach
                    @endif
                </div>
                <div class="col-12 mt-3" align="center">
                    <button type="submit" class="btn btn-primary sh-st-payment-btn" style="width: 50%;">Submit</button>
                </div>
            </div>
        </form>