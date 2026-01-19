
@extends('layouts.appweb')

<?php
    if(Cookie::get("language") == 'en') {
        $_GET['anyone-can-work-with'] = 'Anyone can <b>work</b> with <b>Levanda POS</b> as an <b>Agent</b> and earn <b>money</b> easily';
        $_GET['register-now'] = 'Register Now';
        $_GET['is-a-software-which'] = 'Is a digital system which helps business owner to operate their business digitally by using electronic devices like smartphone, tablet, or computer. Keeping records of products, sales, profits, loss, expenses, customers, debts records e.t.c';
        $_GET['qualifications'] = 'Qualifications';
        $_GET['qualifications-intro'] = 'In order to be Levanda POS Agent, you must have below qualifications';
        $_GET['good-customer-care'] = 'Good Customer Care';
        $_GET['good-customer-care-info'] = 'Agent should have good customer care to clients since he/she is representing Levanda Company.';
        $_GET['digital-skills'] = 'Digital Skills';
        $_GET['digital-skills-info'] = 'Levanda POS Agent must know the importance of using digital ways of running business than using manual or analogy ways.';
        $_GET['agent-has-to-do'] = 'What <span class="text-primary">Levanda POS Agent</span> has to do in order to earn money';
        $_GET['learn-lp'] = 'Learn Levanda POS';
        $_GET['learn-lp-info'] = 'Agent must know in details how Levanda POS works which will help him/her to demonstrate it to clients (business owners).';
        $_GET['find-clients'] = 'Find Clients';
        $_GET['find-clients-info'] = 'Find business owners then explain and convince them to use Levanda POS on their shops.';
        $_GET['get-paid'] = 'Get Paid';
        $_GET['get-paid-info'] = 'You will get paid your commission every time the business owner pays for using Levanda POS.';
        $_GET['how-much-can'] = '<span class="text-primary">How much</span> can Levanda POS Agent earn';
        $_GET['there-is-no-limit'] = 'There is no limit on Agent commission';
        $_GET['the-more-you-register'] = 'The more you register clients the more you earn';
        $_GET['with-100-clients'] = 'With 100 active clients, an Agent can earn up to <b class="text-primary">300,000 TZS</b> every month as a commission.';
        $_GET['are-you-interested'] = 'Are you <br> <b class="text-primary">Interested</b>';
        $_GET['join-today'] = '<b class="text-primary">Join today</b>, and start working with us.';
        $_GET['click-here-to'] = 'CLICK HERE TO REGISTER';
        $_GET['want-to-know-more'] = 'Want to know more';
        $_GET['call-us'] = 'Call us';
        $_GET['chat-whatsapp'] = 'Chat WhatSapp';
        $_GET['visit-website'] = 'Visit website';
        $_GET['come-to-our-offices'] = 'Come to our offices';
        $_GET['meet-us-by-appointment'] = 'Meet us by Appointment at our offices located in Magomeni, DSM and Mnazi mmoja, DSM';
      } else {
        $_GET['anyone-can-work-with'] = 'Mtu yeyote anaweza kuwa <b>wakala</b> wa <b>Levanda POS</b> na kujipatia <b>pesa</b> kirahisi';
        $_GET['register-now'] = 'Jisajili Sasa';
        $_GET['is-a-software-which'] = 'Ni mfumo wa kidijitali unaomsaidia mfanyabiashara kuendesha biashara yake kisasa kwa kutumia kifaa cha kielektroniki kama simu janja, tablet, au kompyuta. Kutunza rekodi na kutoa ripoti za bidhaa, mauzo, faida, hasara, matumizi, wateja, madeni n.k';
        $_GET['qualifications'] = 'Vigezo';
        $_GET['qualifications-intro'] = 'Ili uweze kuwa Wakala wa Levanda POS, unatakiwa kuwa na sifa zifuatazo';
        $_GET['good-customer-care'] = 'Huduma nzuri kwa Wateja';
        $_GET['good-customer-care-info'] = 'Wakala anatakiwa kutoa huduma nzuri kwa wateja kwa sababu anaiwakilisha kampuni ya Levanda.';
        $_GET['digital-skills'] = 'Ujuzi wa Kidijitali';
        $_GET['digital-skills-info'] = 'Wakala anatakiwa kujua faida za kuendesha biashara kidijitali ukilinganisha na kutumia njia za jadi/kizamani.';
        $_GET['agent-has-to-do'] = '<span class="text-primary">Levanda POS Wakala</span> anatakiwa kufanya nini ili kupata pesa';
        $_GET['learn-lp'] = 'Jifunze Levanda POS';
        $_GET['learn-lp-info'] = 'Wakala anatakiwa kujua kiundani jinsi mfumo wa Levanda POS unavyofanya kazi ili imrahisishie kuwaelezea wateja (wafanyabiashara)';
        $_GET['find-clients'] = 'Tafuta Wateja';
        $_GET['find-clients-info'] = 'Tafuta wafanyabiashara uwaelezee na kuwashawishi kutumia mfumo wa Levanda POS kwenye biashara zao.';
        $_GET['get-paid'] = 'Pata Malipo';
        $_GET['get-paid-info'] = 'Utapata malipo yako ya uwakala kila mara mfanyabiashara anatakapolipia kutumia Levanda POS.';
        $_GET['how-much-can'] = '<span class="text-primary">Kiasi gani</span> wakala wa Levanda POS anaweza kupata';
        $_GET['there-is-no-limit'] = 'Hakuna kikomo kwenye malipo ya uwakala';
        $_GET['the-more-you-register'] = 'Jinsi unavosajili wateja wengi ndivyo utakavyolipwa zaidi';
        $_GET['with-100-clients'] = 'Kwa wateja hai 100, Wakala anaweza kulipwa mpaka <b class="text-primary">TZS 300,000</b> kila mwezi.';
        $_GET['are-you-interested'] = '<b class="text-primary">Umevutiwa</b>';
        $_GET['join-today'] = '<b class="text-primary">Jiunge leo</b>, na anza kufanya kazi nasi.';
        $_GET['click-here-to'] = 'BONYEZA HAPA KUJISAJILI';
        $_GET['want-to-know-more'] = 'Unataka kujua zaidi';
        $_GET['call-us'] = 'Tupigie';
        $_GET['chat-whatsapp'] = 'Tuchati WhatSapp';
        $_GET['visit-website'] = 'Tembelea website';
        $_GET['come-to-our-offices'] = 'Fika ofisini kwetu';
        $_GET['meet-us-by-appointment'] = 'Weka miadi ya kuonana nasi ofisini kwetu Magomeni, DSM au Mnazi mmoja, DSM';
      }
?>

@section('css')
  <style type="text/css">
    section {margin-bottom: 100px;}
    .top-banner {width: 100%;}
    .top-banner img {width: inherit;}
    .pos-img {width: 100%;}
    .pos-img img {width: inherit;}
    .left-pos {width: 100%;}
    .left-pos img {width: inherit;}
    
    .agent-r .agent-r-i {
      line-height: 1.3;
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      /* border-left: 3px solid #D9D9D9; */
    }
    @media screen and (max-width: 1200px) {        
        #left-sidebar.sidebar {margin-top: -50px !important;}
    }
    @media screen and (max-width: 767px) {
      .agent-r {margin-top: 80px;margin-bottom: 60px;}
      .agent-r .agent-r-i {margin-left: 15px;}
      section .mb-8 {margin-bottom: 50px;}
    }
    
    @media screen and (min-width: 521px) {
      section.top-section-1 .row {display: none;}
    }
    @media screen and (max-width: 520px) {
      #left-sidebar.sidebar {margin-top: -20px !important;}
      section.top-section-1 {margin-top: 60px;margin-bottom: 20px;}
      section.top-section-1 .row {margin: 0px;padding: 0px;}
      section.top-section-1 .col-6 div::before {
        transform: translateX(-50%);
        border-radius: 100%;
        position: absolute;
        background: blue;
        bottom: -6px;
        height: 6px;
        content: '';
        width: 6px;
        left: 40%;
      }
    }
    @media screen and (max-width: 450px) {
      .interested .pt-3 {padding-left: 0px;padding-right: 0px;}
    }
    @media screen and (max-width: 400px) {      
      section.top-section-1 {margin-top: 35px !important;margin-bottom: 25px !important;}
      .qualification h4 {font-size: 1.3rem;}
      .know-more .left {padding-left: 0px;padding-right: 0px;}
    }
    @media screen and (max-width: 387px) {
      .interested h2 {font-size: 1.8rem;}
      .know-more h2 {font-size: 1.9rem;}
    }
  </style>
@endsection
@section('content')
  <div id="wrapper">
    <nav class="navbar navbar-fixed-top shadow">
        <div class="container">
            @include('website.layouts.topbar')
        </div>
    </nav>
    
    <div id="left-sidebar" class="sidebar">
      <div class="sidebar-scroll"> 
          @include('website.layouts.leftside')
      </div>
    </div>
    
    <section class="py-0 top-section-1">
      <div class="row">
        <div class="col-6" align="center">
            <a href="/">Levanda POS</a>
        </div>
        <div class="col-6">
            <div><a href="">Levanda POS Agent</a></div>
        </div>
      </div>
    </section>
    
    <section class="mt-0 pt-0" style="margin-bottom: 70px;">
      <div class="container">
        <div class="row">
          <div class="col-md-6 pos-img"><img src="/images/banners/agent2.png" alt=""></div>
          <div class="col-md-5 offset-md-1 agent-r pl-0">
            <div class="agent-r-i">
              <h3 class="py-2"><?php echo $_GET['anyone-can-work-with']; ?></h3>
              <div><a href="/agent-registration" class="btn btn-primary" style="font-size: 1.2rem;font-weight: bold;"><?php echo $_GET['register-now']; ?></a></div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    <section>
      <div class="container">
        <div class="row align-items-center justify-content-between">
          <div class="col-12 col-md-6 mb-8">
            <div class="fa-3x"> <span class="badge badge-primary p-1 px-2">
                    <i class="fa fa-crosshairs fa-spin"></i>
                  </span>
              <h2 class="mt-3">Levanda POS</h2>
              <p class="lead mb-0"><?php echo $_GET['is-a-software-which']; ?></p>
            </div> 
          </div>
          <div class="col-12 col-md-6 col-xl-5 order-lg-1">
            <div class="left-pos">
              <img src="/images/pos.png" alt="">
            </div>
          </div>
        </div>
      </div>
    </section>

    <section>
      <div class="container-fluid py-5 bg-primary">
        <div class="row qualification align-items-center text-white">
          <div class="col-md-4 offset-md-1 mb-5">
            <div>
                <h2 class="mt-2"><?php echo $_GET['qualifications']; ?></h2><hr>
                <h4 class="mb-0"><?php echo $_GET['qualifications-intro']; ?>:</h4>
            </div>
            <!-- <a href="#" class="btn btn-outline-primary mt-5">
                    Learn More
                  </a> -->
          </div>
          <div class="col-md-5 offset-md-1 mb-4 mb-lg-0 order-lg-1">
            <div class="row align-items-center justify-content-between">
                  <div class="col-md-12 mb-5">
                    <div class="d-flex p-4 bg-white shadow">
                      <div class="mr-3">
                        <svg height="50px" width="50px" version="1.1" id="Layer_1" viewBox="0 0 496.158 496.158" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path style="fill:#F26F21;" d="M248.082,0.003C111.07,0.003,0,111.061,0,248.085c0,137,111.07,248.07,248.082,248.07 c137.006,0,248.076-111.07,248.076-248.07C496.158,111.061,385.088,0.003,248.082,0.003z"></path> <path style="fill:#FFFFFF;" d="M278.767,145.419c-3.126-4.003-7.276-6.006-12.451-6.006c-4.591,0-7.716,0.879-9.375,2.637 c-1.662,1.758-5.226,6.445-10.693,14.063c-5.47,7.617-11.744,14.502-18.823,20.654c-7.082,6.152-16.53,12.012-28.345,17.578 c-7.91,3.712-13.429,6.738-16.553,9.082c-3.126,2.344-4.688,6.006-4.688,10.986c0,4.298,1.586,8.082,4.761,11.353 c3.172,3.273,6.812,4.907,10.913,4.907c8.592,0,25.292-9.521,50.098-28.564V335.41c0,7.814,1.806,13.722,5.42,17.725 c3.612,4.003,8.397,6.006,14.355,6.006c13.378,0,20.068-9.814,20.068-29.443V161.972 C283.455,154.941,281.892,149.425,278.767,145.419z"></path> </g></svg>
                      </div>
                      <div>
                        <h5 class="mb-2 text-primary"><?php echo $_GET['good-customer-care']; ?></h5>
                        <p class="mb-0 text-dark"><?php echo $_GET['good-customer-care-info']; ?></p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="d-flex p-4 bg-white shadow">
                      <div class="mr-3">
                        <svg height="50px" width="50px" version="1.1" id="Layer_1" viewBox="0 0 496.158 496.158" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path style="fill:#F26F21;" d="M248.082,0.003C111.07,0.003,0,111.061,0,248.085c0,137,111.07,248.07,248.082,248.07 c137.006,0,248.076-111.07,248.076-248.07C496.158,111.061,385.088,0.003,248.082,0.003z"></path> <path style="fill:#FFFFFF;" d="M319.783,325.595c-4.005-3.124-9.814-4.688-17.432-4.688h-76.465c2.44-3.71,4.834-6.885,7.178-9.521 c5.468-6.64,15.55-15.967,30.249-27.979c14.696-12.012,25.17-20.824,31.421-26.44c6.249-5.614,12.378-13.378,18.384-23.291 c6.006-9.911,9.009-20.922,9.009-33.032c0-7.713-1.442-15.161-4.321-22.339c-2.882-7.178-6.91-13.5-12.085-18.97 c-5.177-5.468-11.183-9.764-18.018-12.891c-10.547-4.688-23.291-7.031-38.232-7.031c-12.403,0-23.218,1.831-32.446,5.493 s-16.846,8.473-22.852,14.429c-6.006,5.958-10.524,12.598-13.55,19.922c-3.028,7.324-4.541,14.355-4.541,21.094 c0,5.566,1.611,9.961,4.834,13.184s7.274,4.834,12.158,4.834c5.566,0,9.789-1.758,12.671-5.273 c2.879-3.516,5.468-8.544,7.764-15.088c2.293-6.542,3.93-10.547,4.907-12.012c7.324-11.229,17.381-16.846,30.176-16.846 c6.054,0,11.646,1.369,16.772,4.102c5.127,2.735,9.178,6.569,12.158,11.499c2.978,4.933,4.468,10.524,4.468,16.772 c0,5.763-1.392,11.646-4.175,17.651s-6.837,11.865-12.158,17.578c-5.324,5.713-11.989,11.403-19.995,17.065 c-4.493,3.028-11.964,9.352-22.412,18.97c-10.451,9.62-22.169,21.167-35.156,34.644c-3.126,3.321-6.006,7.887-8.643,13.696 c-2.637,5.812-3.955,10.474-3.955,13.989c0,5.47,2.051,10.231,6.152,14.282c4.102,4.054,9.814,6.079,17.139,6.079H306.6 c6.445,0,11.254-1.659,14.429-4.98c3.172-3.319,4.761-7.372,4.761-12.158C325.789,332.97,323.786,328.722,319.783,325.595z"></path> </g></svg>
                      </div>
                      <div>
                        <h5 class="mb-2 text-primary"><?php echo $_GET['digital-skills']; ?></h5>
                        <p class="mb-0 text-dark"><?php echo $_GET['digital-skills-info']; ?></p>
                      </div>
                    </div>
                  </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section>
      <div class="container">
        <div class="row align-items-center justify-content-between">
          <div class="col-12 col-lg-5 col-xl-5 mb-8 mb-lg-0 order-lg-1">
            <img src="/images/assets/06.png" alt="Image" class="img-fluid">
          </div>
          <div class="col-12 col-lg-7 col-xl-6">
            <div class="mb-5">
              <h2 class="font-w-6"><?php echo $_GET['agent-has-to-do']; ?>?</h2>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="d-flex mb-5">
                  <div class="mr-3">
                    <svg height="50px" width="50px" version="1.1" id="Layer_1" viewBox="0 0 496.158 496.158" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path style="fill:#F26F21;" d="M248.082,0.003C111.07,0.003,0,111.061,0,248.085c0,137,111.07,248.07,248.082,248.07 c137.006,0,248.076-111.07,248.076-248.07C496.158,111.061,385.088,0.003,248.082,0.003z"></path> <path style="fill:#FFFFFF;" d="M278.767,145.419c-3.126-4.003-7.276-6.006-12.451-6.006c-4.591,0-7.716,0.879-9.375,2.637 c-1.662,1.758-5.226,6.445-10.693,14.063c-5.47,7.617-11.744,14.502-18.823,20.654c-7.082,6.152-16.53,12.012-28.345,17.578 c-7.91,3.712-13.429,6.738-16.553,9.082c-3.126,2.344-4.688,6.006-4.688,10.986c0,4.298,1.586,8.082,4.761,11.353 c3.172,3.273,6.812,4.907,10.913,4.907c8.592,0,25.292-9.521,50.098-28.564V335.41c0,7.814,1.806,13.722,5.42,17.725 c3.612,4.003,8.397,6.006,14.355,6.006c13.378,0,20.068-9.814,20.068-29.443V161.972 C283.455,154.941,281.892,149.425,278.767,145.419z"></path> </g></svg>
                  </div>
                  <div>
                        <!-- <h5 class="mb-2 text-primary">Levanda POS</h5>
                        <p class="mb-0 text-dark">Levanda POS Agent must know how Levanda POS works.</p> -->
                    <h5 class="mb-2 text-primary"><?php echo $_GET['learn-lp']; ?></h5>
                    <p class="mb-0"><?php echo $_GET['learn-lp-info']; ?></p>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="d-flex mb-5">
                  <div class="mr-3">
                    <svg height="50px" width="50px" version="1.1" id="Layer_1" viewBox="0 0 496.158 496.158" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path style="fill:#F26F21;" d="M248.082,0.003C111.07,0.003,0,111.061,0,248.085c0,137,111.07,248.07,248.082,248.07 c137.006,0,248.076-111.07,248.076-248.07C496.158,111.061,385.088,0.003,248.082,0.003z"></path> <path style="fill:#FFFFFF;" d="M319.783,325.595c-4.005-3.124-9.814-4.688-17.432-4.688h-76.465c2.44-3.71,4.834-6.885,7.178-9.521 c5.468-6.64,15.55-15.967,30.249-27.979c14.696-12.012,25.17-20.824,31.421-26.44c6.249-5.614,12.378-13.378,18.384-23.291 c6.006-9.911,9.009-20.922,9.009-33.032c0-7.713-1.442-15.161-4.321-22.339c-2.882-7.178-6.91-13.5-12.085-18.97 c-5.177-5.468-11.183-9.764-18.018-12.891c-10.547-4.688-23.291-7.031-38.232-7.031c-12.403,0-23.218,1.831-32.446,5.493 s-16.846,8.473-22.852,14.429c-6.006,5.958-10.524,12.598-13.55,19.922c-3.028,7.324-4.541,14.355-4.541,21.094 c0,5.566,1.611,9.961,4.834,13.184s7.274,4.834,12.158,4.834c5.566,0,9.789-1.758,12.671-5.273 c2.879-3.516,5.468-8.544,7.764-15.088c2.293-6.542,3.93-10.547,4.907-12.012c7.324-11.229,17.381-16.846,30.176-16.846 c6.054,0,11.646,1.369,16.772,4.102c5.127,2.735,9.178,6.569,12.158,11.499c2.978,4.933,4.468,10.524,4.468,16.772 c0,5.763-1.392,11.646-4.175,17.651s-6.837,11.865-12.158,17.578c-5.324,5.713-11.989,11.403-19.995,17.065 c-4.493,3.028-11.964,9.352-22.412,18.97c-10.451,9.62-22.169,21.167-35.156,34.644c-3.126,3.321-6.006,7.887-8.643,13.696 c-2.637,5.812-3.955,10.474-3.955,13.989c0,5.47,2.051,10.231,6.152,14.282c4.102,4.054,9.814,6.079,17.139,6.079H306.6 c6.445,0,11.254-1.659,14.429-4.98c3.172-3.319,4.761-7.372,4.761-12.158C325.789,332.97,323.786,328.722,319.783,325.595z"></path> </g></svg>
                  </div>
                  <div>
                    <h5 class="mb-2 text-primary"><?php echo $_GET['find-clients']; ?></h5>
                    <p class="mb-0"><?php echo $_GET['find-clients-info']; ?></p>
                  </div>
                </div>
              </div>
              <div class="col-12 mt-6 mt-md-0">
                <div class="d-flex">
                  <div class="mr-3">
                    <svg height="50px" width="50px" version="1.1" id="Layer_1" viewBox="0 0 496.158 496.158" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path style="fill:#F26F21;" d="M248.082,0.003C111.07,0.003,0,111.061,0,248.085c0,137,111.07,248.07,248.082,248.07 c137.006,0,248.076-111.07,248.076-248.07C496.158,111.061,385.088,0.003,248.082,0.003z"></path> <path style="fill:#FFFFFF;" d="M319.637,269.711c-2.637-6.395-6.569-12.231-11.792-17.505c-5.226-5.273-11.646-9.961-19.263-14.063 c7.91-6.64,13.989-13.451,18.237-20.435c4.248-6.981,6.372-15.355,6.372-25.122c0-7.42-1.465-14.355-4.395-20.801 s-7.276-12.108-13.037-16.992c-5.763-4.882-12.55-8.617-20.361-11.206c-7.814-2.586-16.457-3.882-25.928-3.882 c-10.84,0-20.654,1.538-29.443,4.614s-16.139,7.155-22.046,12.231c-5.91,5.079-10.4,10.426-13.477,16.04 c-3.076,5.617-4.614,10.963-4.614,16.04c0,5.273,1.634,9.499,4.907,12.671c3.271,3.175,6.859,4.761,10.767,4.761 c3.319,0,6.249-0.586,8.789-1.758c2.538-1.172,4.296-2.783,5.273-4.834c1.659-3.809,3.49-7.86,5.493-12.158 c2-4.296,4.125-7.812,6.372-10.547c2.245-2.733,5.296-4.93,9.155-6.592c3.856-1.659,8.764-2.49,14.722-2.49 c8.789,0,15.77,2.71,20.947,8.13c5.175,5.42,7.764,11.891,7.764,19.409c0,9.865-3.248,17.432-9.741,22.705 c-6.496,5.273-14.234,7.91-23.218,7.91h-6.006c-6.935,0-12.158,1.442-15.674,4.321c-3.516,2.882-5.273,6.665-5.273,11.353 c0,4.786,1.465,8.521,4.395,11.206c2.93,2.687,7.079,4.028,12.451,4.028c1.172,0,3.809-0.194,7.91-0.586 c4.102-0.389,7.127-0.586,9.082-0.586c11.133,0,19.823,3.248,26.074,9.741c6.249,6.496,9.375,15.454,9.375,26.88 c0,7.716-1.831,14.502-5.493,20.361s-8.302,10.279-13.916,13.257c-5.617,2.98-11.451,4.468-17.505,4.468 c-10.547,0-18.727-3.296-24.536-9.888c-5.812-6.592-11.256-16.674-16.333-30.249c-0.783-2.245-2.442-4.175-4.98-5.786 c-2.541-1.611-5.177-2.417-7.91-2.417c-5.47,0-10.034,1.735-13.696,5.2c-3.662,3.468-5.493,8.034-5.493,13.696 c0,4.395,1.538,9.961,4.614,16.699s7.617,13.257,13.623,19.556s13.646,11.549,22.925,15.747c9.276,4.198,19.775,6.299,31.494,6.299 c11.522,0,22.046-1.831,31.567-5.493s17.748-8.739,24.683-15.234c6.933-6.493,12.181-13.891,15.747-22.192 c3.563-8.299,5.347-16.894,5.347-25.781C323.592,283.018,322.273,276.109,319.637,269.711z"></path> </g></svg>
                  </div>
                  <div>
                    <h5 class="mb-2 text-primary"><?php echo $_GET['get-paid']; ?></h5>
                    <p class="mb-0"><?php echo $_GET['get-paid-info']; ?></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    <section>
      <div class="container">
        <div class="row align-items-center justify-content-between">
          <div class="col-12 col-lg-5 col-xl-5 mb-8 mb-lg-0">
            <img src="/images/assets/agent3.png" alt="Image" class="img-fluid">
          </div>
          <div class="col-12 col-lg-7 col-xl-6">
            <div class="mb-5">
              <h2 class="font-w-6"><?php echo $_GET['how-much-can']; ?>?</h2>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="flex-wrap justify-content-start">
                  <div class="mb-3 ml-lg-0 mr-lg-4">
                    <div class="d-flex align-items-center">
                      <div class="badge-primary-soft rounded p-1">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check">
                          <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                      </div>
                      <p class="mb-0 ml-3"><?php echo $_GET['there-is-no-limit']; ?></p>
                    </div>
                  </div>
                  <div class="mb-3 ml-lg-0 mr-lg-4">
                    <div class="d-flex align-items-center">
                      <div class="badge-primary-soft rounded p-1">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check">
                          <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                      </div>
                      <p class="mb-0 ml-3"><?php echo $_GET['the-more-you-register']; ?></p>
                    </div>
                  </div>
                  <div class="mb-3 ml-lg-0 mr-lg-4">
                    <div class="d-flex align-items-center">
                      <div class="badge-primary-soft rounded p-1">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check">
                          <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>                        
                      </div>
                      <p class="mb-0 ml-3"><?php echo $_GET['with-100-clients']; ?> </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    <section>
      <div class="container">
        <div class="row align-items-center justify-content-between">
          <div class="col-md-6 mb-5">
            <div class="shadow p-4" align="center">
              <div class="row interested">
                <div class="col-6 pt-3" align="left"><h2><?php echo $_GET['are-you-interested']; ?> ?</h2></div>
                <div class="col-6">
                  <div><img src="/images/assets/happy-icon.png" width="150" alt=""></div>
                </div>
              </div>              
              <hr>
              <h3 class="mt-4"><?php echo $_GET['join-today']; ?></h3>
              <div class="mt-4"><a href="/agent-registration" class="btn btn-primary" style="font-size: 1rem;"><?php echo $_GET['click-here-to']; ?></a></div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="shadow know-more p-4">
              <h2><?php echo $_GET['want-to-know-more']; ?> ?</h2><hr>
              <div class="row mt-4">
                <div class="col-5 left" align="right">
                  <p><?php echo $_GET['call-us']; ?>: </p>
                  <p><?php echo $_GET['chat-whatsapp']; ?>: </p>
                  <p><?php echo $_GET['visit-website']; ?>: </p>
                  <p><?php echo $_GET['come-to-our-offices']; ?>: </p>
                </div>
                <div class="col-7">
                  <p><a href="tel:+255656040073"><i class="fa fa-phone"></i> +255-656-040-073</a></p>
                  <p><a target="_blank" href="https://wa.me/+255656040073"><i class="fa fa-whatsapp"></i> Whatsapp</a></p>
                  <p><a href="/">pos.levanda.co.tz</a></p>
                  <p><?php echo $_GET['meet-us-by-appointment']; ?></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section style="display: none;">
      <div class="container-fluid">
        <div class="row align-items-center justify-content-between">
          <div class="col-md-5 offset-md-1 mb-5">
            <div class="d-flex">
              <div class="fa-3x" style="display: none;"> <span class="badge badge-primary-soft p-2">
                    <i class="fa fa-certificate fa-spin"></i>
                    </span>
              </div> 
              <div class="pl-3" style="border-left: 3px solid #D9D9D9;">
                <h2 class="mt-2"><span class="text-primary">How much</span> can Levanda POS Agent earn</h2>
                <p class="lead mb-0">In order to be Levanda POS Agent, you must have below qualifications:</p>
              </div>
            </div>
            <!-- <a href="#" class="btn btn-outline-primary mt-5">
                    Learn More
                  </a> -->
          </div>
          <div class="col-10 offset-md-1 mb-8 mb-lg-0 order-lg-1">
            <div class="row">
              <div class="col-md-6">
                <div class="d-flex mb-5">
                  <div class="mr-3">
                    <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#003D8F" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square">
                      <polyline points="9 11 12 14 22 4"></polyline>
                      <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                    </svg>
                  </div>
                  <div>
                    <h5 class="mb-2 text-primary">Levanda POS</h5>
                    <p class="mb-0">Levanda POS Agent must know how Levanda POS works.</p>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="d-flex justify-content-between">
                  <div class="mr-3">
                    <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#003D8F" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-wifi">
                      <path d="M5 12.55a11 11 0 0 1 14.08 0"></path>
                      <path d="M1.42 9a16 16 0 0 1 21.16 0"></path>
                      <path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path>
                      <line x1="12" y1="20" x2="12" y2="20"></line>
                    </svg>
                  </div>
                  <div>
                    <h5 class="mb-2 text-primary">Digital skills</h5>
                    <p class="mb-0">Levanda POS Agent must know the importance of using digital ways of running business than using manual or analogy ways.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

  </div>

@endsection


@section('js')
<script type="text/javascript">

</script>
@endsection 