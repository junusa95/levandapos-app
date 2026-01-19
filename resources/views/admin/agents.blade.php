@extends('layouts.app')

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
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="header bg-info" style="padding-bottom: 12px;padding-top: 10px;">
                                        <h2 class="text-white">Agents (<span class="total-agents">-</span>) </h2>
                                        <ul class="header-dropdown">
                                            <!-- <li><button class="btn btn-info btn-sm" data-toggle="modal" data-target="#newCompany">New company</button></li> -->
                                            <!-- <li><button class="btn btn-info btn-sm update-buying-price">update buying price</button></li> -->
                                        </ul>
                                    </div>
                                    <div class="body pt-0">
                                        <div class="table-responsive">
                                            <table class="table m-b-0 c_list">
                                                <thead> 
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Name</th>         
                                                        <th>Location</th>              
                                                        <th>Accounts</th>          
                                                        <th>Sh/St</th>          
                                                        <th>Cr. date</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="render-agents">
                                                    
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
    </div>  
@endsection

@section('js')
<script>    
    $(function () {     
        $('.render-agents').html('<tr class="align-center"><td colspan="2">Loading... </td></tr>');
        getAgents();
    });

    function getAgents() {
        $.get('/agent/get-agents/all', function(data) {    
            $('.total-agents').html(data.data.total_agents);
            $('.render-agents').html(data.agents);
        }); 
    }
</script>
@endsection