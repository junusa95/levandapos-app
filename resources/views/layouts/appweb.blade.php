<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>LevandaPOS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Mfumo unaomsaidia mfanyabiashara kujua mwenendo wa biashara yake. Ukuaji na uporomokaji wa biashara.">
    <meta name="author" content="Levanda Developer">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- PWA  -->
    <meta name="theme-color" content="#ffffff"/>
    <link rel="apple-touch-icon" href="{{ asset('images/logo_pwa2.png') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">
    <!-- end PWA  -->

    <link rel="icon" href="/images/logo_blue.png" type="image/x-icon">
    
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="{{ asset('web/css/bootstrap.min.css') }}">
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
  @yield('css')
    <style type="text/css">
      body{font-size: 1rem !important;background: #fff;}
      /*.navbar-brand a {font-size: 2rem !im;}*/
      .btn-outline-orange {
        color: #f94f15;border-color: #f94f15;background: #fff;
      }
      .btn-outline-orange:hover {
        color: #fff;background: #f94f15;
      }
      .navbar-nav .nav-link {padding-left: 5px;padding-right: 5px;}
      .navbar-nav .nav-link:hover {background-color: #fbfbfb;}
      #left-sidebar {left: -250px;}
      .shadow {
        box-shadow: 0 10px 55px 5px rgb(137 173 255 / 15%) !important;
      }
      .shape-1 {
        position: relative;
        top: -3px;
        width: 100%;
        left: 0;
        right: 0;
      }
      .btn-primary, .bg-primary, .theme-blue:before, .theme-blue:after, .theme-blue ::selection, .theme-blue #wrapper:after {
        background: #003D8F !important;border-color: #003D8F !important;
      }
      .btn-sec-primary {background: #f94f15;color: #fff;}
      .btn-primary:hover {background: #fff !important;border-color: #003D8F;color: #003D8F;}
      .btn-sec-primary:hover {background: #fff;border-color: #f94f15;color: #f94f15;}
      .theme-blue #wrapper:after, .theme-blue #wrapper:before {
        background: transparent !important;
      }
      .badge-secondary-soft {
        background-color: rgba(19, 96, 239, .1);
        color: #1360ef;
      }
      .badge-primary-soft {
        background-color: rgba(19, 96, 239, .1);
        color: #1360ef;
      }
      .badge-secondary-soft { background-color: rgba(80, 102, 144, .1); color: #506690 }
      .badge-success-soft { background-color: rgba(40, 167, 69, .1); color: #28a745 }
      .badge-info-soft { background-color: rgba(23, 162, 184, .1); color: #17a2b8 }
      .badge-warning-soft { background-color: rgba(255, 193, 7, .1); color: #ffc107 }
      .badge-danger-soft { background-color: rgba(220, 53, 69, .1); color: #dc3545 }
      .badge-light-soft { background-color: rgba(245, 250, 255, .1); color: #f5faff }
      .badge-dark-soft { background-color: rgba(6, 9, 39, .1); color: #060927 }
      .bg-orange {background: #f94f15;}
      /*top nav*/
      .navbar.navbar-fixed-top .container {display: flex;flex-wrap: nowrap;justify-content: start;}
      .navbar.navbar-fixed-top .container .navbar-right {position: absolute;right: 0;margin-right: 100px;}
      .login-btn {padding: 0.4rem 1rem;font-size: 16px;font-weight: 600;}
      .lang-blc {border: 1px solid #ddd;padding: 0px 5px 4px 5px;margin-left: 10px;cursor: pointer;}
      .lang-blc .lw {font-size: 0.9rem;}
      .lang-drop {position: absolute;background: #fff;width: 100px;margin-left: -35px;margin-top: 3px; text-align: center;display: none;
        box-shadow: 0 1px 1px rgba(0,0,0,0.08), 0 2px 2px rgba(0,0,0,0.12), 0 4px 4px rgba(0,0,0,0.16), 0 8px 8px rgba(0,0,0,0.20);}
      .lang-drop .switch-lang {display: block;border-bottom: 0.5px solid #ebe8e8;padding: 5px;}
      .lang-drop .switch-lang:hover {background: #ebe8e8;}
      .show-lang img {height: 15px;}
      .lang-drop .switch-lang img {height: 20px;}
      @media screen and (max-width: 1230px) {
          .lang-blc { padding-bottom: 2px; }
      }
      @media screen and (max-width: 1200px) {
          #left-sidebar {margin-top: -20px !important;box-shadow: none;}
          .offcanvas-active #left-sidebar {left: 0px;box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.2);}
      }
      @media screen and (max-width: 991px) {
        .navbar.navbar-fixed-top .container .navbar-right {width: auto;}
        .top-slider-i { margin-top: 30px; }
      }
      @media screen and (max-width: 767px) {
        .wasiliana {margin-top: 50px;}
        .wasiliana .w-address {margin-top: -20px;}
      }
      @media screen and (max-width: 620px) {
        .navbar.navbar-fixed-top .container .navbar-right {margin-right: 50px;}
      }
      @media screen and (max-width: 520px) {
        .navbar.navbar-fixed-top .container .navbar-right {margin-right: 15px;}
        .navbar-nav li.agent {display: none !important;}
      }
      @media screen and (max-width: 480px) {
          body {
            font-size: 1rem !important;
          }
          .top-left-m h1 {font-size: 1.5rem !important;}
      }
      @media screen and (max-width: 400px) {
          .navbar-brand a img {width: 95px;}
          .login-btn { padding: 2px 10px; }
          .top-slider {margin-top: -20px;}
      }

      /*side social*/
      .s-social {
          position: fixed;z-index: 999;
          bottom: 20px;
          right:5px;
      }

      .s-social ul {
        padding: 0px;
        -webkit-transform: translate(270px, 0);
        -moz-transform: translate(270px, 0);
        -ms-transform: translate(270px, 0);
        -o-transform: translate(270px, 0);
        transform: translate(270px, 0);
      }

      .s-social ul li {
          display: block;
          margin: 3px;
          background: #f94f15;
          width: 300px;
          text-align: left;
          padding: 5px;
          -webkit-border-radius: 30px 0 0 30px;
          -moz-border-radius: 30px 0 0 30px;
          border-radius: 30px 0 0 30px;
          -webkit-transition: all 1s;
          -moz-transition: all 1s;
          -ms-transition: all 1s;
          -o-transition: all 1s;
          transition: all 1s;
      }

      .s-social ul li:hover {
        -webkit-transform: translate(-110px, 0);
        -moz-transform: translate(-110px, 0);
        -ms-transform: translate(-110px, 0);
        -o-transform: translate(-110px, 0);
        transform: translate(-110px, 0);
        background: rgba(173, 178, 177, 0.4);
      }

      .s-social ul li:hover a {
        color: #000;
      }

      .s-social ul li:hover i {
        color: #fff;
        background: #16a085;
      }

      .s-social ul li i {
        margin-right: 10px;
        color: #000;
        background: #fff;
        padding: 10px;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        border-radius: 50%;
        width: 40px;
        height: 40px; 
        font-size: 20px;
        background: #ffffff;
        -webkit-transform: rotate(0deg);
        -moz-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        -o-transform: rotate(0deg);
        transform: rotate(0deg);

      }
      /*footer*/
      .social, .wasiliana {text-align: left;}
      .social .list-item a {font-size: 1.4rem;}
      .social ul {list-style: none;padding-left: 15px;}
      .social ul li {margin-bottom: 5px;}
      .social ul li i {width: 25px;}
    </style>
</head>

<?php
    if(Cookie::get("language") == 'en') {
      $_GET['follow-us'] = 'Follow Us';
      $_GET['contact-us'] = 'Contact Us';
      $_GET['address'] = 'Address';
      $_GET['email-us'] = 'Email Us';
      $_GET['phone-number'] = 'Phone Number';
    } else {
      $_GET['follow-us'] = 'Tufollow';      
      $_GET['contact-us'] = 'Wasiliana Nasi';
      $_GET['address'] = 'Anwani';
      $_GET['email-us'] = 'Barua pepe';
      $_GET['phone-number'] = 'Namba ya Simu';
    }
?>



    <body class="theme-blue">

        <!-- page wrapper start -->

        <div style="display:none"><div id="clear-error"></div></div>
        
        <div class="page-wrapper">
              
            <!-- preloader start -->

            <div id="ht-preloader">
              <div class="loader clear-loader">
                <span></span>
                <p>LevandaPOS</p>
              </div>
            </div>

            <!-- preloader end -->

            <!--header start-->
      


            <!--header end-->

            <!--hero section start-->

            <!-- <section class="position-relative">
              <div id="particles-js"></div>
              <div class="container">
                <div class="row  text-center">
                  <div class="col">
                    <h1>About Us</h1>
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb justify-content-center bg-transparent p-0 m-0">
                        <li class="breadcrumb-item"><a class="text-dark" href="#">Home</a>
                        </li>
                        <li class="breadcrumb-item">Pages</li>
                        <li class="breadcrumb-item">Company</li>
                        <li class="breadcrumb-item active text-primary" aria-current="page">About Us</li>
                      </ol>
                    </nav>
                  </div>
                </div>
              </div>
            </section> -->

            <!--hero section end--> 
            

        @yield('content')
      
        </div>

        <nav class="s-social">
          <ul>
              <!-- <li><a href="ref"><i class="fa fa-facebook"></i><b>Facebook</b></a></li>
              <li><a href="ref"><i class="fa fa-twitter"></i><b>Twitter</b></a></li> -->
              <li><a href="https://wa.me/+255656040073" target="_blank"><i class="fa fa-whatsapp"></i><b>WhatsApp</b></a></li>
              <li><a href="tel:+255656040073" target="_blank"><i class="fa fa-phone"></i><b>Call us</b></a></li>
              <!-- <li><a href="ref"><i class="fa fa-youtube"></i><b>YouTube</b></a></li>
              <li><a href="ref"><i class="fa fa-instagram"></i><b>Instagram</b></a></li> -->
          </ul>
      </nav>

        <footer class="mt-5 px-0 bg-primary position-relative" data-bg-img="" style="margin-bottom:-30px !important">
          <div class="shape-1" style="height: 200px; overflow: hidden;">
            <svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 90%; width: 100%;">
              <path d="M0.00,49.98 C150.00,150.00 271.49,-50.00 500.00,49.98 L500.00,0.00 L0.00,0.00 Z" style="stroke: none; fill: #fff;"></path>
            </svg>
          </div>
          <div class="container">
            <div class="row">
              <div class="col-12 col-md-3 mb-6">
                <div class="subscribe-form bg-warning-soft rounded social">
                  <h2 class="mb-4 text-white"><?php echo $_GET['follow-us']; ?></h2>
                  <!-- <h6 class="text-light">Social Medias</h6> -->
                    <ul class="mb-0">
                      <li class="list-item"><a class="text-light ic-2x" target="_blank" href="https://web.facebook.com/levandapos"><i class="fa fa-facebook"></i> <small>facebook</small></a>
                      </li>
                      <li class="list-item"><a class="text-light ic-2x" target="_blank" href="https://www.instagram.com/levanda_pos/"><i class="fa fa-instagram"></i> <small>Instagram</small></a>
                      </li>
                      <li class="list-item"><a class="text-light ic-2x" target="_blank" href="https://www.tiktok.com/@levanda_pos"><span class=""><img src="/images/icons/tiktok-white-icon.png" width="20"></span> <small class="pl-1">TikTok</small></a>
                      </li>
                      <li class="list-item"><a class="text-light ic-2x" target="_blank" href="https://wa.me/+255656040073"><i class="fa fa-whatsapp"></i> <small>Whatsapp</small></a>
                      </li>
                    </ul>
                </div>
              </div>
              <div class="col-12 col-md-9">                
                <div class="row wasiliana">
                  <div class="col-12 mb-2">
                    <a class="footer-logo text-white h2 mb-0">
                      <?php echo $_GET['contact-us']; ?>
                    </a>
                  </div>
                  <div class="col-md-4 col-12 w-address">
                    <div class="row">
                      <div class="col-md-12 col-2 mt-5">
                        <svg class="feather feather-map-pin" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                      </div>
                      <div class="col-md-12 col-10 mt-5">
                        <h4 style="color:#f94f15"><b><?php echo $_GET['address']; ?></b></h4>
                        <span class="text-light">Sinza Palestina, Dar es salaam, Tanzania</span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 col-12">
                    <div class="row">
                      <div class="col-md-12 col-2 mt-5">
                        <svg class="feather feather-mail" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                      </div>
                      <div class="col-md-12 col-10 mt-5">
                        <h4 style="color:#f94f15"><b><?php echo $_GET['email-us']; ?></b></h4>
                        <a class="text-light" href="mailto:customercare@levanda.co.tz"> customercare@levanda.co.tz</a>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 col-12">
                    <div class="row">
                      <div  class="col-md-12 col-2 mt-5">
                        <svg class="feather feather-phone-call" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M15.05 5A5 5 0 0 1 19 8.95M15.05 1A9 9 0 0 1 23 8.94m-1 7.98v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                      </div>
                      <div class="col-md-12 col-10 mt-5">
                        <h4 style="color:#f94f15"><b><?php echo $_GET['phone-number']; ?></b></h4>
                        <a class="text-light" href="tel:+255656040073">+255 656 040 073</a>
                      </div>
                    </div>
                  </div>
                  <div class="col-12" style="margin-top:100px">
                    <a class="footer-logo text-white h2 mb-0" href="/">
                      <!-- Levanda<span class="font-weight-bold"> POS.</span> -->
                      <img src="/images/logo_pos_white.png" width="150" alt="">
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <div class="row text-white text-center mt-8">
              <div class="col" align="right" style="z-index:99999">
                <hr class="mb-8">
                  Copyright &copy; <?php echo date('Y'); ?> 
                  <!-- <u><a class="text-white" href="https://levanda.co.tz/">Levanda</a></u> | All Rights Reserved -->
                  <a class="text-white pl-3" href="/privacy-policy">Privacy Policy</a>
                </div>
            </div>
          </div>
        </footer>

        <!-- page wrapper end -->

        <!--back-to-top start-->

        <div class="scroll-top" style="display:none"><a class="smoothscroll" href="#top"><i class="fa fa-angle-up"></i></a></div>

        <!--back-to-top end-->

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
 

    <script type="text/javascript">   

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



      // lang change
      $(document).on('click', '.lang-blc', function(e){ 
          $('.lang-drop').css('display','block');
      });
      $(document).on('click', '.switch-lang', function(e){ 
          var lang = $(this).attr('check');
          $.get('/switch-lang/'+lang, function(data){
              location.reload();
          });
      });

      $(document).mouseup(function(e) {
          var container = $(".height");

          // if the target of the click isn't the container nor a descendant of the container
          if (!container.is(e.target) && container.has(e.target).length === 0) 
          {
              $('.lang-drop').hide();
          }
      });
    </script>
    
    <!-- start PWA -->
    <script src="{{ asset('/sw.js') }}"></script>
    <script>
       if ("serviceWorker" in navigator) {
          // Register a service worker hosted at the root of the
          // site using the default scope.
          navigator.serviceWorker.register("/sw.js").then(
          (registration) => {
             console.log("Service worker registration succeeded:", registration);
          },
          (error) => {
             console.error(`Service worker registration failed: ${error}`);
          },
        );
      } else {
         console.error("Service workers are not supported.");
      }

      // save installation records      
      window.onappinstalled = function() { 
        $.get('/count-installation', function(data) {
          console.log('Thank you for installing our app!'); 
        });
      };
      
    </script>
    <!-- end PWA -->

    @yield('js')

  </body>
</html>
