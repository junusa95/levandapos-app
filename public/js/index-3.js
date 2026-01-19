$(function() {
    "use strict";

    $('.knob2').knob({
        draw: function() {           
        }
    });

    // progress bars
    $('.progress .progress-bar').progressbar({
            display_text: 'none'
    });


    // top products
    var dataStackedBar = {
        labels: ['Q1','Q2','Q3','Q4','Q5','Q6'],
        series: [
            [2350,3205,4520,2351,5632,3205],
            [2541,2583,1592,2674,2323,2583],
            [1212,5214,2325,4235,2519,5214],
        ]
    };


    new Chartist.Bar('#patient_history', dataStackedBar, {
        height: "268px",
        stackBars: true,
        axisX: {
            showGrid: false
        },
        axisY: {
            labelInterpolationFnc: function(value) {
                return (value / 1000) + 'k';
            }
        },
        plugins: [
            Chartist.plugins.tooltip({
                appendToBody: true
            }),
            Chartist.plugins.legend({
                legendNames: ['ICU', 'IN-Patinet', 'OUT-Patient']
            })
        ]
    }).on('draw', function(data) {
            if (data.type === 'bar') {
                data.element.attr({
                    style: 'stroke-width: 30px'
                });
            }
    });

    // total_revenue
    var options;
    var data = {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        series: [
            [201, 680, 350, 302, 410, 405, 570, 400, 505, 620, 350, 900],
            [101, 580, 380, 322, 210, 405, 430, 480, 545, 720, 550, 728],
            [58, 89, 102, 201, 210, 310, 258, 268, 349, 120, 98, 105],
        ],
        borderColor:"#000",        
    };    
    options = {
        height: "354px",
        showPoint: true,
        axisX: {
            showGrid: false
        },
        axisY: {
            labelInterpolationFnc: function(value) {
                return (value / 100) + 'K';
            }
        },
        lineSmooth: true,
        plugins: [
            Chartist.plugins.tooltip({
                appendToBody: true
            }),
        ]
    };
    new Chartist.Line('#total_revenue', data, options);    


    // notification popup
    // toastr.options.closeButton = true;
    // toastr.options.positionClass = 'toast-bottom-right';    
    // toastr['success']('Hello, welcome to Lucid, a unique admin Template.');


    var d = [[1196463600000, 0], [1196550000000, 0], [1196636400000, 0], [1196722800000, 77], [1196809200000, 3636], [1196895600000, 3575], [1196982000000, 2736], [1197068400000, 1086], [1197154800000, 676], [1197241200000, 1205], [1197327600000, 906], [1197414000000, 710], [1197500400000, 639], [1197586800000, 540], [1197673200000, 435], [1197759600000, 301], [1197846000000, 575], [1197932400000, 481], [1198018800000, 591], [1198105200000, 608], [1198191600000, 459], [1198278000000, 234], [1198364400000, 1352], [1198450800000, 686], [1198537200000, 279], [1198623600000, 449], [1198710000000, 468], [1198796400000, 392], [1198882800000, 282], [1198969200000, 208], [1199055600000, 229], [1199142000000, 177], [1199228400000, 374], [1199314800000, 436], [1199401200000, 404], [1199487600000, 253], [1199574000000, 218], [1199660400000, 476], [1199746800000, 462], [1199833200000, 448], [1199919600000, 442], [1200006000000, 403], [1200092400000, 204], [1200178800000, 194], [1200265200000, 327], [1200351600000, 374], [1200438000000, 507], [1200524400000, 546], [1200610800000, 482], [1200697200000, 283], [1200783600000, 221], [1200870000000, 483], [1200956400000, 523], [1201042800000, 528], [1201129200000, 483], [1201215600000, 452], [1201302000000, 270], [1201388400000, 222], [1201474800000, 439], [1201561200000, 559], [1201647600000, 521], [1201734000000, 477], [1201820400000, 442], [1201906800000, 252], [1201993200000, 236], [1202079600000, 525], [1202166000000, 477], [1202252400000, 386], [1202338800000, 409], [1202425200000, 408], [1202511600000, 237], [1202598000000, 193], [1202684400000, 357], [1202770800000, 414], [1202857200000, 393], [1202943600000, 353], [1203030000000, 364], [1203116400000, 215], [1203202800000, 214], [1203289200000, 356], [1203375600000, 399], [1203462000000, 334], [1203548400000, 348], [1203634800000, 243], [1203721200000, 126], [1203807600000, 157], [1203894000000, 288]];
    // first correct the timestamps - they are recorded as the daily
    // midnights in UTC+0100, but Flot always displays dates in UTC
    // so we have to add one hour to hit the midnights in the plot

    for (var i = 0; i < d.length; ++i) {
        d[i][0] += 60 * 60 * 1000;
    }

    // helper for returning the weekends in a period
    function weekendAreas(axes) {

        var markings = [],
            d = new Date(axes.xaxis.min);

        // go to the first Saturday

        d.setUTCDate(d.getUTCDate() - ((d.getUTCDay() + 1) % 7))
        d.setUTCSeconds(0);
        d.setUTCMinutes(0);
        d.setUTCHours(0);

        var i = d.getTime();

        // when we don't set yaxis, the rectangle automatically
        // extends to infinity upwards and downwards

        do {
            markings.push({ xaxis: { from: i, to: i + 2 * 24 * 60 * 60 * 1000 } });
            i += 7 * 24 * 60 * 60 * 1000;
        } while (i < axes.xaxis.max);

        return markings;
    }

    var options = {
        xaxis: {
            mode: "time",
            tickLength: 5
        },
        selection: {
            mode: "x"
        },
        grid: {
            markings: weekendAreas,
            borderColor: '#eaeaea',
            tickColor: '#eaeaea',
            hoverable: true,                           
            borderWidth: 1,
        }
    };

    var plot = $.plot("#Visitors_chart", [d], options);

    // now connect the two
    $("#Visitors_chart").bind("plotselected", function (event, ranges) {

        // do the zooming
        $.each(plot.getXAxes(), function(_, axis) {
            var opts = axis.options;
            opts.min = ranges.xaxis.from;
            opts.max = ranges.xaxis.to;
        });
        plot.setupGrid();
        plot.draw();
        plot.clearSelection();

        // don't fire event on the overview to prevent eternal loop

        overview.setSelection(ranges, true);
        
    });

    // Add the Flot version string to the footer
    $("#footer").prepend("Flot " + $.plot.version + " &ndash; ");
});


// my js
var urlArray = window.location.pathname.split('/');

$(function () {
    // disable autocomplete to all forms
    $('form').attr("autocomplete","off");
    
    // $('.homepath').attr('href','/'+urlArray[1]);

    $('.main-menu li a').each(function () {
        var path = window.location.pathname;

        if (path.indexOf('?') > 0) {
            var current = path.indexOf('?');
        }
        else {
            var current = path;
        }

        var url = $(this).attr('href');
        var currenturl = url.substring(url.lastIndexOf('.') + 1);
        const words = current.split("/");
        let word = words[2];
        let word1 = words[1];
        let word2 = words[3];
        if (word1 == "users") {
            current = '/users';
        } 
        // console.log(word1);
        if (word == "customer") {
            current = '/'+words[1]+'/'+words[2]+'s';
            if (words[1] == 'cashier') {
                var val = word2.split('-');
                current = '/'+words[1]+'/'+words[2]+'s/'+val[1];
            }
        } 
        if (word == "new-product-form") {
            current = '/'+words[1]+'/products';
        } 
        if (word == "products" && word1 == "ceo") {
            current = '/'+words[1]+'/products';
        } 
        if (word2 == "sales-report") {
            current = '/'+words[1]+'/'+words[2]+'/sales';
        } 
        if (word1 == "shops") {
            current = '/shops';
            if (word != "") {
                $('.top-btm h2').css('display','none');
            }
        }
        if (word1 == "stores") {
            current = '/stores';
            if (word != "") {
                $('.top-btm h2').css('display','none');
            }
        }
        if (word1 == "business-owner" || word1 == "ceo" || word1 == "cashier" || word1 == "sales-person" || word1 == "store-master") {
            if(word) {
                $('.top-btm h2').css('display','none');
            } else {
                // this is home page 
                $('.breadcrumb').html('<li class="breadcrumb-item"><i class="fa fa-home pr-1"></i> Home</li>');   
            }
        } else {
            $('.top-btm h2').css('display','none');
        }

        if (currenturl.toLowerCase() == current.toLowerCase()) {
            // breadcrumb
            var pagename = $(this).text();
            // console.log(pagename);
            if (pagename == "Dashboard") {     
                        
            } else {                
                $('.breadcrumb').append('<li class="breadcrumb-item"><a href="#" onclick="window.location.replace(document.referrer);" class="homepath2 px-2"><i class="fa fa-arrow-left"></i></a></li><li class="breadcrumb-item active">'+pagename+'</li>');
            }

            // active menu
            $(".main-menu li.active").removeClass("active");
            $(this).closest('.par').addClass('active');
            $(this).parent().closest('li').addClass('active');
            $(this).parent().closest('ul').removeClass('collapse');
        }
    });
});

$(document).on('click', '.click-shortcut', function(e){
    e.preventDefault();
    $('.full-cover').css('display','block');
    $('.full-cover .inside').html('Loading...');
    var check = $(this).attr('check');
    if (check == "sell") {
        $('.shortcut-body').css("display","none");
        $.get('/get-data/sell-products/null', function(data){
            $('.full-cover').css('display','none');
            if (data.status == "not-cashier") {
                $('.shortcut-b-sell').css("display",'block');
                $('#shortcutCheck').modal('toggle');
            } 
            if (data.status == "single-shop") {
                window.location = "/shops/"+data.shop+"?tab=sell-products";
            }             
            if (data.status == "multi-shops") {
                $('.shortcut-b-sell2').css("display",'block');
                $('.render-shops').html("");         
                $('#shortcutCheck').modal('toggle');   
                var who = '';        
                $(data.shops).each(function(index, value) {
                    if (value.who == 'cashier') {who = 'cashier';} else {who = 'sales-person';}
                    $('.render-shops').append('<div class="mb-2"><a href="/shops/'+value.shop_id+'?tab=sell-products" pagename="Cashier" class="text-center">'+
                        '<div class="body border border-success bg-secondary text-light p-2" style="background:#9A9A9A">'+value.name+
                            ' <i class="fa fa-arrow-right ml-3"></i>'+
                        '</div></a></div>');
                });
                return;
            } else {
                // console.log(data.status);
            }
        });
    }
});

$(document).on('click', '.switch-role', function(e){ 
    e.preventDefault();
    var role = $(this).attr('role');
    $('.render-shops, .render-stores, .render-shops-s').html("<div align='center'>Loading..</div>");
    // ask to choose store for store master
    if (role == 'Store Master') {
        $('.titless').html("Select store:");
        $('#chooseStore').modal('toggle');
        $.get('/which-store', function(data){
            if(data.total) {
                if (data.total > 1) {
                    $('.render-stores').html("");                    
                    $(data.stores).each(function(index, value) {
                        $('.render-stores').append('<div class="mb-2"><a href="/store-master/'+value.store_id+'" pagename="Store Master" class="text-center">'+
                            '<div class="body border border-success text-dark p-2" style="background:#9A9A9A">'+value.name+
                                ' <i class="fa fa-arrow-right"></i>'+
                            '</div></a></div>');
                    });
                    return;
                } else if(data.total == 1) {
                    window.location = "/store-master/"+data.stores.store_id;
                }
            } else {

            }
        });
    } else if (role == 'Cashier') {
        $('.titless').html("Select shop:");
        $('#chooseShop').modal('toggle');        
        $.get('/which-shop', function(data){
            if(data.total) {
                if (data.total > 1) {
                    $('.render-shops').html("");                    
                    $(data.shops).each(function(index, value) {
                        $('.render-shops').append('<div class="mb-2"><a href="/cashier/'+value.shop_id+'" pagename="Cashier" class="text-center">'+
                            '<div class="body border border-success text-dark p-2" style="background:#9A9A9A">'+value.name+
                                ' <i class="fa fa-arrow-right"></i>'+
                            '</div></a></div>');
                    });
                    return;
                } else if(data.total == 1) {
                    window.location = "/cashier/"+data.shops.shop_id;
                }
            } else {

            }
        });
    } else if(role == 'Sales Person') {
        $('.titless').html("Select shop:");
        $('#chooseSPerson').modal('toggle');        
        $.get('/which-shop-s', function(data){
            if(data.total) {
                if (data.total > 1) {
                    $('.render-shops-s').html("");                    
                    $(data.shops).each(function(index, value) {
                        $('.render-shops-s').append('<div class="mb-2"><a href="/sales-person/'+value.shop_id+'" pagename="Sales Person" class="text-center">'+
                            '<div class="body border border-success text-dark p-2" style="background:#9A9A9A">'+value.name+
                                ' <i class="fa fa-arrow-right"></i>'+
                            '</div></a></div>');
                    });
                    return;
                } else if(data.total == 1) {
                    window.location = "/sales-person/"+data.shops.shop_id;
                }
            } else {

            }
        });
    } else {
        role = role.replace(/\s+/g, '-').toLowerCase();
        window.location = "/"+role;
    }
});

$(document).on('click', '.switch-store', function(e){ 
    e.preventDefault();
    var store = $(this).attr('store');
    window.location = "/store-master/"+store;
});

$(document).on('click', '.switch-shop', function(e){ 
    e.preventDefault();
    var shop = $(this).attr('shop');
    window.location = "/cashier/"+shop;
});

$(document).on('click', '.switch-shop2', function(e){
    e.preventDefault();
    $('.full-cover').css('display','block');
    $('.full-cover .inside').html('Loading...');
    var shop = $(this).attr('shop');
    window.location = "/shops/"+shop;
});
$(document).on('click', '.switch-store2', function(e){
    e.preventDefault();
    $('.full-cover').css('display','block');
    $('.full-cover .inside').html('Loading...');
    var store = $(this).attr('store');
    window.location = "/stores/"+store;
});

$(document).on('click', '.switch-sale-person', function(e){ 
    e.preventDefault();
    var shop = $(this).attr('shop');
    window.location = "/sales-person/"+shop;
});

$(document).on('submit', '.new-customer', function(e){ // there is another form in shop with class name = new-customer-form-2
    e.preventDefault();
    $('.submit-new-customer').prop('disabled', true).html('submiting..');
    var name = $('.new-customer [name="name"]').val();
    var phone = $('.new-customer [name="phone"]').val();
    var gender = $('.new-customer [name="gender"]').val();
    var location = $('.new-customer [name="location"]').val();
    if (name.trim() == null || name.trim() == '' || phone.trim() == null || phone.trim() == '' || !isphoneNum(phone) || location.trim() == null || location.trim() == '') {
        $('.submit-new-customer').prop('disabled', false).html('Submit');
    }
    if (name.trim() == null || name.trim() == '') {
        $('.new-customer [name="name"]').addClass('parsley-error').focus(); return;}
    if (phone.trim() == null || phone.trim() == '' || !isphoneNum(phone)) {
        $('.new-customer [name="phone"]').addClass('parsley-error').focus(); return;}
    if (location.trim() == null || location.trim() == '') {
        $('.new-customer [name="location"]').addClass('parsley-error').focus(); return;}

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var formdata = new FormData(this);
    $.ajax({
        type: 'POST',
        url: '/add-customer',
        processData: false,
        contentType: false,
        data: formdata,
            success: function(data) {
                $('.submit-new-customer').prop('disabled', false).html('Submit');
                if (data.error) {
                    popNotification('warning',data.error);
                } else {
                    popNotification('success',data.success);
                    $('#createCustomer').modal('hide');
                    $('.shop-tabs .nav-tabs-new .customers-tab').click();
                    $('.new-customer')[0].reset();
                    // $(document).ajaxSuccess(function(){
                    //     window.location.reload();
                    // });
                }
            }
    });
});

$(document).on('submit', '.edit-customer-form', function(e){
    e.preventDefault();
    $('.submit-edit-customer').prop('disabled', true).html('submiting..');
    var customer = $(this).attr('customer');
    var name = $('#editCustomer input[name="name"]').val();
    var phone = $('#editCustomer input[name="phone"]').val();
    var gender = $('#editCustomer .gender').val();
    var location = $('#editCustomer input[name="location"]').val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var formdata = new FormData(this);
    formdata.append('customer',customer);
    formdata.append('name',name);
    formdata.append('phone',phone);
    formdata.append('gender',gender);
    formdata.append('location',location);
    $.ajax({
        type: 'POST',
        url: '/edit-customer',
        processData: false,
        contentType: false,
        data: formdata,
            success: function(data) {
                $('#editCustomer').modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                
                $('.submit-edit-customer').prop('disabled', false).html('Submit');
                if (data.error) {
                    popNotification('warning',data.error);
                } else {
                    popNotification('success',data.success);
                    $('.nav-item .customers-tab').click();
                }
            }
    });
});

$(document).on('submit', '.new-measurement', function(e){
    e.preventDefault();
    $('.submit-new-measurement').prop('disabled', true).html('submiting..');
    var name = $('.new-measurement [name="name"]').val();
    var symbol = $('.new-measurement [name="symbol"]').val();
    if (name.trim() == null || name.trim() == '' || symbol.trim() == null || symbol.trim() == '') {
        $('.submit-new-measurement').prop('disabled', false).html('Submit');
    }
    if (name.trim() == null || name.trim() == '') {
        $('.new-measurement [name="name"]').addClass('parsley-error').focus(); return;}
    if (symbol.trim() == null || symbol.trim() == '') {
        $('.new-measurement [name="symbol"]').addClass('parsley-error').focus(); return;}

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var formdata = new FormData(this);
    $.ajax({
        type: 'POST',
        url: '/add-measurement',
        processData: false,
        contentType: false,
        data: formdata,
            success: function(data) {
                $('.submit-new-measurement').prop('disabled', false).html('Submit');
                if (data.error) {
                    popNotification('warning',data.error); 
                } else {
                    popNotification('success',data.success);
                    $('#addMeasurement').modal('hide');
                    renderMeasurements();
                    // window.location = "/"+urlArray[1]+"/measurements";
                }
            }
    });
});

$(document).on('submit', '.edit-measurement', function(e){
    e.preventDefault();
    $('.submit-edit-measurement').prop('disabled', true).html('submiting..');
    var measurement = $('.edit-measurement [name="measure_id"]').val();
    var name = $('.edit-measurement [name="mname"]').val();
    var symbol = $('.edit-measurement [name="msymbol"]').val();
    if (name.trim() == null || name.trim() == '' || symbol.trim() == null || symbol.trim() == '') {
        $('.submit-edit-measurement').prop('disabled', false).html('Submit');
    }
    if (name.trim() == null || name.trim() == '') {
        $('.edit-measurement [name="mname"]').addClass('parsley-error').focus(); return;}
    if (symbol.trim() == null || symbol.trim() == '') {
        $('.edit-measurement [name="msymbol"]').addClass('parsley-error').focus(); return;}

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var formdata = new FormData(this);
    formdata.append('measurement',measurement);
    formdata.append('name',name);
    formdata.append('symbol',symbol);
    $.ajax({
        type: 'POST',
        url: '/edit-measurement',
        processData: false,
        contentType: false,
        data: formdata,
            success: function(data) {
                $('.submit-edit-measurement').prop('disabled', false).html('Submit');
                if (data.error) {
                    popNotification('warning',data.error);
                } else {
                    popNotification('success',data.success);
                    $('.mrname'+measurement).html(name);
                    $('.mrsymbol'+measurement).html(symbol);
                    $('.edit-measurement')[0].reset();
                    $('#editMeasurement').modal('hide');
                    // window.location = "/"+urlArray[1]+"/measurements";
                }
            }
    });
});

$(document).on('submit', '.new-expense', function(e){
    e.preventDefault();
    $('.submit-new-expense').prop('disabled', true).html('submiting..');
    var name = $('.new-expense [name="name"]').val();
    if (name.trim() == null || name.trim() == '') {
        $('.submit-new-expense').prop('disabled', false).html('Submit');
    }
    if (name.trim() == null || name.trim() == '') {
        $('.new-expense [name="name"]').addClass('parsley-error').focus(); return;}

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var formdata = new FormData(this);
    $.ajax({
        type: 'POST',
        url: '/add-expense',
        processData: false,
        contentType: false,
        data: formdata,
            success: function(data) {
                $('.submit-new-expense').prop('disabled', false).html('Submit');
                if (data.error) {
                    popNotification('warning',data.error);
                } else {
                    popNotification('success',data.success);
                    $('#addExpense').modal('hide');
                    $('.expense-record [name="expense_id').append($('<option>', {
                        value: data.id,
                        text: data.name
                    }));
                    $('.expense-record [name="expense_id"]').val(data.id).change();
                    // location.reload(true);
                    getSExpenses();
                }
            }
    });
});

$(document).on('submit', '.new-expense-2', function(e){
    e.preventDefault();
    $('.submit-new-expense').prop('disabled', true).html('submiting..');
    var name = $('.new-expense-2 [name="name"]').val();
    if (name.trim() == null || name.trim() == '') {
        $('.submit-new-expense').prop('disabled', false).html('Submit');
        $('.new-expense-2 [name="name"]').addClass('parsley-error').focus(); 
        return;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var formdata = new FormData(this);
    $.ajax({
        type: 'POST',
        url: '/add-expense',
        processData: false,
        contentType: false,
        data: formdata,
            success: function(data) {
                $('.submit-new-expense').prop('disabled', false).html('Submit');
                if (data.error) {
                    popNotification('warning',data.error);
                } else {
                    popNotification('success',data.success);
                    $('#addExpense').modal('hide');
                    $('.expense-record [name="expense_id').append($('<option>', {
                        value: data.id,
                        text: data.name
                    }));
                    $('.expense-record [name="expense_id"]').val(data.id).change();
                    // location.reload(true);
                }
            }
    });
});

$(document).on('submit', '.edit-expense', function(e){
    e.preventDefault();
    $('.submit-edit-expense').prop('disabled', true).html('submiting..');
    var expense = $(this).attr('expense');
    var name = $('[name="name'+expense+'"]').val();
    if (name.trim() == null || name.trim() == '') {
        $('.submit-edit-expense').prop('disabled', false).html('Submit');
    }
    if (name.trim() == null || name.trim() == '') {
        $('[name="name'+expense+'"]').addClass('parsley-error').focus(); return;}

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var formdata = new FormData(this);
    formdata.append('expense',expense);
    formdata.append('name',name);
    $.ajax({
        type: 'POST',
        url: '/edit-expense',
        processData: false,
        contentType: false,
        data: formdata,
            success: function(data) {
                $('.submit-edit-expense').prop('disabled', false).html('Submit');
                if (data.error) {
                    popNotification('warning',data.error);
                } else {
                    popNotification('success',data.success);
                    window.location = "/"+urlArray[1]+"/expenses";
                }
            }
    });
});

$(document).on('submit', '.new-shop', function(e){
    e.preventDefault();
    $('.submit-new-shop').prop('disabled', true).html('submiting..');
    var name = $('.new-shop [name="name"]').val();
    var location = $('.new-shop [name="location"]').val();
    var cashier = $('.new-shop [name="cashier"]').val();
    if (name.trim() == null || name.trim() == '' || location.trim() == null || location.trim() == '' || cashier.trim() == null || cashier.trim() == '') {
        $('.submit-new-shop').prop('disabled', false).html('Submit');
    }
    if (name.trim() == null || name.trim() == '') {
        $('.new-shop [name="name"]').addClass('parsley-error').focus(); return;}
    if (location.trim() == null || location.trim() == '') {
        $('.new-shop [name="location"]').addClass('parsley-error').focus(); return;}
    if (cashier.trim() == null || cashier.trim() == '') {
        $('.new-shop [name="cashier"]').addClass('parsley-error').focus(); return;}

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var formdata = new FormData(this);
    formdata.append('status','new shop');
    $.ajax({
        type: 'POST',
        url: '/submit-data',
        processData: false,
        contentType: false,
        data: formdata,
            success: function(data) {
                $('.submit-new-shop').prop('disabled', false).html('Submit');
                if (data.error) {
                    popNotification('warning',data.error);
                } else {
                    popNotification('success',data.success); 
                    $('.append-new-shop').append('<div class="role-col col-md-6 col-sm-6 col-12"><div class="switch-shop2 pb-2 mt-2 pt-1" shop="'+data.data.shop.id+'"><span>'+data.data.shop.name+'</span><span class="separator">|</span><span>'+data.data.shop.location+'</span><span class="align-right pl-3"><i class="fa fa-arrow-right"></i></span></div></div>');
                    $('.empty-shop-desc').css('display','none');
                    $('#newShop').modal('hide');
                    var user_location = $('.user-location').val();
                    if (user_location == 'inside') {
                        var append = $('.custom-options').append('<span class="custom-option change-shop2 new" data-value="'+data.data.shop.id+'">'+data.data.shop.name+'</span>');
                        if (append) {
                            $('.change-shop2.new').click();
                        }
                    }
                    if(user_location == "shops-page") {
                        $(document).ajaxSuccess(function(){
                            window.location.reload();
                        });
                    }
                }
            }
    });
});

$(document).on('submit', '.new-store', function(e){
    e.preventDefault();
    $('.submit-new-store').prop('disabled', true).html('submiting..');
    var name = $('.new-store [name="name"]').val();
    var location = $('.new-store [name="location"]').val();
    var user = $('.new-store [name="user"]').val();
    if (name.trim() == null || name.trim() == '' || location.trim() == null || location.trim() == '') {
        $('.submit-new-store').prop('disabled', false).html('Submit');
    }
    if (name.trim() == null || name.trim() == '') {
        $('.new-store [name="name"]').addClass('parsley-error').focus(); return;}
    if (location.trim() == null || location.trim() == '') {
        $('.new-store [name="location"]').addClass('parsley-error').focus(); return;}

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var formdata = new FormData(this);
    formdata.append('status','new store');
    $.ajax({
        type: 'POST',
        url: '/submit-data',
        processData: false,
        contentType: false,
        data: formdata,
            success: function(data) {
                $('.submit-new-store').prop('disabled', false).html('Submit');
                if (data.error) {
                    popNotification('warning',data.error);
                } else {
                    popNotification('success',data.success);
                    $('.append-new-store').append('<div class="role-col col-md-6 col-sm-6 col-12"><div class="switch-store2 pb-2 mt-2 pt-1" store="'+data.data.store.id+'"><span>'+data.data.store.name+'</span><span class="separator">|</span><span>'+data.data.store.location+'</span><span class="align-right pl-3"><i class="fa fa-arrow-right"></i></span></div></div>');
                    $('.empty-store-desc').css('display','none');
                    $('#newStore').modal('hide');
                    var user_location = $('.user-location2').val();
                    if (user_location == 'inside-store') {
                        var append = $('.custom-options').append('<span class="custom-option change-store2 new" data-value="'+data.data.store.id+'">'+data.data.store.name+'</span>');
                        if (append) {
                            $('.change-store2.new').click();
                        }
                    }
                    if(user_location == "store-page") {
                        $(document).ajaxSuccess(function(){
                            window.location.reload();
                        });
                    }
                }
            }
    });
});

function popNotification(type, message) {
    // notification popup
    toastr.options.closeButton = true;
    toastr.options.positionClass = 'toast-bottom-right';    
    toastr[type](message);
    return;
}

function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}

function isphoneNum(mobNum){
    var filter = /^\d*(?:\.\d{1,2})?$/;
      if (filter.test(mobNum)) {
        if(mobNum.length==10){
            return true;
         } else {
            return false;
          }
        }
        else {
          return false;
       }    
}

// show and hide searchbar in small device
$(function(){
  if ($(window).width() < 482) {
    $(window).scroll(function(){
      if($('.search_icon').hasClass('times')) {

      } else {
        if($(this).scrollTop()>=70){
          $('.search').fadeOut();
          $('.height2').fadeIn();
        } else {
          $('.search').fadeIn();
          $('.height2').fadeOut();
        }
      }
    });
  }
});

$(document).on('click', '.search_icon', function(e){
  e.preventDefault();
  if($(this).hasClass('times')) {
    $(this).removeClass('times').html('<i class="fas fa-search"></i>');
    $('.search').fadeOut();
  } else {
    $(this).addClass('times').html('<i class="fas fa-times"></i>');
    $('.search').fadeIn();
  }
});

$(document).on('keyup', '.search-input', function(e){
  e.preventDefault();
  var input = $(this).val();
  
  if (input.trim() == null || input.trim() == '') {
      
  } else {
      $.get('/search-result/'+input, function(data){ 
        // console.log(data.data);
        $('.search-result').css('display','block');
        $('.search-row').html(data.result);
        // $('.show-more-loader').css('display','none');
        // $('.render-products').append(data.view);              
      });
  }
});

$(document).mouseup(function(e) {
    var container = $(".height");

    // if the target of the click isn't the container nor a descendant of the container
    if (!container.is(e.target) && container.has(e.target).length === 0) 
    {
        $('.search-result').hide();
    }
});

var shop_id = $('[name="shopid"]').val();
var store_id = $('[name="storeid"]').val();

var stoshopid = 0;
if ($.trim(shop_id).length) {
    stoshopid = shop_id;
} 

if ($.trim(store_id).length) {
    stoshopid = store_id;
}

$(document).on('click keyup','.search-product',function(e){
    e.preventDefault();
    $('.search-block').css('display','block').html('<div class="sloader m-2"><i class="fa fa-spinner fa-spin" style="font-size:15px;"></i> Searching...</div>');
    var name = $(this).val().trim();
    var check = $(this).attr('check');
    var stoshop = $(this).attr('stoshop');
    if (!name.trim()) {
        name = 'sdfvaafv';
    }
    $.get('/search-product/'+stoshop+'/'+check+'/'+stoshopid+'/'+name, function(data) {    
        $('.sloader').css('display','none');   
        $('.search-block').html(data.products);
    }); 
});
$(document).click(function(e){
    if ($(e.target).closest(".search-block, .search-product, .search-block2, .search-product2, .search-product22").length === 0) {
        $(".search-block, .search-block2").hide();
    }      
});
$(".search-product2").on("click keyup", function() {
    var name = $(this).val().trim().toLowerCase();
    $('.search-block').css('display','block');
    $("#search-block div").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(name) > -1);
    });
});

$(document).on('click','.searched-item',function(e){
    e.preventDefault();
    $('.submit-sale-cart, .submit-order-cart, .clear-sale-cart').prop('disabled', true);
    var pid = $(this).attr('val');
    var name = $(this).text();
    var qty = $(this).attr('qty');
    var price = $(this).attr('price');
    var check = $(this).attr('check');
    var customer_id = $('.customer').val();
    if (customer_id == '') {
        customer_id = 'null';
    }
    $('.search-block, .search-block2').hide();
    $('.empty-row').css('display','none');
    $('.sold-products, .sold-products2, .render-nst-items').prepend('<tr class="asloader"><td><i class="fa fa-spinner fa-spin" style="font-size:15px;"></i> Adding...</td></tr>');
    if (check == 'sales') {
        $.get('/add-sale/'+shop_id+'/'+pid+'/'+customer_id, function(data) {    
            $('.asloader').hide();     
            $('.submit-sale-cart, .submit-order-cart, .clear-sale-cart').prop('disabled', false);
            if (data.error1) {
                $('.sr-'+data.id).addClass('l-parpl');
                setTimeout(function(){
                    $('.sr-'+data.id).removeClass('l-parpl');
                },5000);
                popNotification('warning',data.error1);
                return;
            }
            if (data.status == "double-click") {
                $('.sr-'+data.id).addClass('xl-slategray');
                setTimeout(function(){
                    $('.sr-'+data.id).removeClass('xl-slategray');
                },3000);                
                $('.sr-'+data.id+' .quantity').val(data.data.qty);
                $('.srp-'+data.id).html(data.data.subtotal);
                $('.totalQ').html(parseFloat(data.data.quantity));
                $('.totalP').html(Number(data.data.price).toLocaleString("en"));     
                return;
            }
            if (data.error) {
                popNotification('warning',data.error);
                return;
            }
            $('.sold-products, .sold-products2').prepend('<tr class="sr-'+data.data.id+'"><td><div class="row">'
                +'<span class="pull-right remove-sr" val="'+data.data.id+'"><i class="fa fa-times"></i></span>'
                +'<div class="col-12 r-name mb-1">'+data.pname+'<span class="aq"></span></div>'
                +'<div class="col-12 s-nums" align="right"> <span><input type="number" class="form-control quantity" name="quantity" value="'+data.data.qty+'" rid="'+data.data.id+'"></span>'
                +'<span><i class="fa fa-times"></i></span> <span><input type="number" class="form-control sprice" name="sprice" value="'+Number(data.data.selling_price)+'" rid="'+data.data.id+'" style="display:inline-block" '+data.data.disabled+'></span>'
                +'<span>=</span><span><b class="srp-'+data.data.id+'">'+data.data.subtotal+'</b></span></div>'
                +'</div></td></tr>');
            $('.totalQ').html(parseFloat(data.data.quantity));
            $('.totalP').html(Number(data.data.price).toLocaleString("en"));
            $('.empty-row').css("display","none");
        });              
    }   
    if (check == 'stock') {
        var from = $('.new-stock [name="from"]').val();
        var whereto = "nowhere";
        if (from == 'ceo') {
            whereto = $('.new-stock [name="whereto"]').val();
            stoshopid = $('.new-stock [name="shostoval"]').val();
        }
        $.get('/add-stock/'+from+'/'+stoshopid+'/'+pid+'/'+customer_id+'/'+whereto, function(data) {  
            $('.asloader').hide();        
            $('.submit-sale-cart, .submit-order-cart, .clear-sale-cart').prop('disabled', false);
            if (data.error1) {
                $('.str-'+data.id).addClass('l-parpl');
                setTimeout(function(){
                    $('.str-'+data.id).removeClass('l-parpl');
                },5000);
                popNotification('warning',data.error1);
                return;
            }
            if (data.error) {
                popNotification('warning',data.error);
                return;
            }
            $('.render-nst-items').prepend('<tr class="str-'+data.data.id+'"><td>'+data.pname+'</td>'+
                '<td><input type="number" class="form-control form-control-sm st-quantity" placeholder="Q" name="quantity" value="'+data.data.qty+'" sid="'+data.data.id+'" style="width:80px"></td>'+
                '<td><span class="p-1 text-danger remove-str" val="'+data.data.id+'" style="cursor: pointer;">'+
                '<i class="fa fa-times"></i></span></td></tr>');            
            $('.totalStQ').html(parseFloat(data.data.quantity));
            $('.empty-row').css("display","none");
        });              
    }
    if (check == 'returnItem') {
        $.get('/add-returned-item/'+shop_id+'/'+pid, function(data) {    
            $('.asloader').hide();        
            $('.submit-sale-cart, .submit-order-cart, .clear-sale-cart').prop('disabled', false);
            if (data.error1) {
                $('.ri-'+data.id).addClass('l-parpl');
                setTimeout(function(){
                    $('.ri-'+data.id).removeClass('l-parpl');
                },5000);
                popNotification('warning',data.error1);
                return;
            }
            if (data.error) {
                popNotification('warning',data.error);
                return;
            }
            $('.returned-items').prepend('<tr class="ri-'+data.data.id+'"><td>'+data.pname+'</td>'
                +'<td><input type="number" class="form-control rquantity" name="quantity" step="0.01" value="'+data.data.qty+'"  rid="'+data.data.id+'"></td>'
                +'<td><span class="p-1 text-danger remove-ri" val="'+data.data.id+'" style="cursor: pointer;"><i class="fa fa-times"></i></span></td></tr>');
            $('.totalQr').html(parseFloat(data.data.quantity));
            $('.empty-row').css("display","none");
        });              
    }   
});

$(document).on('click','.search-p .search-product-btn',function(e){
    $('.render-products, .render-products-m').html('<tr><td colspan="2" align="center"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<td></tr>');
    var name = $('.search-p [name="pname"]').val();
    var from = $('.search-p [name="from"]').val();
    var from2 = $('[name="sfrom"]').val();
    if(from == "shop") {
        var sid = $('.search-p [name="shopid"]').val();
    } else {
        var sid = $('.search-p [name="storeid"]').val();
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var formdata = new FormData();
    if(from2 == "all-products") {
        formdata.append('status','search product');
    } else {
        formdata.append('status','search product 2');
    }    
    formdata.append('name',name);
    formdata.append('from',from);
    formdata.append('from2',from2);
    formdata.append('sid',sid);
    $.ajax({
        type: 'POST',
        url: '/submit-data',
        processData: false,
        contentType: false,
        data: formdata,
            success: function(data) {
                $('.render-products, .render-products-m').html(data.view);
            }
    });
});

$(document).on('click','.search-product-btn-2',function(e){
    $('.render-products-m').html('<tr><td colspan="2" align="center"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<td></tr>');
    var name = $('.manage .search-p [name="pname"]').val();
    var from = $('.manage .search-p [name="from"]').val();
    if(from == "shop") {
        var sid = $('.search-p [name="shopid"]').val();
    } else {
        var sid = $('.search-p [name="storeid"]').val();
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var formdata = new FormData();
    formdata.append('status','search product 2');
    formdata.append('name',name);
    formdata.append('from',from);
    formdata.append('from2','manage-products');
    formdata.append('sid',sid);
    $.ajax({
        type: 'POST',
        url: '/submit-data',
        processData: false,
        contentType: false,
        data: formdata,
            success: function(data) {
                $('.render-products-m').html(data.view);
            }
    });
});

$(document).on('click', '.remove-str', function(e){
    e.preventDefault();
    var id = $(this).attr('val');
    $.get('/remove-row/stock/'+id, function(data){
        if (data.error) {
            popNotification('warning',data.error);
        }
        if (data.success) {
            $('.str-'+data.id).closest("tr").remove();
            $('.totalStQ').html(parseFloat(data.data.quantity));
        }            
    });
});

$(document).on('keyup', '.st-quantity', function(e){
    e.preventDefault();
    var id = $(this).attr('sid');
    var qty = $(this).val();
    $.get('/update-quantity/stock/'+id+'/'+qty, function(data){
        if (data.error) {
            popNotification('warning',data.error);
            return;
        }            
        $('.totalStQ').html(parseFloat(data.data.quantity));         
    });
});

$(document).on('submit', '.new-stock', function(e){ 
    e.preventDefault();
    $('.submit-new-stock').prop('disabled', true).html('submiting..');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var formdata = new FormData(this);
    $.ajax({
        type: 'POST',
        url: '/add-new-stock',
        processData: false,
        contentType: false,
        data: formdata,
            success: function(data) {
                $('.submit-new-stock').prop('disabled', false).html('Submit');
                if (data.error) {
                    popNotification('warning',data.error);
                } else {
                    popNotification('success',data.success);   
                    $('.render-products').html("<tr><td colspan='8' align='center'>Loading...</td></tr>");                 
                    $('.render-nst-items').html('<tr class="empty-row"><td colspan="3" align="center"><i>-- No items --</i></td></tr>');
                    $('.totalStQ').html("0");      
                    $('.previous-stock-records-tab').click();
                    $.get('/get-data/products/ceo', function(data) {
                        $('.render-products').html(data.products);
                    });           
                    // location.reload(true);
                }
            }
    });
});

$(".receiveStock").on('click', function(e) {
    e.preventDefault();
    $(this).prop("disabled", false).html("Receiving..");
    var id = $(this).attr('val');
        $.get('/new-stock/receive/'+id, function(data){
            if (data.success) { 
                popNotification('success','Stock received successfully.');
                $(".btn"+id).css("display","none");
                $('.status'+id).removeClass("badge-secondary").addClass("badge-success").html("Received");  
            }
            if (data.error) {
                popNotification('warning',data.error);
            }
        });
});