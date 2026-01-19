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
                    <div class="col-lg-4 col-md-12">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-6">
                                <div class="card">
                                    <div class="header">
                                        <h2>Create New:</h2>
                                    </div>
                                    <div class="body">
                                        <form id="basic-form" class="new-measurement">
                                            @csrf
                                            <div class="row clearfix">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Name</label>
                                                        <input type="text" class="form-control" placeholder="Name" name="name" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Symbol</label>
                                                        <input type="text" class="form-control" placeholder="Symbol" name="symbol" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row clearfix">
                                                <div class="col-sm-12">
                                                    <button type="submit" class="btn btn-primary submit-new-measurement" style="width: inherit;">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8 col-md-12">
                        <div class="card">      
                            <div class="header">
                                <h2>Measurements:</h2>
                            </div>     
                            <div class="body">
                                <div class="table-responsive">
                                    <table class="table table-hover m-b-0 c_list">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Name</th>                                    
                                                <th>Symbol</th> 
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                            <tbody>
                                            @if($data['measurements'])
                                            @foreach($data['measurements'] as $value)
                                                <tr>
                                                    <td>
                                                        {{$value->name}}
                                                    </td>                                 
                                                    <td>
                                                        {{$value->symbol}}
                                                    </td>   
                                                    <td>  
                                                        <a href="#editMeasurement{{$value->id}}" class="btn btn-info btn-sm edit-measurement" data-toggle="modal" data-target="#editMeasurement{{$value->id}}"><i class="fa fa-edit"></i></a>
                                                    </td>
                                                </tr>
<div class="modal fade" id="editMeasurement{{$value->id}}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">Edit measurement</h4>
            </div>
            <div class="modal-body"> 
                <form id="basic-form" class="edit-measurement" measurement="{{$value->id}}">
                    @csrf
                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" placeholder="Name" name="name{{$value->id}}" value="{{$value->name}}" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Symbol</label>
                                <input type="text" class="form-control" placeholder="Symbol" name="symbol{{$value->id}}" value="{{$value->symbol}}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary submit-edit-measurement" style="width: inherit;">Submit</button>
                        </div>
                    </div>
                </form>
                <br>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-primary">SAVE CHANGES</button> -->
                <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>
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
@endsection

@section('js')
<script type="text/javascript">
    
</script>
@endsection