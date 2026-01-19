
@include("layouts.translater")

<style type="text/css">

    .table-responsive .c_list {
        font-size: 14px;
    }
    
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

.customer-row {
    cursor: pointer;
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

.c-search input {
    border: 2px solid #ced4da;
}
.c-search .input-group-text {        
    float: right;
    margin-top: -36px;margin-right:15px;
    height: 36px;padding: 0px;
    border-top-left-radius: 0;border: none;
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
@media screen and (max-width: 480px) {
        .reduce-padding {padding-left:5px;padding-right:5px;}
        .table-responsive .c_list {
            font-size: 12px;
        }
        .first-td {
            padding-left: 5px !important;
        }
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

<?php  

    if (isset($data['shop'])) {
        $shop_id = $data['shop']->id;
    } else {
        $shop_id = "all";
    }
?>

<div class="row clearfix"> 
    <div class="col-md-8 offset-md-2 reduce-padding">
        <div class="card">      
            <div class="header">
                <h2><?php echo $_GET["customers"]; ?>:</h2>
                <!-- @if(Auth::user()->isCEOorAdminorCashier())
                <ul class="header-dropdown">
                    <li>
                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#createCustomer">
                            <i class="fa fa-plus text-white pr-1" style="font-size: 14px;"></i> <?php echo $_GET["new-customer"]; ?>
                        </button>
                    </li>
                </ul>
                @endif -->
            </div>     
            <div class="body pt-0">
                <!-- <div class="row">
                    <div class="col-md-8 offset-md-2 col-sm-10 offset-sm-1">
                            <div class="input-group mt-0 mb-3 search-p">
                                @if(isset($data['shop']))
                                    <input type="hidden" name="shopid" value="{{$data['shop']->id}}">
                                @endif
                                <input type="text" class="form-control" name="cname" placeholder="<?php echo $_GET['search-customer']; ?>" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-info search-customer-btn"><?php echo $_GET['search']; ?></button>
                                </div>
                            </div>
                    </div>
                </div> -->
                <div class="row mt-3">                    
                    <div class="col-8 c-search">
                        <div class="form-group mb-3">
                            <input type="text" class="form-control search-product22" check="sales" stoshop="shop" placeholder="<?php echo $_GET['search-customer']; ?>" name="pname" autocomplete="off"> 
                            <span class="input-group-text bg-transparent" style="border-left: none;">
                                <i class="fa fa-search"></i>
                            </span>                            

                            <div class="search-block-outer">
                                <div class="search-block" id="search-block">
                                    
                                </div>
                            </div>                                   

                        </div>
                    </div>
                    <div class="col-2 pr-0" align="right">
                        <button class="btn btn-info" data-toggle="modal" data-target="#createCustomer">
                            <i class="fa fa-plus text-white px-1" style="font-size: 1.5rem;"></i>
                        </button>
                    </div>
                    <div class="col-2 pr-0" align="right">
                        <!-- <button class="btn btn-info" data-toggle="modal" data-target="#createCustomer">
                            <i class="fa fa-filter text-white px-1" style="font-size: 1.4rem;"></i>
                        </button> -->
                            <div class="dropdown">
                                <a class="btn btn-light text-info border" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-filter" style="font-size: 1.5rem;"></i> 
                                </a>    
                                <ul class="dropdown-menu user-menu p-1 pt-2" aria-labelledby="dropdownMenuButton" style="border-radius:5px;margin-left:-160px !important;background-color: #fff;">
                                    <a class="dropdown-item bg-danger text-light py-2 deleted-customers" style="border-radius: 5px 5px 0px 0px;" href="#"><?php echo $_GET['deleted-customers']; ?><i class="fa fa-angle-right pl-3"></i></a>
                                    <!-- <a class="dropdown-item bg-info text-light py-2 add-product-quantity" style="border-radius: 0px 0px 5px 5px;" href="#"><i class="fa fa-plus pr-1"></i> <?php echo $_GET['product-quantity']; ?> <small>(stock)</small></a> -->
                                </ul>
                            </div> 
                    </div>
                </div>
                <div class="row">
                    <div class="table-responsive">
                        <table class="table c_list">
                            <thead class="thead-light">
                                <tr>
                                    <th><?php echo $_GET["name"]; ?></th> 
                                    <th>Deni/Balance</th>           
                                    @if(Auth::user()->isCEOorAdminorCashier())<th></th>@endif
                                </tr>
                            </thead>
                            <tbody class="customers-tbody"> 
                                
                                <!-- <tr class="more-cust-tr">
                                    <td colspan="3" align="center" class="py-2">
                                    <button class="btn btn-info more-customers" lastid="" style="margin-top: 10px !important;"><?php echo $_GET['show-more']; ?></button>
                                    </td>
                                </tr> -->
                            </tbody>                   
                        </table>
                    </div>
                </div>
            </div>                            
        </div>
    </div>
</div>

<!-- deleted customers  -->
<div class="modal fade" id="deletedCustomers" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="title" id="largeModalLabel"><?php echo $_GET['deleted-customers']; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:red;opacity:1">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body list-deleted-customers"> 
                
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-primary">SAVE CHANGES</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
            </div> -->
        </div>
    </div>
</div>


<script type="text/javascript">

    var shop_id = "<?php echo $shop_id; ?>";
    $(function () {        
        $('.customers-tbody').html('<tr><td colspan="2" align="center"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading..</td></tr>');
        $.get('/customers-with-balance/customer/'+shop_id, function(data) {    
            if ($.isEmptyObject(data.customers)) {
                $('.customers-tbody').html('<td colspan="3" align="center"><i>-- <?php echo $_GET["empty-records"]; ?> --</i></td>');
                $('.search-block').html("<div align='center'><i>-No customer-</i></div>");
            } else {
                $('.customers-tbody').html("");
                for (let i = 0; i < data.customers.length; i++) {
                    var profile = "";
                    var gender = data.customers[i]["cgender"];
                    if (gender == "Female") {
                        profile = "/images/xs/woman2.png";
                    } else {
                        profile = "/images/xs/man.png";
                    }
                    var totald = Number(data.customers[i]["a_interest"]) + Number(data.customers[i]["d_amount"]);
                    if (Number(totald) < 0) { // customer anadai duka
                        totald = '<b class="text-success">'+Number(Math.abs(totald)).toLocaleString('en')+'</b>';
                    } else if (Number(totald) > 0) { // customer anadaiwa
                        totald = '<b class="text-danger">'+Number(totald).toLocaleString('en')+'</b>';
                    } else {
                        totald = 0;
                    }
                    $('.customers-tbody').append(
                        '<tr class="customer-row c-'+data.customers[i]["cid"]+'" cid="'+data.customers[i]["cid"]+'">'
                        +'<td class="first-td" style="white-space: normal !important;word-wrap: break-word;">'
                        +'<span style="display:inline-flex;">'
                            +'<img src="'+profile+'" class="rounded-circle avatar mr-2" alt="">'
                            +'<span style="display: inline-block;"><h6 class="margin-0 pb-1"><a href="#">'+data.customers[i]["cname"]+'</a></h6>'
                            +'<small><i class="fa fa-map-marker"></i> '+data.customers[i]["clocation"]+'</small></span>'
                        +'</span></td>'
                        +'<td>'+totald+'</td>'
                        +'<td align="right"><b><i class="fa fa-angle-right fa-2x"></i></b></td>'
                        +'</tr>'
                    );     
                    $('.search-block').append("<div class='customer-row px-2 py-2 border' cid='"+ data.customers[i]['cid'] +"'>"
                        +data.customers[i]['cname'] +"<span style='float:right'><i class='fa fa-angle-right'></i></span></div>");           
                }
            }
        }); 
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

    $(".search-product22").on("click keyup", function() {
        var name = $(this).val().trim().toLowerCase();
        $('.search-block').css('display','block');
        $("#search-block div").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(name) > -1);
        });
    });


</script>