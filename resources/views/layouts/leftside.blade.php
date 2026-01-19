

<style type="text/css">
    .sidebar-nav {padding-bottom: 100px;}
    .sidebar-nav .main-menu li {padding: 0px;}
</style>
                <div class="user-account">
                    @if(Auth::user()->profile) 
                        <?php $src = 'images/companies/'.Auth::user()->company->folder.'/profiles/'. Auth::user()->profile; ?>
                    @else
                        @if(Auth::user()->gender == 'Male')
                            <?php $src = "images/companies/man.png"; ?>
                        @else
                            <?php $src = "images/companies/woman2.png"; ?>
                        @endif 
                    @endif
                    <img src="{{ asset($src) }}" class="rounded-circle user-photo" alt="User Profile Picture"> 
                    <div class="dropdown">
                        <span><?php echo $_GET['welcome']; ?>,</span>
                        <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown"><strong>
                            @if(Auth::user()->gender == 'Male')
                                Mr. {{Auth::user()->username}}
                            @elseif(Auth::user()->gender == 'Female')
                                Ms. {{Auth::user()->username}}
                            @else
                                {{Auth::user()->username}}
                            @endif                            
                        </strong></a>
                        <ul class="dropdown-menu dropdown-menu-right account" style="padding-left:5px;padding-right:5px">
                            <li><a class="my-profil" href="/user-profile"><i class="icon-user"></i>My Profile</a></li>
                            <li><a href="/company-profile"><i class="icon-layers"></i>Company Profile</a></li>
                            @if(Auth::user()->isCEOorAdminorBusinessOwner())
                            <li><a href="/billing-and-payments"><i class="icon-wallet"></i><?php echo $_GET['billing-and-payments']; ?></a></li>
                            @endif
                            <li class="divider"></li>
                            <li><a href="#" class="user-logout"><i class="icon-power"></i>Logout</a></li>
                        </ul>
                    </div>
                    <hr>
                </div>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#menu">Menu</a></li> 
                    @if(Auth::user()->isCEOorAdminorBusinessOwner())               
                    <!-- <li class="nav-item"><a class="nav-link settings-tab" data-toggle="tab" href="#setting"><i class="icon-settings"></i></a></li>     -->
                    @endif            
                </ul>
                    
                <!-- Tab panes -->
                <div class="tab-content p-l-0 p-r-0">
                    <div class="tab-pane active" id="menu">
                        <nav class="sidebar-nav">
                            <ul class="main-menu metismenu">
                            @if(Session::get('role') == 'Admin')
                                <li class="active"><a href="/admin" class="homeli"><i class="icon-home"></i><span>Home</span></a></li>
                                <li class="par"><a href="javascript:void(0);" class="has-arrow"><i class="icon-user-follow"></i><span><?php echo $_GET['users-menu']; ?></span> </a>
                                    <ul>
                                        <li><a href="/users"><?php echo $_GET['all-users-menu']; ?></a></li>
                                        <li><a href="/users/create"><?php echo $_GET['add-user-menu']; ?></a></li>
                                    </ul>
                                </li>
                                <li><a href="/admin/accounts"><i class="icon-calendar"></i>Accounts</a></li>
                                <li><a href="/admin/agents"><i class="icon-calendar"></i>Agents</a></li>
                                
                            @elseif(Session::get('role') == 'Agent')
                                <li class="active"><a href="/agent" class="homeli"><i class="icon-home"></i><span>Home</span></a></li>
                                <li><a href="/agent/register-account"><i class="icon-calendar"></i><?php echo $_GET['register-account']; ?></a></li>
                                <li><a href="/agent/accounts-you-registered"><i class="icon-calendar"></i><?php echo $_GET['accounts-you-registered']; ?></a></li>

                            @elseif(Session::get('role') == 'Business Owner')
                                <!-- <li class="active"><a href="/home" class="homeli"><i class="icon-home"></i><span>Home</span></a></li> -->
                                <!-- <li><a href="/products"><i class="icon-list"></i><?php //echo $_GET['products-and-stock']; ?></a></li> -->
                                <!-- <li><a href="/stock"><i class="icon-list"></i><?php //echo $_GET['stock-menu']; ?></a></li> -->
                                <li><a href="/shops"><i class="icon-calendar"></i><?php echo $_GET['shops']; ?></a></li>
                                <li><a href="/stores"><i class="icon-calendar"></i><?php echo $_GET['stores']; ?></a></li>
                                <li><a href="/users"><i class="icon-users"></i><?php echo $_GET['users-menu']; ?></a></li>
                                <!-- <li><a href="/business-owner/customers"><i class="icon-users"></i><?php echo $_GET['customers']; ?></a></li> -->
                                <!-- <li><a href="/report/sales"><i class="icon-bar-chart"></i><?php echo $_GET['sales-report-menu']; ?></a></li> -->
                                <!-- <li><a href="javascript:void(0);" class="has-arrow"><i class="icon-wallet"></i><span><?php //echo $_GET['reports-menu']; ?></span> </a>
                                    <ul>
                                        <li><a href="/business-owner/report/sales"><?php //echo $_GET['sales-report-menu']; ?></a></li>
                                        <li><a href="/business-owner/report/stock"><?php //echo $_GET['stock-report-menu']; ?></a></li>
                                    </ul>
                                </li> -->
                                <!-- <li><a href="/business-owner/sales"><i class="icon-list"></i><?php //echo $_GET['sales-report-menu']; ?></a></li>
                                <li><a href="/business-owner/stock"><i class="icon-list"></i><?php //echo $_GET['stock-report-menu']; ?></a></li> -->
                                <!-- <li><a href="/business-owner/stock/adjust-records"><i class="icon-list"></i><?php //echo $_GET['stock-adjustment-menu']; ?></a></li> -->
                                <!-- <li><a href="/business-owner/stock/staking-records"><i class="icon-list"></i><?php //echo $_GET['stock-taking-report-menu']; ?></a></li> -->

                            @elseif(Session::get('role') == 'CEO')
                                <!-- <li class="active"><a href="/home" class="homeli"><i class="icon-home"></i><span>Home</span></a></li> -->
                                <!-- <li><a href="/ceo/measurements"><i class="icon-calendar"></i><?php //echo $_GET['measurements-menu']; ?></a></li> -->
                                <!-- <li><a href="/ceo/product-categories"><i class="icon-list"></i><?php //echo $_GET['p-categories-menu']; ?></a></li> -->
                                <!-- <li><a href="#"><i class="icon-bubbles"></i>Variations</a></li> -->
                                <!-- <li><a href="/products"><i class="icon-list"></i><?php //echo $_GET['products-and-stock']; ?></a></li> -->
                                <!-- <li><a href="/stock"><i class="icon-list"></i><?php //echo $_GET['stock-menu']; ?></a></li> -->
                                <!-- <li><a href="javascript:void(0);" class="has-arrow"><i class="icon-wallet"></i><span><?php //echo $_GET['stock-menu']; ?></span> </a>
                                    <ul>
                                        <li><a href="/ceo/stock/records"><?php //echo $_GET['stock-records']; ?></a></li>
                                        <li><a href="/ceo/stock/adjust"><?php //echo $_GET['adjust-stock-menu']; ?></a></li>
                                        <li><a href="/ceo/stock/taking"><?php //echo $_GET['stock-taking-menu']; ?></a></li>
                                        <div style="display:none;">
                                            <li><a href="/ceo/stock/adjust-records">Adjust Records</a></li>
                                            <li><a href="/ceo/stock/staking-records">Stock Taking Records</a></li>
                                        </div>
                                    </ul>
                                </li> -->
                                <li><a href="/shops"><i class="icon-calendar"></i><?php echo $_GET['shops']; ?></a></li>
                                <li><a href="/stores"><i class="icon-calendar"></i><?php echo $_GET['stores']; ?></a></li>
                                <!-- <li><a href="/ceo/expenses"><i class="icon-list"></i><?php //echo $_GET['expenses-menu']; ?></a></li> -->
                                <li><a href="/users"><i class="icon-users"></i><?php echo $_GET['users-menu']; ?></a></li>
                                <!-- <li><a href="/ceo/customers"><i class="icon-users"></i><?php echo $_GET['customers']; ?></a></li> -->
                                <!-- <li><a href="/report/sales"><i class="icon-bar-chart"></i><?php echo $_GET['sales-report-menu']; ?></a></li> -->
                                <!-- <li><a href="javascript:void(0);" class="has-arrow"><i class="icon-wallet"></i><span><?php //echo $_GET['reports-menu']; ?></span> </a>
                                    <ul>
                                        <li><a href="/ceo/report/sales"><?php //echo $_GET['sales-report-menu']; ?></a></li>
                                    </ul>
                                </li> -->

                            @elseif(Session::get('role') == 'Store Master')
                                <!-- <li class="active"><a href="/home" class="homeli"><i class="icon-home"></i><span>Home</span></a></li> -->
                                <li><a href="/stores"><i class="icon-calendar"></i><?php echo $_GET['stores']; ?></a></li>                                
                                @if(Auth::user()->isCashier())
                                    <li><a href="/shops"><i class="icon-calendar"></i><?php echo $_GET['shops']; ?></a></li>
                                @endif


                            @elseif(Session::get('role') == 'Store Master 2')
                                <li class="active"><a href="/store-master/{{$data['store']->id}}" class="homeli"><i class="icon-home"></i><span>Home</span></a></li>
                                <li><a href="/store-master/{{$data['store']->id}}/products"><i class="icon-calendar"></i><?php echo $_GET['products-menu']; ?></a></li>
                                <li><a href="/store-master/{{$data['store']->id}}/stock"><i class="icon-calendar"></i><?php echo $_GET['stock-menu']; ?></a></li>
                                <li class="par"><a href="javascript:void(0);" class="has-arrow"><i class="fa fa-expand"></i><span><?php echo $_GET['transfer-menu']; ?></span> </a>
                                    <ul>
                                        <li><a href="/store-master/{{$data['store']->id}}/transfer-form"><?php echo $_GET['transfer-item-menu']; ?></a></li>
                                        <li><a href="/store-master/{{$data['store']->id}}/transfers"><?php echo $_GET['transfer-records-menu']; ?></a></li>
                                    </ul>
                                </li>

                            @elseif(Session::get('role') == 'Cashier')
                                <!-- <li class="active"><a href="/home" class="homeli"><i class="icon-home"></i><span>Home</span></a></li> -->
                                <li><a href="/shops"><i class="icon-calendar"></i><?php echo $_GET['shops']; ?></a></li>
                                @if(Auth::user()->isStoreMaster())
                                    <li><a href="/stores"><i class="icon-calendar"></i><?php echo $_GET['stores']; ?></a></li>
                                @endif
                            
                            @elseif(Session::get('role') == 'Cashier-2')
                                <li class="active"><a href="/cashier/{{$data['shop']->id}}" class="homeli"><i class="icon-home"></i><span>Home</span></a></li>
                                <li><a href="/cashier/{{$data['shop']->id}}/sales"><i class="icon-calendar"></i><?php echo $_GET['sales-menu']; ?></a></li>
                                <div style="display:none;">
                                    <li><a href="/cashier/{{$data['shop']->id}}/sales-report"><i class="icon-bar-chart"></i>Sales Report</a></li>
                                </div>
                                <li><a href="/cashier/{{$data['shop']->id}}/products"><i class="icon-calendar"></i><?php echo $_GET['products-menu']; ?></a></li>
                                <li><a href="/cashier/{{$data['shop']->id}}/stock"><i class="icon-calendar"></i><?php echo $_GET['stock-menu']; ?></a></li>
                                <li class="par"><a href="javascript:void(0);" class="has-arrow"><i class="fa fa-expand"></i><span><?php echo $_GET['transfer-menu']; ?></span> </a>
                                    <ul>
                                        <li><a href="/cashier/{{$data['shop']->id}}/transfer-form"><?php echo $_GET['transfer-item-menu']; ?></a></li>
                                        <li><a href="/cashier/{{$data['shop']->id}}/transfers"><?php echo $_GET['transfer-records-menu']; ?></a></li>
                                    </ul>
                                </li>
                                <li><a href="/cashier/{{$data['shop']->id}}/expenses"><i class="icon-calendar"></i><?php echo $_GET['expenses-menu']; ?></a></li>
                                <li><a href="/cashier/customers/{{$data['shop']->id}}"><i class="icon-users"></i><?php echo $_GET['customers']; ?></a></li>

                            @elseif(Session::get('role') == 'Sales Person')
                                <!-- <li class="active"><a href="/home" class="homeli"><i class="icon-home"></i><span>Home</span></a></li> -->
                                <li><a href="/shops"><i class="icon-calendar"></i><?php echo $_GET['shops']; ?></a></li>
                                @if(Auth::user()->isStoreMaster())
                                    <li><a href="/stores"><i class="icon-calendar"></i><?php echo $_GET['stores']; ?></a></li>
                                @endif


                            @elseif(Session::get('role') == 'Sales Person 2')
                                <li class="active"><a href="/sales-person/{{$data['shop']->id}}" class="homeli"><i class="icon-home"></i><span>Home</span></a></li>
                                <li><a href="/sales-person/{{$data['shop']->id}}/sales"><i class="icon-calendar"></i><?php echo $_GET['sales-menu']; ?></a></li>

                            @endif
                            </ul>
                            @if(Auth::user()->isCEOorAdminorBusinessOwner())    
                            <hr>
                            <ul class="main-menu metismenu">
                                <li><a href="/billing-and-payments"><i class="icon-calendar"></i><?php echo $_GET['billing-and-payments']; ?></a></li>
                                <li><a href="/account-settings"><i class="icon-settings"></i>Settings</a></li>
                            </ul>
                            @endif
                            <ul class="main-menu metismenu">
                                <li style="display: none;"><a href="/notifications"><i class="icon-settings"></i>Notifications</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="tab-pane p-l-0 p-r-15" id="setting">
                        <nav class="sidebar-nav pb-0 mb-0">
                            <ul class="main-menu metismenu"> 
                                <!-- <li><a href="/billing-and-payments"><i class="icon-calendar"></i><?php echo $_GET['billing-and-payments']; ?></a></li>
                                <li><a href="/account-settings"><i class="icon-settings"></i>Settings</a></li> -->
                            </ul>
                        </nav>
                        <!-- <h6>Choose Skin</h6>
                        <ul class="choose-skin list-unstyled">
                            <li data-theme="purple">
                                <div class="purple"></div>
                                <span>Purple</span>
                            </li>                   
                            <li data-theme="blue">
                                <div class="blue"></div>
                                <span>Blue</span>
                            </li>
                            <li data-theme="cyan" class="active">
                                <div class="cyan"></div>
                                <span>Cyan</span>
                            </li>
                            <li data-theme="green">
                                <div class="green"></div>
                                <span>Green</span>
                            </li>
                            <li data-theme="orange">
                                <div class="orange"></div>
                                <span>Orange</span>
                            </li>
                            <li data-theme="blush">
                                <div class="blush"></div>
                                <span>Blush</span>
                            </li>
                        </ul> -->
                        <hr>
                    </div>             
                </div>          
