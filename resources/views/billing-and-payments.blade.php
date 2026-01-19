@extends('layouts.app')
@section('css')
<style type="text/css"> 
    
</style>
@endsection
@section('content')
<?php
    if(Cookie::get("language") == 'en') {
        $_GET['your-account-is-in-free-trial'] = "Your account is in 30 days Free Trial";
        $_GET['not-paid-shops-stores'] = "Not paid shops/stores";
        // $_GET['add'] = "Add";
    } else {
        $_GET['your-account-is-in-free-trial'] = "Akaunti yako ipo kwenye matumizi ya bure ya siku 30";
        $_GET['not-paid-shops-stores'] = "Maduka/stoo hayajalipiwa";
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
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12">
                                <div class="card">
                                    <div class="header" style="border-bottom: 1px solid #ddd;">
                                        <h2><?php echo $_GET['payments']; ?>:</h2>
                                        <!-- <div>
                                            <button class="btn btn-info test-api-post">Test API POST</button>
                                            <button class="btn btn-success test-api-get">Test API GET</button>
                                        </div> -->
                                    </div>
                                    <div class="body">
                                            @if(Auth::user()->company->status == "free trial")
                                            <div class="mb-3" align="center">
                                                <h4 style="background-color: #3A9BDC;"><?php echo $_GET['your-account-is-in-free-trial']; ?></h4>
                                                <?php 
                                                    $today = date('Y-m-d'); 
                                                    $e_days = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime(Auth::user()->company->created_at))))->days;
                                                    $e_days = 30 - $e_days;
                                                ?>
                                                <h5 style="color: #3A9BDC;"><?php if(Cookie::get("language") == 'en') { echo "(".$e_days." days left)"; } else { echo "(Zimebaki siku ".$e_days.")"; } ?></h5>
                                            </div>
                                            @endif
                                        
                                        <div class="row">
                                            <div class="col-12 pb-3"><span style="color: red;"> Duka/stoo ikikaa bila kulipiwa ndani ya siku 30 itafutwa.</span></div>
                                            <div class="col-md-6">
                                                <h6 class="mb-0"><b><?php echo $_GET['shops']; ?>:</b> </h6>
                                                <div class="table-responsive" style="margin-bottom: 40px;">
                                                    <table class="table m-b-0 c_list">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th><?php echo $_GET['name']; ?></th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="render-not-paid">
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <h6 class="mb-0"><b><?php echo $_GET['stores']; ?>:</b> </h6>
                                                <div class="table-responsive" style="margin-bottom: 40px;">
                                                    <table class="table m-b-0 c_list">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th><?php echo $_GET['name']; ?></th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="render-not-paid-stores">
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            
                                            <h6><b><?php echo $_GET['payments-records']; ?>:</b> </h6>
                                            <div class="table-responsive">
                                                <table class="table m-b-0 c_list">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th><?php echo $_GET['amount']; ?></th>
                                                            <th><?php echo $_GET['description']; ?></th>
                                                            <th><?php echo $_GET['paid-date']; ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="render-prev-payments">
                                                        
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
    </div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script type="text/javascript">
    
    $(function () { 
        $('.settings-tab').click();
        $('.render-not-paid, .render-not-paid-stores').html('<tr class="align-center"><td colspan="2">Loading... </td></tr>');
        getNotPaidShopsStores("<?php echo Auth::user()->company->id; ?>");

        localStorage.setItem("authToken", "b8e43c04-df6c-4a46-8f40-52e651df4ffa");
    });


    $(document).on('click', '.test-api-post', function(e) {
        e.preventDefault();

        // Create an Axios instance
        const api = axios.create({
          baseURL: "https://sandbox.azampay.co.tz", // Change to your API base
          headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
          }
        });

        // Add interceptor to automatically attach token
        api.interceptors.request.use(
          (config) => {
            const token = localStorage.getItem("authToken"); // or sessionStorage / cookie
            if (token) {
              config.headers.Authorization = `Bearer ${token}`;
            }
            return config;
          },
          (error) => Promise.reject(error)
        );

        // Generic function to call API
        async function callApi(endpoint, method = "GET", data = null) { 
          try {
            const response = await api.request({
              url: endpoint,
              method,
              data
            });
            return response.data;
          } catch (error) {
            if (error.response) {
              console.error("API error:", error.response.status, error.response.data);
            } else {
              console.error("Request failed:", error.message);
            }
            return null;
          }
        }

        // POST request with token auto-attached
        callApi("/azampay/mno/checkout", "POST", {
            "accountNumber": "255659992590",
            "additionalProperties": {
                "property1": null,
                "property2": null
            },
            "amount": 2000,
            "currency": "tzs",
            "externalId": "string",
            "provider": "Tigo"
        }).then(data => console.log("POST Response:", data));

      //   fetch('https://jsonplaceholder.typicode.com/posts', {
      //     method: 'POST',
      //     body: JSON.stringify({
      //       title: 'fooss',
      //       body: 'barss',
      //       userId: 1,
      //     }),
      //     headers: {
      //       'Content-type': 'application/json; charset=UTF-8',
      //     },
      //   })
      // .then((response) => response.json())
      // .then((json) => console.log(json));


        // POST /azampay/mno/checkout 
        // Host: https://sandbox.azampay.co.tz
        // Accept: application/json
        // Authorization: Bearer b8e43c04-df6c-4a46-8f40-52e651df4ffa
        // Content-Type: application/json
        // Content-Length: 61
        // {
        //   "Id": 78912,
        //   "Customer": "Jason Sweet",
        //   "Quantity": 1,
        //   "Price": 18.00
        // }



    });

    $(document).on('click', '.test-api-get', function(e) {
        e.preventDefault();
        fetch('https://jsonplaceholder.typicode.com/posts/1')
          .then((response) => response.json())
          .then((json) => console.log(json));
    });

    function getNotPaidShopsStores(company_id){
        $.get('/get-data/not-paid-shops-stores/'+company_id, function(data) {    
            $('.render-not-paid').html("");
            if ($.isEmptyObject(data.shops)) { 
                $('.render-not-paid').html('<tr class="align-center"><td colspan="2">No Record</td></tr>');
            } else {
                for (var i = 0; i < data.shops.length; i++) {
                    var status = "";
                    if (data.shops[i]['sstatus'] == null) {
                        status = '<span style="color:#17a2b8">Free Trial</span>';
                    }
                    if (data.shops[i]['sstatus'] == 'active') {
                        status = '<span style="color:#28a745">Active</span>';
                    }
                    if (data.shops[i]['sstatus'] == 'not paid') {
                        status = '<span style="color:red">End Payment</span>';
                    }
                    if (data.shops[i]['sstatus'] == 'end free trial') {
                        status = '<span style="color:red">End Free Trial</span>';
                    }

                    $('.render-not-paid').append(
                            "<tr><td>"+data.shops[i]['sname']+"</td><td>"+status+"</td></tr>"
                        );
                }
            }

            $('.render-not-paid-stores').html("");
            if ($.isEmptyObject(data.stores)) {
                $('.render-not-paid-stores').html('<tr class="align-center"><td colspan="2">No Record</td></tr>');
            } else {
                for (var i = 0; i < data.stores.length; i++) {
                    var status = "";
                    if (data.stores[i]['sstatus'] == null) {
                        status = '<span style="color:#17a2b8">Free Trial</span>';
                    }
                    if (data.stores[i]['sstatus'] == 'active') {
                        status = '<span style="color:#28a745">Active</span>';
                    }
                    if (data.stores[i]['sstatus'] == 'not paid') {
                        status = '<span style="color:red">End Payment</span>';
                    }
                    if (data.stores[i]['sstatus'] == 'end free trial') {
                        status = '<span style="color:red">End Free Trial</span>';
                    }

                    $('.render-not-paid-stores').append(
                            "<tr><td>"+data.stores[i]['sname']+"</td><td>"+status+"</td></tr>"
                        );
                }
            }  

            getCompanyPrevPayments(company_id);
        });         
    }

    function getCompanyPrevPayments(company_id) {
        $('.render-prev-payments').html("<div align='center'>Loading..</div>");
        $('#prevPayments').modal('toggle');
        $.get('/get-data/company-prev-payments/'+company_id, function(data) {    
            if(data.view) {
                $('.render-prev-payments').html(data.view);
            } 
        });         
    }

</script>
@endsection