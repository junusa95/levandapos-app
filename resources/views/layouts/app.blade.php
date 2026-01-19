<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title> POS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="description" content="Shop and Inventory Management System">
    <meta name="author" content="Levanda creative team: levanda.co.tz">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- PWA  -->
    <!-- <meta name="theme-color" content="#ffffff"/>
    <link rel="apple-touch-icon" href="{{ asset('images/logo_pwa2.png') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}"> -->
    <!-- end PWA  -->

    <link rel="icon" href="/images/logo_blue.png" type="image/x-icon">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}">

    <link rel="stylesheet" href="{{ asset('vendor/chartist/css/chartist.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/parsleyjs/css/parsley.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{ asset('css/main2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/color_skins.css') }}">

    <style type="text/css">
        .switch-lang {
            border: 1px solid #e9ecef;padding: 5px;color: #000;
        }
        .switch-lang:hover {
            cursor: pointer;
        }
        .switch-lang span {
            font-size: 1rem;
        }
        .btn-outline-orange {
            color: #f94f15;border-color: #f94f15;background: #fff;
        }
        .btn-outline-orange:hover {
            color: #fff;background: #f94f15;
        }
        /*loader*/
        .full-cover {
            position: fixed;top: 0;left: 0; height: 100%;width: 100%;background: white;opacity: 0.5; z-index: 9999;
            display: flex;justify-content: center;display: none;
        }
        .full-cover .center {
            width: 200px;text-align: center;
            color: #fff;background: #000;opacity: 0.9;padding: 10px;font-size: 15px;
        }
        /*.full-cover .center .inside {
            margin-top: auto;margin-bottom: auto;
        }*/

        .header-dropdown .more {padding-bottom: 0px !important;}
        .header-dropdown .more .wi-right {
            font-size: 23px !important;
        }
        .header-dropdown .more:hover {
            border-bottom: 1px solid #007bff;
        }
        .header-dropdown .more:hover .wi-right {
            padding-left: 10px;
        }

        .search-block-outer {
            position: relative;
        }
        .search-block {
            position: absolute;width: 100%;z-index: 999;background: white;padding: 0px;display: none;
            border: 1px solid #ced4da;box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
        }
        .search-block .searched-item {
            float: left; width: 100%;
        }
        .search-block .searched-item:hover {
            background: #efefef;cursor: pointer;text-decoration: underline;
        }
        /*remove arrows from input number*/
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
          -webkit-appearance: none;
          margin: 0;
        }

        /* Firefox */
        input[type=number] {
          -moz-appearance: textfield;
        }

        hr.style14 { 
          border: 0; 
          height: 1px; width: 50%;text-align: center;
          background-image: -webkit-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0);
          background-image: -moz-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0);
          background-image: -ms-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0);
          background-image: -o-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0); 
        }

        .navbar-nav ul.notifications {
            background-color: #01b2c6;
        }
        .navbar-nav ul.notifications li, .navbar-nav ul.notifications li a {
            color: #fff !important;
        }

        /* display image in modal  */
        #modalimgB.modal {
            z-index: 99;
            position: fixed;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.5);
            /* display: flex; when shown*/
            display: none; /* hide initially*/
            justify-content: center;
            align-items: center;
        }
        #modalimgB .modal-content {
            margin: auto;background-color: transparent !important;
        }

        #modalimgB #modalimg {
            width: auto;
            height: auto;
            display: block;
            margin: auto;
            max-height: calc(100vh - 2rem);
            max-width: calc(100% - 2rem);
            object-fit: contain;
        }
        #modalimgB .close {
            position: absolute;
            right: 25px;
            top: 25px;
            z-index: 2;
            background-color: #000;
            color: #fff;
            cursor: pointer;
            width: 25px;
            height: 25px;
            display: flex;
            font-size: 1.5rem;
            justify-content: center;
            align-content: center;
        }
        /* end img modal  */

    @media screen and (max-width: 480px) {
        body {font-size: 1rem;}
        .form-control {font-size: 13px;}
        select.form-control {padding-left: 2px;padding-right: 2px;}
        select.form-control-sm {height: 28px !important;padding-top: 5px;}
        .form-group label {margin-bottom: 0px;}
        .btn.btn-sm {
            /*height: 28px !important;padding-top: 2px;*/
            font-size: 13px;padding: 0.15rem 0.5rem;
        }
    }

    @media screen and (max-width: 400px) {
        .margin-top-400px {
            margin-top: -30px;
        }
    }
    </style>
    @yield('css')
</head>

<?php
    if(Cookie::get("language") == 'en') {
        $_GET['30-days-free-trial'] = "30 days free trial is over";
        $_GET['please-pay-for-this-acc'] = "please pay for your account to continue using it";
        // $_GET['add'] = "Add";
    } else {
        $_GET['30-days-free-trial'] = "Siku 30 za kutumia bure zimeisha";
        $_GET['please-pay-for-this-acc'] = "Tafadhali lipia akaunti yako ili uendelee kuitumia";
    }
?>
<body class="theme-cyan" id="iBody">

    <!-- check if user is logged in -->
    @if (Auth::guest())
        <script type="text/javascript">
            var pathname = window.location.pathname;
            var result = pathname.split('/');
            if (result[1] == "company" && result[2] == "configuration") {
                // proceed for everyone
            } else {
                $('.logout').click();
            }
        </script>
    @endif

    <div style="display: none;">
        <a href="{{ route('logout') }}" class="logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="icon-login"></i></a>
    </div> 
    
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30"><img src="/images/logo_blue.png" width="48" height="48" alt="Levanda"></div>
            <p>Please wait...</p>        
        </div>
    </div>
    <!-- Overlay For Sidebars -->

    <div class="full-cover pt-3">
        <div class="center mx-auto my-auto"><span class="inside">Submitting...</span></div>
    </div>

    <!-- modal for blocked accounts -->
    
    @include('modals.blocked-accounts')

    @yield('content')
    
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <div style="display:none"><div id="clear-error"></div></div>

    <!-- modals -->
    @include('modals.create-user')
    @include('modals.choose-store')
    @include('modals.choose-shop')
    @include('modals.choose-sale-person')
    @include('modals.shortcut-check')
    
    <!-- add sub category modal -->
    <div class="modal fade" id="addSCategory" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="title" id="largeModalLabel"><?php echo $_GET['add-category']; ?></h5>
                    <ul class="header-dropdown mb-0" style="list-style: none;">
                        <li>
                            <button class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i></button>
                        </li>
                    </ul>
                </div>
                <div class="modal-body render-new-sub-category-form"> 

                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-primary">SAVE CHANGES</button> -->
                    <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button> -->
                </div>
            </div>
        </div>
    </div>
    
    <!-- Notification Modal -->
    <div class="modal fade" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <!-- <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5> -->
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:red;opacity:1">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="notification-body pb-3" align="center">
                
            </div>            
        </div>
        <div class="modal-footer" style="display:none">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
        </div>
        </div>
    </div>
    </div>
    
    <div id="modalimgB" class="modal" onclick="this.style.display='none'">
        <span class="close">&times;</span>
        <div class="modal-content">
            <img id="modalimg" src="" alt="Pic">
        </div>
    </div>

<!-- Javascript -->
<script src="{{ asset('bundles/libscripts.bundle.js') }}"></script>
<script src="{{ asset('bundles/vendorscripts.bundle.js') }}"></script>

<script src="{{ asset('bundles/chartist.bundle.js') }}"></script>
<script src="{{ asset('bundles/knob.bundle.js') }}"></script> <!-- Jquery Knob-->
<script src="{{ asset('bundles/flotscripts.bundle.js') }}"></script> <!-- flot charts Plugin Js -->
<script src="{{ asset('vendor/toastr/toastr.js') }}"></script>
<script src="{{ asset('vendor/flot-charts/jquery.flot.selection.js') }}"></script>
<script src="{{ asset('vendor/parsleyjs/js/parsley.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>

<script src="{{ asset('bundles/mainscripts.bundle.js') }}"></script>
<script src="{{ asset('js/index.js') }}"></script>  
<script src="{{ asset('js/cookie.min.js') }}"></script>
<script type="text/javascript">
    // lang change
    // $(document).on('click', '.switch-lang', function(e){ 
    //     var lang = $(this).attr('check');
    //     $.get('/switch-lang/'+lang, function(data){
    //         location.reload();
    //     });
    // });

      // js for PWA.. custom installation button 
      if ('serviceWorker' in navigator && 'PushManager' in window) {
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();

            const deferredPrompt = e;

            const installButton = document.createElement('button');
            installButton.textContent = 'Install Levanda POS App';
            installButton.style.position = 'fixed';
            installButton.style.bottom = '10px';
            installButton.style.left = '50%';
            installButton.style.width = '230px';
            installButton.style.transform = 'translateX(-50%)';
            installButton.style.zIndex = '9999';
            installButton.style.padding = '10px 20px';
            installButton.classList.add('btn-grad');
            installButton.style.color = 'white';
            installButton.style.backgroundColor = '#f94f15';
            installButton.style.border = 'none';
            installButton.style.borderRadius = '5px';
            installButton.style.cursor = 'pointer';

            installButton.addEventListener('click', () => {

                deferredPrompt.prompt();

                deferredPrompt.userChoice.then(choiceResult => {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('App installed');
                    } else {
                        console.log('App installation declined');
                    }

                    installButton.style.display = 'none';
                });
            });

            document.body.appendChild(installButton);
        });
    }
    // end installation button 
    
    // check last time user visits the website
    var thirtymins = (parseFloat(0.5) / parseFloat(24));
    $(window).blur(function() {
        $.cookie('lastvisit', thirtymins, { expires: parseFloat(0.5) / parseFloat(24) });
    });
    $(window).focus(function() {
        checkCookie();
    });

    // logout
    $(document).on('click', '.user-logout', function(e){ 
        e.preventDefault();
        $('#logout-form').submit();
    });

    // display img on modal 
    $(document).on('click', '.image-modal', function(e){ 
        e.preventDefault();
        var url = $(this).attr('url');
        $('#modalimgB .modal-content').html('<img id="modalimg" src="'+url+'" alt="Pic">');
        document.getElementById("modalimgB").style.display = "flex";
    });
    // end img modal 

    // check if it is browser back button, then refresh page 
    $(window).bind("popstate", function() {
        window.location = location.href
    });
    // end check 

    function checkCookie() {
        if (!!$.cookie('lastvisit')) {
            // session still is withing thirty mins
        } else {
            location.reload();
        }        
    }

      // lang change
      $(document).on('click', '.lang-blc', function(e){ 
          $('.lang-drop').css('display','block');
      });
      $(document).on('click', '.switch-lang', function(e){ 
          var lang = $(this).attr('check');
          $('.full-cover').css('display','block');
          $('.full-cover .inside').html('<i class="fa fa-spinner fa-spin fa-2x"></i>');
          $.get('/switch-lang/'+lang, function(data){
              location.reload();
          });
      });

      $(document).mouseup(function(e) {
          var container = $(".height");

          // if the target of the click isn't the container nor a descendant of the container
          if (!container.is(e.target) && container.has(e.target).length === 0) 
          {
              $('.lang-drop, .sale-drop, .drop-action').hide();
              $('.action-company-btn i').removeClass('fa-angle-down'); // admin page, companies action
          }
      });

    $(function () { 

        // check for notifications
        $.get('/notification/check-unread-notifications/<?php echo Auth::user()->company_id; ?>~<?php echo Auth::user()->id; ?>', function(data) {
            
            if(data.nots.length == 0) {
                $('.notification-dot').css('display','none');
                $('.render.notifications').append('<li><div class="media"><div class="media-body text-white"><p class="text text-black-50 pt-3">-- <?php echo $_GET["no-notifications"]; ?> --</p></div></div></li>');
            } else {
                $('.notification-dot').css('display','block');  
                $('.render.notifications').append(data.nots);
            }
            $('.render.notifications').append('<li class="footer"><a href="/notifications" class="more"><?php echo $_GET["see-all-notifications"]; ?></a></li>');
        });            

        // check account status 
        "<?php if(Auth::user()->isAdmin()) { } elseif(Auth::user()->isAgent()) { } else { if (Auth::user()->company->status == 'end free trial') { ?>"
            // $('#endFreeTrialModal').modal('toggle');
        "<?php } } ?>"

        var lmenu = $('.metismenu li .homeli').attr('href'); 
        if (lmenu) {
            $('.homepath').attr('href',lmenu);
        }        

        var text = $('.tcname').val().trim();
        var win = $(this);

        if (win.width() >= 768 && win.width() <= 1058) {
            $('.role-col').addClass('col-md-6').removeClass('col-md-4');
        }
        if (win.width() >= 627) {
            if (text.length > 35) {
                text = text.substr(0,35) + '..';
            }                
            $('.navbar-brand a span').html(text);
        }
        if (win.width() <= 627 && win.width() > 500) {
            if (text.length > 26) {
                text = text.substr(0,26) + '..';
            }                
            $('.navbar-brand a span').html(text);
        }
        if (win.width() <= 730 && win.width() > 440) {
            if ($(".role-col3")[0]) {
                $('.role-col').addClass('col-12').removeClass('col-6').removeClass('col-sm-6');
            }
        }
        if (win.width() <= 500) {
            // $('.role-col').css({'padding-left':'0px','padding-right':'0px'});
        }
        if (win.width() <= 500 && win.width() > 440) {
            if (text.length > 18) {
                text = text.substr(0,18) + '..';
            }                
            $('.navbar-brand a span').html(text);
        }
        if (win.width() <= 440 && win.width() > 390) {
            if (text.length > 14) {
                text = text.substr(0,14) + '..';
            }                
            $('.navbar-brand a span').html(text);
            $('.role-col2').addClass('col-12').removeClass('col');
        }
        if (win.width() <= 390) {
            if (text.length > 11) {
                text = text.substr(0,11) + '..';
            }                
            $('.navbar-brand a span').html(text);
        }
    });
    
    $(document).on('click', '.preview-not', function(e) { 
        e.preventDefault();
        $(this).remove();
        var nid = $(this).attr('nid');
        
        window.location = '/notifications?preview='+nid+'';
    });

    $(window).on('resize', function(){
        var win = $(this); //this = window
        if (win.width() <= 627) {
            var text = $('.navbar-brand a span').text().trim();
            if (text.length > 26) {
                text = text.substr(0,26) + '..';
            }                
            $('.navbar-brand a span').html(text);
        }
        if (win.width() <= 500) {
            var text = $('.navbar-brand a span').text().trim();
            if (text.length > 18) {
                text = text.substr(0,18) + '..';
            }                
            $('.navbar-brand a span').html(text);
        }
        if (win.width() <= 440) {
            var text = $('.navbar-brand a span').text().trim();
            if (text.length > 14) {
                text = text.substr(0,14) + '..';
            }                
            $('.navbar-brand a span').html(text);
        }
        if (win.width() <= 390) {
            var text = $('.navbar-brand a span').text().trim();
            if (text.length > 11) {
                text = text.substr(0,11) + '..';
            }                
            $('.navbar-brand a span').html(text);
        }
    });
        
    $(document).on('click', '.new-sub-category-form', function(e){
        e.preventDefault();
        $('.render-new-sub-category-form').html("<div align='center'>Loading...</div>");
        $.get('/get-form/new-sub-category/0', function(data) {
            $('.render-new-sub-category-form').html(data.form);
        });           
    });
    
    $(document).on('click', '.add-category', function(e){
      e.preventDefault();
      var rowid = parseFloat($(this).attr('id'));
      var newid = (rowid + 1);
      $(this).attr('id',newid);
      $('.new-pcategory [name="check"]').val(newid);
      $('.each-cat').append('<input type="text" class="form-control form-control-sm mt-2" placeholder="Name" name="name'+newid+'" required>');
      // var cat_id = $('.cat0  [name="name"]')val();
    });

    $(document).on('submit', '.new-pcategory', function(e){
        e.preventDefault();
        $('.submit-new-pcategory').prop('disabled', true).html('submiting..');
        var cat_g = $('.new-pcategory [name="group"]').val();
        if (cat_g == null || cat_g == "") {
            $('.submit-new-pcategory').prop('disabled', false).html('Submit');
            return;
        }
        var check = parseFloat($('.new-pcategory [name="check"]').val());
        for (var i = 1; i <= check; i++) {
            var name = $('.new-pcategory [name="name'+i+'"]').val();
            if (name.trim() == null || name.trim() == '') {
                $('.submit-new-pcategory').prop('disabled', false).html('Submit');
            }
            if (name.trim() == null || name.trim() == '') {
                $('.new-pcategory [name="name'+i+'"]').addClass('parsley-error').focus(); return;}
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var formdata = new FormData(this);
        $.ajax({
            type: 'POST',
            url: '/add-p-category',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.submit-new-pcategory').prop('disabled', false).html('Submit');
                    if (data.error) {
                        popNotification('warning',data.error);
                    } else {
                        popNotification('success',data.success);
                        $('#addSCategory').modal('hide');
                        $('.new-pcategory')[0].reset();
                        
                        $.get('/categories-by-group/all', function(data2){ //add on option list
                            $('.pcategory').html('<option value="">- select -</option>');
                            if (data2.cats) {
                                $.each(data2.cats, function (index, value) {
                                    $('.pcategory').append('<option value="'+value.id+'">'+value.name+'</option>');
                                });
                            }
                        });
                        
                        renderProductCategories();
                        
                        // window.location = "/"+urlArray[1]+"/product-categories";
                    }
                }
        });
    });

    $(document).on('click', '.close-instruction', function(e){
        e.preventDefault();
        $('.instruction-block').css('display','none');
        $.get('/update/close-muongozo/<?php echo Auth::user()->company_id; ?>', function(data) {
            popNotification('success','Muongozo umefungwa');
        });           
    });

</script>
@yield('js')
 
</body>
</html>
