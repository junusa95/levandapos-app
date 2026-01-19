<style type="text/css">
    .other-roles .col-md-3 {}
    .other-roles .col-md-4 .switch-role, 
    .other-roles .col-sm-6 .switch-role,
    .switch-shop2, .switch-store2 {font-size:14px !important}
    .other-roles .switch-shop2, .other-roles .switch-store2 {border-bottom: dotted 1px #ddd;color: #01b2c6;position: relative;text-decoration: none;padding-bottom: 5px;}
    .switch-shop, .switch-shop2, .switch-store2, .switch-store, .switch-sale-person {color: #01b2c6;position: relative;cursor: pointer;}
    .switch-role::before, .switch-shop::before, .switch-shop2::before, .switch-store2::before, .switch-store::before, .switch-sale-person::before {
      content: '';
      position: absolute;
      width: 100%;
      height: 2px;
      border-radius: 2px;
      background-color: #1c64b0;
      bottom: 0;
      left: 0;
      transform-origin: right;
      transform: scaleX(0);
      transition: transform .3s ease-in-out;
    }
    .switch-role:hover::before, .switch-shop:hover::before, .switch-store2:hover::before, .switch-shop2:hover::before, .switch-store:hover::before, .switch-sale-person:hover::before {
      transform-origin: left;
      transform: scaleX(1);
    }
    .other-roles .col-sm-6 .switch-role:hover {
      color: #1c64b0;
    }
    .switch-role {
        cursor: pointer;
    }
  .other-roles .separator {
    padding-left: 5px;padding-right: 5px;
  }
  
    .switch-shop2, .switch-store2 {font-size:16px !important;}
    .switch-shop2 img, .switch-store2 img {float: left;} 
    .switch-shop2 .s-right, .switch-store2 .s-right {display:inline-block;margin-left: 13px;}
    .switch-shop2 .s-right .name, .switch-store2 .s-right .name {font-size:16px !important;color: #007bff;}
    .switch-shop2 .s-right .location, .switch-store2 .s-right .location {font-size:13px !important;color: #222;}
    .switch-shop2 .s-right small, .switch-store2 .s-right small {font-size:11px;background:black;color: #fff;padding: 3px;padding-top: 1px;}
    
</style>

@if(Session::get('role') == 'Cashier' || Session::get('role') == 'Sales Person' || Session::get('role') == 'Store Master')
  <!-- dont display shortcut for cashier and store master  -->
@else
    @include('layouts.shortcuts')
@endif


@if(Session::get('role') == 'Store Master')
    @if($data['stores']->isNotEmpty())
    <div class="role-col3 col"> <!-- role-col3 is used on js.. app.php --> 
        <div class="card">
            <div class="header">
                <h2><?php echo $_GET['stores-you-are-connected']; ?>:</h2>
            </div>
            <div class="body pt-0 other-roles">
                <div class="row">
                @foreach($data['stores'] as $store)
                <?php $gstore = \App\Store::where('id',$store->store_id)->where('company_id',Auth::user()->company_id)->first(); ?>
                    <div class="role-col col-md-6 col-sm-6 col-12">
                        <div class="switch-store2 pb-2 mt-2 pt-1" store="{{$gstore->id}}">
                            <img src="/images/store.png" class="mb-2" width="35" alt=""><br>
                            <span>{{$gstore->name}}</span><span class="separator">|</span><span>{{$gstore->location}}</span>
                            <span class="align-right pl-3"><i class="fa fa-arrow-right"></i></span>
                        </div>
                    </div>
                @endforeach                   
                </div>
            </div>
        </div>
    </div>
    @endif
    @if(Auth::user()->isCashier())
    <?php $data['shops'] = DB::table('shops')->join('user_shops','user_shops.shop_id','shops.id')->where('user_shops.user_id',Auth::user()->id)->where('user_shops.who','cashier')->select('*','shops.id AS sid')->get(); ?>
    @if($data['shops']->isNotEmpty())
    <div class="role-col3 col-12"> <!-- role-col3 is used on js --> 
        <div class="card pb-3">
            <div class="header">
                <h2><?php echo $_GET['shops-you-are-connected']; ?>:</h2>
            </div>
            <div class="body pt-0 other-roles">
                <div class="row">
                @foreach($data['shops'] as $shop)
                    <div class="role-col col-md-6 col-sm-6 col-12">
                        <div class="switch-shop2 pb-2 mt-2 pt-1" shop="{{$shop->sid}}">
                            <img src="/images/shop.png" class="mb-2" width="35" alt=""><br>
                            <span>{{$shop->name}}</span><span class="separator">|</span><span>{{$shop->location}}</span>
                            <span class="align-right pl-3"><i class="fa fa-arrow-right"></i></span>
                        </div>
                    </div>
                @endforeach           
                </div>
            </div>
        </div>
    </div>
    @endif
    @endif
@endif

@if(Session::get('role') == 'Cashier')
    @if($data['shops']->isNotEmpty())
    <div class="role-col3 col-12"> <!-- role-col3 is used on js --> 
        <div class="card pb-3">

            <div class="header">
                <h2><?php echo $_GET['shops-you-are-connected']; ?>:</h2>
            </div>
            <div class="body pt-0 other-roles">
                <div class="row">
                @foreach($data['shops'] as $shop)
                <?php $gshop = \App\Shop::where('id',$shop->shop_id)->where('company_id',Auth::user()->company_id)->first(); ?>
                    <div class="role-col col-md-6 col-sm-6 col-12">
                        <!-- <div class="switch-shop2 pb-2 mt-2 pt-1" shop="{{$gshop->id}}">
                            <img src="/images/shop.png" class="mb-2" width="35" alt=""><br>
                            <span>{{$gshop->name}}</span><span class="separator">|</span><span>{{$gshop->location}}</span>
                            <span class="align-right pl-3"><i class="fa fa-arrow-right"></i></span><br>
                            <small>(Cashier)</small>
                        </div> -->
                                        <div class="switch-shop2 pb-3 mt-2 pt-1" shop="{{$gshop->id}}">
                                            <img src="/images/shop.png" width="50" alt="">
                                            <div class="s-right"> 
                                                <span class="name">{{$gshop->name}} <span class="align-right pl-3"><i class="fa fa-arrow-right"></i></span></span>
                                                <br> <span class="location"><i class="fa fa-map-marker"></i> {{$gshop->location}}</span> <br>
                                                <small><?php echo $_GET['cashier']; ?></small>                                               
                                            </div>
                                        </div>
                    </div>
                @endforeach         
                @if(Auth::user()->hasSalePersonRole())
                <?php $data['shops2'] = DB::table('shops')->join('user_shops','user_shops.shop_id','shops.id')->where('user_shops.user_id',Auth::user()->id)->where('user_shops.who','sale person')->select('*','shops.id AS sid')->get(); ?>
                @if($data['shops2']->isNotEmpty())
                    @foreach($data['shops2'] as $shop2)
                    <div class="role-col col-md-6 col-sm-6 col-12">
                        <!-- <div class="switch-shop2 pb-2 mt-2 pt-1" shop="{{$shop2->sid}}">
                            <img src="/images/shop.png" class="mb-2" width="35" alt=""><br>
                            <span>{{$shop2->name}}</span><span class="separator">|</span><span>{{$shop2->location}}</span>
                            <span class="align-right pl-3"><i class="fa fa-arrow-right"></i></span><br>
                            <small>(Sale person)</small>
                        </div> -->
                                        <div class="switch-shop2 pb-3 mt-2 pt-1" shop="{{$shop2->sid}}">
                                            <img src="/images/shop.png" width="50" alt="">
                                            <div class="s-right"> 
                                                <span class="name">{{$shop2->name}} <span class="align-right pl-3"><i class="fa fa-arrow-right"></i></span></span>
                                                <br> <span class="location"><i class="fa fa-map-marker"></i> {{$shop2->location}}</span> <br>  
                                                <small>Sale person</small>                                             
                                            </div>
                                        </div>
                    </div>
                    @endforeach
                @endif
                @endif
                </div>
            </div>
        </div>
    </div>
    @endif
    @if(Auth::user()->isStoreMaster())
    <?php $data['stores'] = DB::table('stores')->join('user_stores','user_stores.store_id','stores.id')->where('user_stores.user_id',Auth::user()->id)->where('user_stores.who','store master')->select('*','stores.id AS sid')->get(); ?>
    @if($data['stores']->isNotEmpty())
    <div class="role-col3 col-12"> <!-- role-col3 is used on js --> 
        <div class="card pb-3">
            <div class="header">
                <h2><?php echo $_GET['stores-you-are-connected']; ?>:</h2>
            </div>
            <div class="body pt-0 other-roles">
                <div class="row">
                @foreach($data['stores'] as $store)
                    <div class="role-col col-md-6 col-sm-6 col-12">
                        <!-- <div class="switch-store2 pb-2 mt-2 pt-1" store="{{$store->sid}}">
                            <img src="/images/store.png" class="mb-2" width="35" alt=""><br>
                            <span>{{$store->name}}</span><span class="separator">|</span><span>{{$store->location}}</span>
                            <span class="align-right pl-3"><i class="fa fa-arrow-right"></i></span>
                        </div> -->
                        <div class="switch-store2 pb-3 mt-2 pt-1" store="{{$store->sid}}">
                            <img src="/images/store.png" width="50" alt="">
                            <div class="s-right">
                                <span class="name">{{$store->name}} <span class="align-right pl-3"><i class="fa fa-arrow-right"></i></span></span>
                                <br> <span class="location"><i class="fa fa-map-marker"></i> {{$store->location}}</span>                                                
                            </div>
                        </div>
                    </div>
                @endforeach           
                </div>
            </div>
        </div>
    </div>
    @endif
    @endif
@endif

@if(Session::get('role') == 'Sales Person')
    @if($data['shops']->isNotEmpty())
    <div class="role-col3 col-12"> <!-- role-col3 is used on js --> 
        <div class="card pb-3">

            <div class="header">
                <h2><?php echo $_GET['shops-you-are-connected']; ?>:</h2>
            </div>
            <div class="body pt-0 other-roles">
                <div class="row">    
                @if(Auth::user()->hasCashierRole())
                <?php $data['shops2'] = DB::table('shops')->join('user_shops','user_shops.shop_id','shops.id')->where('user_shops.user_id',Auth::user()->id)->where('user_shops.who','cashier')->select('*','shops.id AS sid')->get(); ?>
                @if($data['shops2']->isNotEmpty())
                    @foreach($data['shops2'] as $shop2)
                    <div class="role-col col-md-6 col-sm-6 col-12">
                        <!-- <div class="switch-shop2 pb-2 mt-2 pt-1" shop="{{$shop2->sid}}">
                            <img src="/images/shop.png" class="mb-2" width="35" alt=""><br>
                            <span>{{$shop2->name}}</span><span class="separator">|</span><span>{{$shop2->location}}</span>
                            <span class="align-right pl-3"><i class="fa fa-arrow-right"></i></span><br>
                            <small>(Cashier)</small>
                        </div> -->
                        <div class="switch-shop2 pb-3 mt-2 pt-1" shop="{{$shop2->sid}}">
                            <img src="/images/shop.png" width="50" alt="">
                            <div class="s-right"> 
                                <span class="name">{{$shop2->name}} <span class="align-right pl-3"><i class="fa fa-arrow-right"></i></span></span>
                                <br> <span class="location"><i class="fa fa-map-marker"></i> {{$shop2->location}}</span> <br>  
                                <small><?php echo $_GET['cashier']; ?></small>                                             
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
                @endif
                @foreach($data['shops'] as $shop)
                <?php $gshop = \App\Shop::where('id',$shop->shop_id)->where('company_id',Auth::user()->company_id)->first(); ?>
                    <div class="role-col col-md-6 col-sm-6 col-12">
                        <!-- <div class="switch-shop2 pb-2 mt-2 pt-1" shop="{{$gshop->id}}">
                            <img src="/images/shop.png" class="mb-2" width="35" alt=""><br>
                            <span>{{$gshop->name}}</span><span class="separator">|</span><span>{{$gshop->location}}</span>
                            <span class="align-right pl-3"><i class="fa fa-arrow-right"></i></span><br>
                            <small>(Sale person)</small>
                        </div> -->
                        <div class="switch-shop2 pb-3 mt-2 pt-1" shop="{{$gshop->id}}">
                            <img src="/images/shop.png" width="50" alt="">
                            <div class="s-right"> 
                                <span class="name">{{$gshop->name}} <span class="align-right pl-3"><i class="fa fa-arrow-right"></i></span></span>
                                <br> <span class="location"><i class="fa fa-map-marker"></i> {{$gshop->location}}</span> <br>
                                <small>Sale person</small>                                               
                            </div>
                        </div>
                    </div>
                @endforeach     
                </div>
            </div>
        </div>
    </div>
    @endif
    @if(Auth::user()->isStoreMaster())
    <?php $data['stores'] = DB::table('stores')->join('user_stores','user_stores.store_id','stores.id')->where('user_stores.user_id',Auth::user()->id)->where('user_stores.who','store master')->select('*','stores.id AS sid')->get(); ?>
    @if($data['stores']->isNotEmpty())
    <div class="role-col3 col-12"> <!-- role-col3 is used on js --> 
        <div class="card pb-3">
            <div class="header">
                <h2><?php echo $_GET['stores-you-are-connected']; ?>:</h2>
            </div>
            <div class="body pt-0 other-roles">
                <div class="row">
                @foreach($data['stores'] as $store)
                    <div class="role-col col-md-6 col-sm-6 col-12">
                        <!-- <div class="switch-store2 pb-2 mt-2 pt-1" store="{{$store->sid}}">
                            <img src="/images/store.png" class="mb-2" width="35" alt=""><br>
                            <span>{{$store->name}}</span><span class="separator">|</span><span>{{$store->location}}</span>
                            <span class="align-right pl-3"><i class="fa fa-arrow-right"></i></span>
                        </div> -->
                        <div class="switch-store2 pb-3 mt-2 pt-1" store="{{$store->sid}}">
                            <img src="/images/store.png" width="50" alt="">
                            <div class="s-right">
                                <span class="name">{{$store->name}} <span class="align-right pl-3"><i class="fa fa-arrow-right"></i></span></span>
                                <br> <span class="location"><i class="fa fa-map-marker"></i> {{$store->location}}</span>                                                
                            </div>
                        </div>
                    </div>
                @endforeach           
                </div>
            </div>
        </div>
    </div>
    @endif
    @endif
@endif

@if(Session::get('role') == 'CEO' || Session::get('role') == 'Business Owner') <!-- dont display this to ceo and business owner -->

@else
    @if(Session::get('role') == 'Store Master 2')
    @if($data['otherroles']->isNotEmpty())
    <div class="role-col2 col"> <!-- role-col2 is used on js --> 
        <div class="card">
            <div class="header" style="border-bottom:1px solid #ddd;">
                <h2><?php echo $_GET['you-are-connected-to-other-roles']; ?>:</h2>
            </div>
            <div class="body pt-0 other-roles">
                <div class="row">
                    @foreach($data['otherroles'] as $value)
                    <div class="role-col col-md-4 col-sm-6 col-6">
                        <div class="switch-role pb-2 mt-2 pt-1" role="{{$value->name}}">
                            <span>{{$value->name}}</span>
                            <span class="align-right pl-3"><i class="fa fa-arrow-right"></i></span>
                        </div>
                    </div>
                    @endforeach  
                </div>
            </div>
        </div>
    </div>
    @endif
    @endif
@endif