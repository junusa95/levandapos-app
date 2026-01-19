@extends('layouts.app')
@section('css')
<style type="text/css">
    
/**
 * ==============================================
 * Dot Flashing
 * ==============================================
 */
.dot-flashing {
  position: relative;
  width: 10px;
  height: 10px;
  border-radius: 5px;
  background-color: #9880ff;
  color: #9880ff;
  animation: dotFlashing 1s infinite linear alternate;
  animation-delay: .5s;
}

.dot-flashing::before, .dot-flashing::after {
  content: '';
  display: inline-block;
  position: absolute;
  top: 0;
}

.dot-flashing::before {
  left: -15px;
  width: 10px;
  height: 10px;
  border-radius: 5px;
  background-color: #9880ff;
  color: #9880ff;
  animation: dotFlashing 1s infinite alternate;
  animation-delay: 0s;
}

.dot-flashing::after {
  left: 15px;
  width: 10px;
  height: 10px;
  border-radius: 5px;
  background-color: #9880ff;
  color: #9880ff;
  animation: dotFlashing 1s infinite alternate;
  animation-delay: 1s;
}

@keyframes dotFlashing {
  0% {
    background-color: #9880ff;
  }
  50%,
  100% {
    background-color: #ebe6ff;
  }
}

@media screen and (min-width: 768px) and (max-width: 991px) {
    .filter-c-rec .d, .filter-c-rec .c {
        padding-left: 2px;padding-right: 2px;
    }
    .filter-c-rec .d {
        padding-left: 2px;padding-right: 2px;margin-left: 10px;margin-right: 10px;
    }
    .filter-c-rec .c select {
        padding-left: 0px;padding-right: 0px;font-size: 12px;
    }
    select.form-control:not([size]):not([multiple]) {
        height: 30px;
    }
    .filter-c-rec .d input {
        padding-left: 2px;padding-right: 2px;font-size: 12px;
    }
}
@media screen and (max-width: 768px) {
    .filter-c-rec .c {
        padding-left: 2px;padding-right: 2px;
    }
    .filter-c-rec .c select,.filter-c-rec .d input {
        font-size: 12px;padding: 5px 3px;
    }
    select.form-control:not([size]):not([multiple]) {
        height: 30px;
    }
    .filter-c-rec .b button {
        font-size: 12px;
    }
}
@media screen and (max-width: 560px) {
    /*.card .header h2 {padding-top: 10px;}*/
}
@media screen and (max-width: 425px) {
    .filter-c-rec .d,.filter-c-rec .b {
        padding-left: 2px;padding-right: 2px;
    }
    .filter-c-rec .d input {
        text-align: center;
    }
    .modal-body .c-rec-body {
        background-color: lime;padding: 0px;
    }
}

</style>
@endsection
@section('content')

<?php  
    if($data['customers']){
        $customers = $data['customers'];
    } else {
        $customers = "";
    }

    if (isset($data['shop'])) {
        $shop_id = $data['shop']->id;
    } else {
        $shop_id = "all";
    }
?>
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
                                <h2>Customers:</h2>
                                @if(Auth::user()->isCEOorAdminorCashier())
                                <ul class="header-dropdown">
                                    <li>
                                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#createCustomer">
                                            <b style="">New customer</b>
                                        </button>
                                    </li>
                                </ul>
                                @endif
                            </div>     
                            <div class="body pt-0">
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table c_list">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Name</th> 
                                                    <th>Deni/Balance</th>                     
                                                    <th>Phone</th>                                  
                                                    <th>Gender</th>                                
                                                    <th>Address</th>
                                                    @if(Auth::user()->isCEOorAdminorCashier())<th>Action</th>@endif
                                                </tr>
                                            </thead>
                                                <tbody>
                                                    <?php 
                                                        $url = "-";
                                                        if (Session::get('role') == 'CEO') {
                                                            $url = "ceo";
                                                        }
                                                        if (Session::get('role') == 'Business Owner') {
                                                            $url = "business-owner";
                                                        }
                                                        if (Session::get('role') == 'Cashier') {
                                                            $url = "cashier";
                                                        }
                                                    ?>
                                                @if($data['customers'])
                                                @foreach($data['customers'] as $value)
                                                <?php  
                                                    if ($url == 'cashier') {
                                                        $val = $value->id.'-'.$shop_id;
                                                    } else {
                                                        $val = $value->id;
                                                    }
                                                ?>
                                                    <tr class="c-<?php echo $value->id; ?>">
                                                        <td>
                                                            @if($value->gender == 'Female')
                                                            <img src="{{ asset('images/xs/woman2.png') }}" class="rounded-circle avatar" alt="">
                                                            @else
                                                            <img src="{{ asset('images/xs/man.png') }}" class="rounded-circle avatar" alt="">
                                                            @endif
                                                            <p class="c_name"><a href="/{{$url}}/customer/{{$val}}" class="customer-detail" cid="{{$value->id}}">{{$value->name}}</a></p>
                                                        </td>
                                                        <td  class="pl-4 ddb-{{$value->id}}">
            <div class="dot-flashing"></div>
                                                        </td>
                                                        <td>
                                                            <span class="phone"><i class="fa fa-phone fa-lg m-r-10"></i>{{$value->phone}}</span>
                                                        </td>                                     
                                                        <td>
                                                            {{$value->gender}}
                                                        </td>                                  
                                                        <td>
                                                            <span class="phone"><i class="fa fa-map-marker fa-lg m-r-10"></i>{{$value->location}}</span>
                                                        </td> 
                                                        @if(Auth::user()->isCEOorAdminorCashier())
                                                        <td>  
                                                            <a href="#editCustomer{{$value->id}}" class="btn btn-info btn-sm edit-customer" data-toggle="modal" data-target="#editCustomer{{$value->id}}"><i class="fa fa-edit"></i></a>
                                                            <button class="btn btn-danger delete-customer btn-sm" cname="{{$value->name}}" cid="{{$value->id}}"><i class="icon-trash"></i></button>
                                                        </td>
                                                        @endif
                                                    </tr>
    <div class="modal fade" id="editCustomer{{$value->id}}" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="largeModalLabel">Edit customer</h4>
                </div>
                <div class="modal-body"> 
                    <form id="basic-form" class="edit-customer" customer="{{$value->id}}">
                        @csrf
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Full name</label>
                                    <input type="text" class="form-control" placeholder="Full Name" name="name{{$value->id}}" value="{{$value->name}}" required>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Phone number</label>
                                    <input type="text" class="form-control" placeholder="Phone" name="phone{{$value->id}}" value="{{$value->phone}}" required>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Gender</label>
                                    <select class="form-control show-tick" name="gender{{$value->id}}" required>
                                        <option value="Male" <?php if($value->gender == "Male"){ echo "selected"; } ?>>Male</option>
                                        <option value="Female" <?php if($value->gender == "Female"){ echo "selected"; } ?>>Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" class="form-control" placeholder="Location" name="location{{$value->id}}" value="{{$value->location}}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary submit-edit-customer" style="width: inherit;">Submit</button>
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

    var shop_id = "<?php echo $shop_id; ?>";
    $(function () {        
        "<?php foreach($customers as $customer) { ?>"
            var data = shop_id+"~<?php echo $customer->id; ?>";
            $.get('/available-debt/customer/'+data, function(data) {    
                $('.ddb-'+data.id).html(data.total);
            }); 
        "<?php } ?>"
    });

    $(document).on('click', '.customer-details', function(e){
        e.preventDefault();
        var customer_id = $(this).attr('cid');
        $('input[name="customer_id"]').val(customer_id);
        $('.cname').html($(this).text());
        var fdate = $('input[name="date_f"]').val();
        var tdate = $('input[name="date_t"]').val();
        fdate = fdate.split('/').join('-');
        tdate = tdate.split('/').join('-');
        var shop_id = $('.change-shop').val();
        $('#watejaModal').modal('toggle');
    });

    $(document).on('click', '.delete-customer', function(e){
        e.preventDefault();
        var cname = $(this).attr('cname');
        if(confirm("Click OK to confirm that you delete "+cname+" customer.")){
            $('.full-cover').css('display','block');
            $('.full-cover .inside').html('Deleting...');
            var cid = $(this).attr('cid');

            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            var formdata = new FormData();
            formdata.append('cid',cid);
            formdata.append('cname',cname);
            formdata.append('status','customer');
            $.ajax({
                type: 'POST',   
                url: '/delete',
                processData: false,
                contentType: false,
                data: formdata,
                success: function(data) {
                    $('.full-cover').css('display','none');
                    if (data.error) {
                        popNotification('warning',"Error! Something went wrong, please try again later.");
                    } else {
                        popNotification('success',"Success! "+data.cname+" is deleted successfully.");
                        $(".c-"+data.cid).closest("tr").remove();
                    }
                }
            });
        }
        return;
    });
</script>
@endsection