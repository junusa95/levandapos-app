@extends('layouts.app')
@section('css')
<style type="text/css">
    
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
                        <div class="card">      
                            <div class="header">
                                <h2>Available Products:</h2>
                            </div>     
                            <div class="body pt-0">
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table m-b-0 c_list">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Name</th>    
                                                    <th>Wholesale Price</th>   
                                                    <th>Retail Price</th>            
                                                    <th>Av. Quantity</th>      
                                                    <th>Category</th>  
                                                    <th></th>
                                                </tr>
                                            </thead>
                                                <tbody>
                                                @if($data['products'])
                                                @foreach($data['products'] as $value)
                                                    <tr>
                                                        @if($value->image) 
                                                            <?php $src = '/images/companies/'.Auth::user()->company->folder.'/products/'. $value->image; ?>
                                                        @else
                                                            <?php  $src = "/images/product.jpg"; ?>
                                                        @endif
                                                        <td>
                                                            <span style="display:inline-flex;">
                                                                <img src="{{ $src }}" class="avatar mr-2" alt="">
                                                                <span style="display: inline-block;padding-top: 10px;">
                                                                    {{$value->name}}
                                                                </span>
                                                            </span>
                                                        </td>  
                                                        <td>
                                                            {{number_format($value->wholesale_price)}}
                                                        </td>
                                                        <td>
                                                            {{number_format($value->retail_price)}}
                                                        </td>                                     
                                                        <td>       
                                                            <?php echo sprintf('%g',$value->shopProductRelation($data['shop']->id)->quantity); ?> 
                                                        </td>                                  
                                                        <td>
                                                            <?php
                                                                if ($value->productcategory) {
                                                                    echo $value->productcategory->name;
                                                                    if ($value->productcategory->categorygroup) {
                                                                        echo " (".$value->productcategory->categorygroup->name.")";
                                                                    }
                                                                }
                                                            ?>    
                                                        </td> 
                                                        <td>
                                                            <b><i class="fa fa-angle-right fa-lg"></i></b>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>                            
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