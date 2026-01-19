@extends('layouts.app')
@section('css')
<style type="text/css">
    .tab_btn {
        cursor: pointer;
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
                    <div class="col-lg-4 col-md-12">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-6">
                                <div class="card">
                                    <div class="header">
                                        <h2>Add Expense:</h2>
                                        <ul class="header-dropdown">
                                            <li><a class="tab_btn" title="Add new" data-toggle="modal" data-target="#addExpense">
                                                <i class="fa fa-plus text-success" style="margin-top: 7px"></i>
                                            </a></li>
                                        </ul>
                                    </div>
                                    <div class="body">
                                        <form id="basic-form" class="" method="post" action="{{ route('expense-cost') }}">
                                            @csrf
                                            <input type="hidden" name="shop_id" value="{{$data['shop']->id}}">
                                            <div class="row clearfix">
                                                <div class="col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label>Expense</label>
                                                        <select class="form-control customer select2" name="expense_id" required>
                                                            <option value="">- select -</option>
                                                            @if($data['expenses'])
                                                                @foreach($data['expenses'] as $expense)
                                                                    <option value="{{$expense->id}}">{{$expense->name}}</option>
                                                                @endforeach
                                                            @else
                                                                <option disabled><i>- no expense -</i></option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Price</label>
                                                        <input type="number" class="form-control form-control-sm" name="amount" placeholder="Amount" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Description</label>
                                                        <textarea name="description" class="form-control" placeholder="Maelezo"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row clearfix">
                                                <div class="col-sm-12">
                                                    <button type="submit" class="btn btn-primary" style="width: inherit;">Submit</button>
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
                            <div class="body">
                                <form id="basic-form" class="form" style="margin-top: -20px;">
                                  <select class="form-control-sm col-md-1 col-3 this-y-2" style="padding:0px">
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                  </select>
                                  <select class="form-control-sm col-md-2 col-5 this-m-2">
                                    <option value="1">January</option>
                                    <option value="2">February</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                  </select>
                                  <select class="form-control-sm col-md-1 col-3 this-d-2">
                                    
                                  </select>
                                </form>
                                <div class="table-responsive">
                                    <table class="table table-hover m-b-0 c_list">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Expense name</th>
                                                <th>Amount</th>
                                                <th>Description</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                            <tbody class="expenses-report">

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


    <div class="modal fade" id="addExpense" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="largeModalLabel">Add expense</h4>
                </div>
                <div class="modal-body"> 
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
                    <br>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-primary">SAVE CHANGES</button> -->
                    <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    @include('modals.edit-expense-cost')

@endsection

@section('js')
<script type="text/javascript">
    $('.select2').select2();
    var shop_id = $('[name="shop_id"]').val();

    $(function () {
        $('.today-summary, .week-summary, .month-summary').html('<i class="fa fa-spinner fa-spin" style="font-size:15px;"></i> Loading...');
        var d = new Date();
        var date = d.getDate();
        var month = d.getMonth()+1;
        var year = d.getFullYear();
        $('.this-d-2 option[value="'+date+'"]').prop('selected', true);
        $('.this-m-2 option[value="'+month+'"]').prop('selected', true);
        $('.this-y-2 option[value="'+year+'"]').prop('selected', true);
        getDatesRange(date,month,year);
    });

    function getDatesRange(thisdate,month,year) {
        var date = new Date();
        var firstDay = new Date(date.getFullYear(), month, 1);
        var lastDay = new Date(date.getFullYear(), month, 0);
        var firstDate = firstDay.getDate();
        var lastDate = lastDay.getDate();
        
        $('.this-d-2').html('');
        for (var i = 1; i <= lastDate; i++) {
            $('.this-d-2').append($('<option>', {value:i, text:i}));
            $('.this-d-2 option[value="'+thisdate+'"]').prop('selected', true);
        }
        expensesByDate(thisdate,month,year,shop_id);
    }

    $(document).on('change','.this-m-2',function(e){
        e.preventDefault();
        var month = $(this).val();
        var year = $(".this-y-2 option:selected").val();
        var date = $(".this-d-2 option:selected").val();
        getDatesRange(date,month,year);
    });
    $(document).on('change','.this-y-2',function(e){
        e.preventDefault();
        var year = $(this).val();
        var month = $(".this-m-2 option:selected").val();
        var date = $(".this-d-2 option:selected").val();
        getDatesRange(date,month,year);
    });
    $(document).on('change','.this-d-2',function(e){
        e.preventDefault();
        var date = $(this).val();
        var year = $(".this-y-2 option:selected").val();
        var month = $(".this-m-2 option:selected").val();
        getDatesRange(date,month,year);
    });

    function expensesByDate(date,month,year,shop_id){
        $('.expenses-report').html("<tr><td colspan='5'>Loading...</td></tr>");
          $.get('/expenses-by-date/cashier/'+date+'/'+month+'/'+year+'/'+shop_id, function(data) {
            $('.expenses-report').html(data.view);
          });
    }

    $(document).on('click','.editExpense',function(e){
        e.preventDefault();
        var id = $(this).attr('val');
        $('.eexpense').val(null).trigger('change');
        $('input[name="row_id"]').val(null);
        $('input[name="eamount"]').val(null);
        $('textarea[name="edescription"]').val(null);
        $('#editExpense').modal('toggle');
        $.get('/expenses-by-id/'+id, function(data) {
            $('input[name="row_id"]').val(data.data.id);
            $('.eexpense').val(data.data.expenseid).trigger('change');
            $('input[name="eamount"]').val(data.data.amount);
            $('textarea[name="edescription"]').val(data.data.description);
        });
    });

    $(document).on('click','.deleteExpense',function(e){
        if(confirm("Click OK to confirm that you remove this expense.")){
            e.preventDefault();
            var id = $(this).attr('val');

            $.get('/delete-expense/'+id, function(data) {
                location.reload();
            });            
        }
        return;
    });
</script>
@endsection