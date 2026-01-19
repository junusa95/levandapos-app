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
                                    <div class="header" style="border-bottom: 1px solid #ddd;">
                                        <h2>Create New:</h2>
                                    </div>
                                    <div class="body">
                                        <form id="basic-form" class="new-expense">
                                            @csrf
                                            <div class="row clearfix">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Name</label>
                                                        <input type="text" class="form-control" placeholder="Name" name="name" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row clearfix">
                                                <div class="col-sm-12">
                                                    <button type="submit" class="btn btn-primary submit-new-expense" style="width: inherit;">Submit</button>
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
                                <h2>Expenses:</h2>
                            </div>     
                            <div class="body pt-0">
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table m-b-0 c_list">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                                <tbody>
                                                @if($data['expenses'])
                                                @foreach($data['expenses'] as $value)
                                                    <tr>
                                                        <td>
                                                            {{$value->name}}
                                                        </td>  
                                                        <td>  
                                                            <a href="#editExpense{{$value->id}}" class="btn btn-info btn-sm edit-expense" data-toggle="modal" data-target="#editExpense{{$value->id}}"><i class="fa fa-edit"></i></a>
                                                        </td>
                                                    </tr>
    <div class="modal fade" id="editExpense{{$value->id}}" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="largeModalLabel">Edit expense</h4>
                </div>
                <div class="modal-body"> 
                    <form id="basic-form" class="edit-expense" expense="{{$value->id}}">
                        @csrf
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" placeholder="Expense Name" name="name{{$value->id}}" value="{{$value->name}}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary submit-edit-expense" style="width: inherit;">Submit</button>
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
    </div>
@endsection

@section('js')
<script type="text/javascript">
    
</script>
@endsection