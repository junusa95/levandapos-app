@extends('layouts.app')

@section('css')
    <style type="text/css">
        .sales-sm .bg-color1 {
            background: #f9a11d;height: 85px;
        }
        .sales-sm .bg-color2 {
            background: #f9a11d;height: 85px;
        }
        .sales-sm .bg-color3 {
            background: #f9a11d;height: 85px;
        }
        .sales-sm .today-summary, .sales-sm .week-summary, .sales-sm .month-summary {
            text-align: center;background: #01b2c6;padding: 0px;
        }
        .sales-sm .row .col-5, .sales-sm .row .col-3, .sales-sm .row .col-4 {
            background: #01b2c6;padding: 0px;
        }
        .sales-sm .today-summary h5, .sales-sm .week-summary h5, .sales-sm .month-summary h5 {
            margin-left: 10px;
        }
        .sales-body {
            min-height: 110px;
        }
      @media screen and (max-width: 991px) {
        .sales-body {
            min-height: 180px;
        }
      }      
  @media screen and (max-width: 575px) {
    .sales-sm .bg-color2 {
        margin-top: 30px;
    }
    .sales-sm .bg-color3 {
        margin-top: 30px;
    }
  }
  @media screen and (max-width: 480px) {
    .sales-sm .today-summary h5, .sales-sm .week-summary h5, .sales-sm .month-summary h5 {
        font-size: 1rem;font-weight: bold;margin-bottom: 5px;
    }
    .sales-sm .bg-color1, .sales-sm .bg-color2, .sales-sm .bg-color3 {height: 73px;}
  }
    </style>
@endsection

@section('content')

    <div id="wrapper">
        <nav class="navbar navbar-fixed-top">
            <div class="container-fluid">
                @include('layouts.topbar')
            </div>
        </nav>

        <div id="left-sidebar" class="sidebar">
            <div class="sidebar-scroll">
                @include('layouts.leftside')          
            </div>
        </div>

        <div id="main-content">
            <div class="container-fluid">
                <div class="block-header">
                    <div class="row">
                        @include('layouts.topbottombar')
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12">
                        <div class="row clearfix">
                            @include('layouts.switch-role')
                        </div>
                    </div>


                    <div class="col-lg-12 col-sm-12 sales-sm" style="display:none">
                        <div class="card">      
                            <div class="header">
                                <h2><?php echo $_GET['sales-in-summary']; ?>:</h2>
                                <ul class="header-dropdown">
                                    <li>
                                        <a href="/cashier/sales-report" class="more"><span style="display: inline-flex;"><?php echo $_GET['view-in-details']; ?> <span style="padding-left: 5px;"><i class="wi wi-right"></i></span></span> </a>
                                    </li>
                                </ul>
                            </div>     
                            <div class="body pt-0 sales-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="bg-color1 text-light px-2 pt-1">
                                            <h6 class="mb-1"><b><?php echo $_GET['today']; ?></b></h6>
                                            <div class="row today-summary">
                                                  
                                            </div>
                                        </div>
                                    </div>                
                                    <div class="col-sm-4">
                                        <div class="bg-color2 text-light px-2 pt-1">
                                            <h6 class="mb-1"><b><?php echo $_GET['this-week']; ?></b></h6>
                                            <div class="row week-summary">

                                            </div>   
                                        </div>
                                    </div>                
                                    <div class="col-sm-4">
                                        <div class="bg-color3 text-light px-2 pt-1">
                                            <h6 class="mb-1"><b><?php echo $_GET['this-month']; ?></b></h6>
                                            <div class="row month-summary">

                                            </div>   
                                        </div>
                                    </div>                         
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="col-lg-9 col-md-12">
                        <div class="card">
                            <div class="header">
                                <h2>Revenue: This month</h2>
                                <ul class="header-dropdown">
                                    <li><a class="tab_btn" href="javascript:void(0);" title="Weekly">W</a></li>
                                    <li><a class="tab_btn" href="javascript:void(0);" title="Monthly">M</a></li>
                                    <li><a class="tab_btn active" href="javascript:void(0);" title="Yearly">Y</a></li>
                                    <li class="dropdown">
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li><a href="javascript:void(0);">Action</a></li>
                                            <li><a href="javascript:void(0);">Another Action</a></li>
                                            <li><a href="javascript:void(0);">Something else</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="body">
                                <div class="row clearfix">
                                    <div class="col-md-4">
                                        <div class="body bg-success text-light">
                                            <h4><i class="icon-wallet"></i> 7,12,326$</h4>
                                            <span>Total Sales</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="body bg-warning text-light">
                                            <h4><i class="icon-wallet"></i> 25,965$</h4>
                                            <span>Quantity Sold</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="body bg-danger text-light">
                                            <h4><i class="icon-wallet"></i> 14,965$</h4>
                                            <span>Expenses</span>
                                        </div>
                                    </div>
                                </div>
                                <div id="total_revenue" class="ct-chart m-t-20"></div>
                            </div>
                        </div>
                    </div> -->
                </div>


            </div>
        </div>
    </div>

@endsection

@section('js')
<script type="text/javascript">


</script>
@endsection