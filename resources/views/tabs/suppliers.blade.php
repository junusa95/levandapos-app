
@include("layouts.translater")

<style>
    .supplier-details {cursor: pointer;}
    
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

</style>

<div class="row clearfix"> 
    <div class="col-md-8 offset-md-2 reduce-padding">
        <div class="card" style="box-shadow: none;">      
            <div class="header px-0">
                <h2><?php echo $_GET["suppliers"]; ?>: <?php echo $data['suppliers']->count(); ?></h2>
                @if(Auth::user()->isCEOorAdminorCashier())
                <ul class="header-dropdown">
                    <li>
                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#newSupplier">
                            <i class="fa fa-plus text-white pr-1" style="font-size: 14px;"></i> <?php echo $_GET["new-supplier"]; ?>
                        </button>
                    </li>
                </ul>
                @endif
            </div>     
            <div class="body pt-0 px-0">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table m-b-0 c_list">
                                <tbody class="suppliers-tbody"> 
                                    
                                </tbody>
                            </table> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
if($data['shopstore'] == 'shop') {
    $sid = $data['shop']->id;
    $sname = $data['shop']->name;
} else {
    $sid = $data['store']->id;
    $sname = $data['store']->name;
}
?>
<div class="modal fade" id="newSupplier" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel"><?php echo $_GET["new-supplier"]; ?> <small style="font-size:12px"> - {{$sname}}</small></h4>
            </div>
            <div class="modal-body"> 
                <form id="basic-form" class="new-supplier">
                    @csrf
                    <input type="hidden" name="shopstore" value="{{$data['shopstore']}}"> 
                    <input type="hidden" name="sid" value="{{$sid}}"> 
                    <div class="row clearfix">
                        <div class="col-sm-7 col-8">
                            <div class="form-group">
                                <label><?php echo $_GET["full-name"]; ?></label>
                                <input type="text" class="form-control" placeholder="Full Name" name="name" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label><?php echo $_GET["phone-number"]; ?></label>
                                <input type="text" class="form-control" placeholder="Phone" name="phone" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label><?php echo $_GET["address"]; ?></label>
                                <input type="text" class="form-control" placeholder="Anapopatikana" name="location" required>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row mt-3 clearfix">
                        <div class="col-9">
                            <button type="submit" class="btn btn-primary submit-new-supplier" style="width: inherit;">Submit</button>
                        </div>
                        <div class="col-3">
                            <button type="button" class="btn btn-outline-danger close-modal" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-primary">SAVE CHANGES</button>
            </div> -->
        </div>
    </div>
</div>

<script type="text/javascript">

    $(function () {         
        $('.suppliers-tbody').html('<tr><td colspan="2" align="center"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading..</td></tr>');
        $.get('/suppliers/shop-suppliers-2/<?php echo $sid; ?>', function(data) {    
            if ($.isEmptyObject(data.suppliers)) {
                $('.suppliers-tbody').html('<td colspan="3" align="center"><i>-- <?php echo $_GET["empty-records"]; ?> --</i></td>');
            } else {
                $('.suppliers-tbody').html("");
                for (let i = 0; i < data.suppliers.length; i++) {
                    var profile = "";
                    var totald = Number(data.suppliers[i]["deposits"]) - ( Number(data.suppliers[i]["purchases"]) + Number(data.suppliers[i]["debts"]) );
                    if (Number(totald) < 0) { // supplier anadai duka
                        totald = '<b class="text-danger">'+Number(Math.abs(totald)).toLocaleString('en')+'</b>';
                    } else if (Number(totald) > 0) { // customer anadaiwa
                        totald = '<b class="text-success">'+Number(totald).toLocaleString('en')+'</b>';
                    } else {
                        totald = 0;
                    }
                    $('.suppliers-tbody').append(
                        '<tr class="supplier-details" sid="'+data.suppliers[i]["sid"]+'">'
                        +'<td class="first-td" style="white-space: normal !important;word-wrap: break-word;">'
                        +'<span style="display:inline-flex;">'
                            +'<img src="/images/user-128.png" class="rounded-circle avatar mr-2" alt="">'
                            +'<span style="display: inline-block;"><h6 class="margin-0 pb-1"><a href="#">'+data.suppliers[i]["sname"]+'</a></h6>'
                            +'<small><i class="fa fa-map-marker"></i> '+data.suppliers[i]["slocation"]+'</small></span>'
                        +'</span></td>'
                        +'<td>'+totald+'</td>'
                        +'<td align="right"><b><i class="fa fa-angle-right fa-2x"></i></b></td>'
                        +'</tr>'
                    );                
                }
            }
        }); 
    });

</script>