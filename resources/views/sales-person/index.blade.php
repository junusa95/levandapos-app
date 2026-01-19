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
                </div>


            </div>
        </div>
    </div>

@endsection

@section('js')
<script type="text/javascript">


</script>
@endsection