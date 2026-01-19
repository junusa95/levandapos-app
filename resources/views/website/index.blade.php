
@extends('layouts.appweb')

<?php
    if(Cookie::get("language") == 'en') {
        $_GET['how-to-use'] = 'How to use Levanda POS';
        $_GET['value-your-business'] = 'Value your Business by giving it a <span class="text-primary">Levanda POS</span>';
        $_GET['this-system-will-help'] = 'This system will help you to track the steps of your business, increase and decrease of revenue.';
        $_GET['register-for-free'] = 'Register for Free';
        $_GET['what-is-levanda-pos'] = 'What is Levanda POS';
        $_GET['is-a-software-which'] = 'Is a digital system which helps business owners to operate their business digitally by using electronic devices like smartphone, tablet, or computer. Keeping records of products, sales, profits, loss, expenses, customers, debts records e.t.c';
        $_GET['importance-of-using-lp'] = 'Importance of using Levanda POS';
        $_GET['it-saves-time'] = 'It saves Time';
        $_GET['it-saves-time-desc'] = 'You dont need to waste time calculating Sales, Profit, Expenses, Stock e.t.c in your business, Levanda POS can do all that in a second by clicking a button.';
        $_GET['easy-to-use'] = 'Easy to Use';
        $_GET['easy-to-use-desc'] = 'You dont need to have a high level of education in order to use Levanda POS. You just need to know how to read and write.';
        $_GET['security-of-data'] = 'Security of Data';
        $_GET['security-of-data-desc'] = 'It is safe to store your data in system than storing in papers. In system, your data will stay forever and confidential.';
        $_GET['all-your-businesses-in-one'] = 'All your Businesses in One Account';
        $_GET['all-your-businesses-in-one-desc'] = 'You dont need to create multiple accounts to manage all your shops. Create one account in Levanda POS then you can manage all your shops and stores inside it.';
        $_GET['wherever-you-are'] = 'Wherever you are, At any time';
        $_GET['wherever-you-are-desc'] = 'You can see all the updates in your business even if you are far from your business area.';
        $_GET['daily-updates'] = 'Daily updates';
        $_GET['daily-updates-desc'] = 'You will receive SMS report everyday with details about Sales, Profit, Expenses and Products of your shop.';
        $_GET['lp-will-help-you-to-know'] = 'Levanda POS will help you to know';
        $_GET['sales-profit-expenses'] = 'Sales, Profit and Expenses in your business';
        $_GET['increase-decrease-of-products'] = 'Increase and Decrease of product\'s quantity';
        $_GET['customer-records'] = 'Customer details that i owe them or they owe me and keeping records of debts payments';
        $_GET['payments-installments'] = 'Payments installments incase your business allows customers to pay little by little';
        $_GET['transfer-records'] = 'Transfer details of items from one shop/store to another shop/store';
        $_GET['subscription-fees'] = 'Subscription Fees';
        $_GET['subscription-fees-desc'] = 'We are charging very fair and affordable price. First month is <b style="color:#F26F21;">FREE</b>';
        $_GET['month'] = 'Month'; $_GET['three-months'] = '3 Months'; $_GET['six-months'] = '6 Months'; $_GET['year'] = 'Year';
        $_GET['per-each-shop'] = 'Per each shop';
        $_GET['save'] = 'Save'; $_GET['accounts'] = 'Accounts'; $_GET['shops-stores'] = 'Shops/Stores'; $_GET['users'] = 'Users';
        $_GET['customers'] = 'Customers';
        $_GET['join-us-today'] = 'Join us today! We can help your Business to become more Successful';
    } else {
      $_GET['how-to-use'] = 'Jinsi ya kutumia Levanda POS';
      $_GET['value-your-business'] = 'Ithamini biashara yako kwa kuipatia <span class="text-primary">Levanda POS</span>';
      $_GET['this-system-will-help'] = 'Mfumo huu utakusaidia kufuatilia hatua za biashara yako, ukuaji na ushukaji wa mapato.';
      $_GET['register-for-free'] = 'Jisajili Bure';
      $_GET['what-is-levanda-pos'] = 'Levanda POS ni nini';
      $_GET['is-a-software-which'] = 'Ni mfumo wa kidijitali unaomsaidia mfanyabiashara kuendesha biashara yake kisasa kwa kutumia kifaa cha kielektroniki kama simu janja, tablet, au kompyuta. Kutunza rekodi na kutoa ripoti za bidhaa, mauzo, faida, hasara, matumizi, wateja, madeni n.k';
      $_GET['importance-of-using-lp'] = 'Faida za kutumia Levanda POS';
      $_GET['it-saves-time'] = 'Inaokoa Muda';
      $_GET['it-saves-time-desc'] = 'Hauhitaji kupoteza muda kufanya mahesabu ya Mauzo, Faida, Matumizi, Bidhaa n.k kwenye Biashara yako, Levanda POS itakufanyia ndani ya sekunde kwa kubonyeza kitufe.';
      $_GET['easy-to-use'] = 'Ni rahisi kutumia';
      $_GET['easy-to-use-desc'] = 'Hauhitaji kuwa na Elimu ya juu ili kutumia Levanda POS. Unahitaji kujua kusoma na kuandika tu.';
      $_GET['security-of-data'] = 'Usalama wa Taarifa';
      $_GET['security-of-data-desc'] = 'Ni salama kutunza taarifa zako kwenye mfumo kuliko kwenye makarasi. Kwenye mfumo, taarifa zako zitakaa milele na kwa siri.';
      $_GET['all-your-businesses-in-one'] = 'Biashara zako zote ndani ya Akaunti moja';
      $_GET['all-your-businesses-in-one-desc'] = 'Hauhitaji kuwa na akaunti nyingi kuendesha biashara zako. Fungua akaunti moja ndani ya Levanda POS kisha endesha biashara zako zote ndani yake.';
      $_GET['wherever-you-are'] = 'Popote pale ulipo, Wakati wowote';
      $_GET['wherever-you-are-desc'] = 'Unaweza kujua kila kinachoendelea kwenye biashara yako hata kama upo mbali na biashara yako.';
      $_GET['daily-updates'] = 'Taarifa za Kila siku';
      $_GET['daily-updates-desc'] = 'Utapokea ujumbe mfupi SMS kila siku unaoonesha taarifa ya Mauzo, Faida, Matumizi na Bidhaa za dukani kwako.';
      $_GET['lp-will-help-you-to-know'] = 'Levanda POS itakusaidia kujua';
      $_GET['sales-profit-expenses'] = 'Mapato, faida na matumizi kwenye biashara yako';
      $_GET['increase-decrease-of-products'] = 'Uongezekaji na upunguaji wa idadi za bidhaa';
      $_GET['customer-records'] = 'Taarifa za wateja wako unaowadai na wanaokudai na rekodi zote za malipo ya madeni';
      $_GET['payments-installments'] = 'Marejesho ya malipo (Installments) kama biashara yako inaruhusu wateja kulipia kidogo kidogo';
      $_GET['transfer-records'] = 'Taarifa za uhamishwaji wa bidhaa kutoka duka/stoo moja kwenda duka/stoo ingine';
      $_GET['subscription-fees'] = 'Gharama za kutumia Mfumo';
      $_GET['subscription-fees-desc'] = 'Gharama zetu ni nafuu sana. Mwezi wa kwanza ni <b style="color:#F26F21;">BURE</b>';
      $_GET['month'] = 'Mwezi'; $_GET['three-months'] = 'Miezi 3'; $_GET['six-months'] = 'Miezi 6'; $_GET['year'] = 'Mwaka';
      $_GET['per-each-shop'] = 'Kwa kila duka';
      $_GET['save'] = 'Okoa'; $_GET['accounts'] = 'Akaunti'; $_GET['shops-stores'] = 'Maduka/Stoo'; $_GET['users'] = 'Watumiaji';
      $_GET['customers'] = 'Wateja';
      $_GET['join-us-today'] = 'Jiunge nasi leo! Tuisaidie biashara yako kupata mafanikio zaidi';
    }
?>
@section('css')
<style type="text/css">
  section {margin-top: 70px;}
  section.top-section {margin-top: 40px;}
  .mwongozo-row {margin-top:-15px}
  .mwongozo-desc {margin-top: 20px;}
  .mwongozo-desc .youtube {margin-top: 10px;margin-left: 15px;}
  .mwongozo-desc .youtube iframe {
    width: 350px;height: 500px;
  }
  .top-slider-i .btn {font-size:16px;font-weight:600;}
  /*slider*/
  .slider-col {padding: 0px;}
  #slider {
    position: relative;
    width: 100%;
    overflow: hidden;
  }

  #slider #line {
    height: 5px;
    background: rgba(0,0,0,0.5);
    z-index: 1;
    position: absolute;
    bottom: 0;
    right: 0;
  }

  #slider #dots {
    position: absolute;
    left: 0;
    right: 0;
    bottom: 16px;
    display: flex;
    justify-content: center;
  }

  #slider #dots li {
    transition: 0.3s;
    list-style-type: none;
    width: 12px;
    height: 12px;
    border-radius: 100%;
    background: rgba(0,0,0,0.5);
    margin: 0 0.25em;
    cursor: pointer;
  }

  #slider #dots li:hover,
  #slider #dots li.active {
    background: white;
  }

  @keyframes line {

    0% {width: 0%;}
    100% {width: 100%;}

  }

  #slider #back,
  #slider #forword {
    width: 6%;
    display: flex;
    justify-content: center;
    align-items: center;
    opacity: 0;
    transition: 0.3s;
    cursor: pointer;
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    color: white;
    font-weight: 700;
      font-size: 2rem;
    background: -moz-linear-gradient(left,  rgba(255,255,255,0.75) 0%, rgba(255,255,255,0) 100%);
    background: -webkit-linear-gradient(left,  rgba(255,255,255,0.75) 0%,rgba(255,255,255,0) 100%);
    background: linear-gradient(to right,  rgba(255,255,255,0.75) 0%,rgba(255,255,255,0) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#bfffffff', endColorstr='#00ffffff',GradientType=1 );
  }

  #slider #forword {
    left: auto;
    right: 0;
    background: -moz-linear-gradient(left,  rgba(255,255,255,0) 0%, rgba(255,255,255,0.75) 100%);
    background: -webkit-linear-gradient(left,  rgba(255,255,255,0) 0%,rgba(255,255,255,0.75) 100%);
    background: linear-gradient(to right,  rgba(255,255,255,0) 0%,rgba(255,255,255,0.75) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00ffffff', endColorstr='#bfffffff',GradientType=1 );
  }

  #slider:hover #back,
  #slider:hover #forword {
    opacity: 0.7;
  }

  ul#move {
    margin: 0;
    padding: 0;
    display: flex;
    width: 100%;
    background: #fff;
    margin-right: 100%;
  }


  ul#move li {
    transition: 0.6s;
    min-width: 100%;
    color: white;
    list-style-type: none;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  ul#move li img {
    width: 100%;
  }

  ul#move li:nth-child(1) {
    background: #fff;
  }

  ul#move li:nth-child(2) {
    background: #fff;
  }

  ul#move li:nth-child(3) {
    background: #fff;
  }

  ul#move li:nth-child(4) {
    background: #fff;
  }

  ul#move li:nth-child(5) {
    background: #fff;
  }
  #slider, ul#move, ul#move li, ul#move li img {
    border-radius: 10px;
  }
  .top-slider .card-body img {
    border-radius: 10px;
  }
  /*end slider*/

  /*typed words*/
  @keyframes cursor {
    from, to {
      border-color: transparent;
    }
    50% {
      border-color: black;
    }
  }
  @keyframes typing {
    from {
      width: 100%;
    }
    90%, to {
      width: 0;
    }
  }
  @keyframes slide {
    33.3333333333% {
      font-size: 1.5rem;
      /*letter-spacing: 3px;*/
    }
    to {
      font-size: 0;
      letter-spacing: 0;
    }
  }
  .typing-slider {
    display: inline-block;
    /*font-family: Consolas, monospace;
    font-weight: bold;
    text-align: center;
    white-space: nowrap;*/
  }

  .typing-slider p {
    position: relative;
    display: inline;
    font-size: 0;
    /*text-transform: uppercase;*/
    letter-spacing: 0;
    animation: slide 15s step-start infinite;
  }

  .typing-slider p::after {
    content: "";
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    border-left: 3px solid black;
    background-color: #007bff;
    animation: typing 5s infinite, cursor 1s infinite;
  }

  .typing-slider p:nth-child(1) {
    animation-delay: 0s;
  }
  .typing-slider p:nth-child(1)::after {
    animation-delay: 0s;
    animation-timing-function: steps(16), step-end;
  }

  .typing-slider p:nth-child(2) {
    animation-delay: 5s;
  }
  .typing-slider p:nth-child(2)::after {
    animation-delay: 5s;
    animation-timing-function: steps(23), step-end;
  }

  .typing-slider p:nth-child(3) {
    animation-delay: 10s;
  }
  .typing-slider p:nth-child(3)::after {
    animation-delay: 10s;
    animation-timing-function: steps(12), step-end;
  }
  /*end typed words*/


  /* popup play video button  */
  .play-v-block {
    position: relative; height: 100px;
  }
  .play-v-block .btn {
    position: absolute;margin-left: 100px;margin-top: 35px;
  }
  .custom-play-btn {font-size: 1rem;padding-top: .450rem;padding-bottom: .450rem;font-weight: bold;}
  .video-play-button {
    position: absolute;
    z-index: 10;
    top: 55%;
    left: 10%;
    transform: translateX(-50%) translateY(-50%);
    box-sizing: content-box;
    display: block;
    width: 15px;
    height: 12px;
    background: #f94f15;
    border-radius: 50%;
    padding: 9px 24px 18px 28px;
}
.video-play-button:before {
    content: "";
    position: absolute;
    z-index: 0;
    left: 50%;
    top: 50%;
    transform: translateX(-50%) translateY(-50%);
    display: block;
    width: 75px;
    height: 75px;
    background: #f94f15;
    border-radius: 50%;
    animation: pulse-border 1500ms ease-out infinite;
}

.video-play-button:after {
    content: "";
    position: absolute;
    z-index: 1;
    left: 50%;
    top: 50%;
    transform: translateX(-50%) translateY(-50%);
    display: block;
    width: 70px;
    height: 70px;
    background: #f94f15;
    border-radius: 50%;
    transition: all 200ms;
    border: solid 4px #fff;
}


.video-play-button span {
    display: block;
    position: relative;
    z-index: 3;
    width: 0;
    height: 0;
    border-left: 18px solid #fff;
    border-top: 10px solid transparent;
    border-bottom: 12px solid transparent;
}

@keyframes pulse-border {
  0% {
    transform: translateX(-50%) translateY(-50%) translateZ(0) scale(1);
    opacity: 1;
  }
  100% {
    transform: translateX(-50%) translateY(-50%) translateZ(0) scale(1.5);
    opacity: 0;
  }
}
/* end popup play video  */

  @media screen and (max-width: 991px) {
    .top-title h1 {font-size: 2rem !important;}
    .kujua {
      margin-top: 60px;
    }
    .miez-6 {
      box-shadow: 0 10px 55px 5px rgb(137 173 255 / 15%) !important;
    }
    .mwaka {
      box-shadow: none !important;
    }
    .jiunge {
      margin-top: 50px;
    }
    .sec-section {margin-top: 50px;}
  }
  @media screen and (max-width: 767px) {
    .top-left-m h1 {
      font-size: 2rem !important;
    }
    .mwezi, .mwaka {
      box-shadow: 0 10px 55px 5px rgb(137 173 255 / 15%) !important;
    }
    .gharama .mwezi, .gharama .miez-3, .gharama .miez-6 {margin-bottom: 30px;}
    .faida-i { margin-top: 30px; }
    .jiunge-i {
      margin-top: 30px;
    }
  }
  @media screen and (min-width: 521px) {
    section.top-section-1 .row {display: none;}
  }
  @media screen and (max-width: 520px) {
    section.top-section-1 {margin-top: 60px;}
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
      left: 50%;
    }
  }
  @media screen and (max-width: 480px) {
    .lead {font-size: 1.1rem !important;}
    .top-slider-i .btn {font-size:13px;font-weight:500;}
    section {margin-top: 50px;}
  }
  @media screen and (max-width: 435px) {
    .mwongozo-row {margin-top:-30px}
    .mwongozo-desc .youtube {margin-left: 0px;}
    .mwongozo-desc .youtube iframe {
      width: 100%;
    }
  }
  @media screen and (max-width: 400px) {
    section.top-section-1 {margin-top: 35px !important;margin-bottom: 25px !important;}
    .top-slider-i .btn {font-weight:400;padding-left: 5px;padding-right: 5px;}
  }
  @media screen and (max-width: 394px) {
    .play-v-block .btn {margin-left: 90px;}
    .mwongozo-desc {padding-left: 3px;padding-right: 3px;}
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

<!-- <section class="py-0 top-section-1">
  <div class="row">
    <div class="col-6" align="center">
      <div>
        <a href="">Levanda POS</a>
      </div>      
    </div>
    <div class="col-6">
      <a href="/about-levanda-pos-agent">Levanda POS Agent</a>
    </div>
  </div>
</section> -->

<section class="pt-3 mt-5 top-section">
  <div class="container top-section-c">
       
    <div class="row align-items-center">
      <div class="col-12 col-md-6 offset-md-1 order-lg-2 mb-8 mb-lg-0 top-slider">
        <!-- Image -->
        <!-- <img src="web/images/hero/01.png" class="img-fluid" alt="..."> -->        
        <div class="col slider-col">
          <!-- slider -->
          <div id="slider">
            <div id="line">

            </div>
            <ul id="move">
              <li><img src="images/image-gallery/pos.png"></li>              
              <li><img src="web/images/hero/lev2.png"></li>
              <li><img src="web/images/hero/lev3.png"></li>
              <!-- <li><img src="https://i0.wp.com/newreality.co.za/wp-content/uploads/2017/04/blog-title-img-1.jpg"></li> -->
            </ul>
            <div id="back" style="color: #000;">
              <i class="fa fa-angle-left fa-2x"></i>
            </div>
            <div id="forword" style="color: #000;">
              <i class="fa fa-angle-right fa-2x"></i>
            </div>
            <div id="dots">
              
            </div>
            
          </div>
          <!-- end slider -->
        </div>
      </div>
      <div class="col-12 col-md-5 order-lg-1 pb-0 top-title">
        <!-- Heading -->
        <!-- <h5 class="badge badge-primary-soft font-w-6">Ever Created For</h5> -->
        <h1 class="display-5 pt-2">
          <?php echo $_GET['value-your-business']; ?>            
        </h1> 
        <!-- Text -->
        <p class="lead text-muted"><?php echo $_GET['this-system-will-help']; ?></p>
        <!-- Buttons --> 
        <!-- <a href="#" class="btn btn-primary shadow mr-1">
                Learn More
              </a> -->
                <a href="/new-account" class="btn btn-primary px-4" style="font-size: 1.2rem;">
                  <?php echo $_GET['register-for-free']; ?>
                </a> 
          <div class="play-v-block mt-3">
            <a id="play-video" class="video-play-button" href="https://youtube.com/playlist?list=PLIA0DfELblTwPSLYZ4B1oNpvMIc98jj2w&si=6aicCDClWwz41RU2" target="_blank"> <span></span></a>
            <a href="https://youtube.com/playlist?list=PLIA0DfELblTwPSLYZ4B1oNpvMIc98jj2w&si=6aicCDClWwz41RU2" target="_blank" class="btn btn-outline-orange custom-play-btn">
              <?php echo $_GET['how-to-use']; ?>
            </a>      
          </div>  
      </div>
    </div>
    <!-- / .row -->
  </div>
  <!-- / .container -->
</section>

<section class="sec-section pb-2">
    <div class="container-fluid py-5 bg-primary">
      <div class="row align-items-center text-white">
        <div class="col-md-5 offset-md-1">
          <div class="align-items-center mb-4">
            <div class="mr-3 fa-3x" style="display: inline-block;">
                <span class="badge badge-primary p-1 px-2 text-white">
                    <i class="fa fa-question fa-spin"></i>
                </span>
              <!-- <img class="img-fluid" src="web/images/icon/01.svg" alt=""> -->
            </div>
            <h4 class="m-0" style="display: inline-block;"> <b><?php echo $_GET['what-is-levanda-pos']; ?> ?</b> </h4>
            <div style="display: block;">
              <p class="mt-4 lead"><?php echo $_GET['is-a-software-which']; ?></p>
            </div>                        
          </div>
        </div>
        <div class="col-md-5">
          <div class="mt-2" align="right">
            <div><img src="/images/logo_pos_white.png" width="150" alt=""></div>
            <?php if(Cookie::get("language") == 'en') { ?>
              <h4 style="color:#f94f15">
                <span class="txt-rotate text-white" data-period="2000" data-rotate='[ "Clothing", "Electronics", "Furniture", "Home Decor", "Liqour", "Cosmetics.", "Car Accessories", "Bags & Luggages" ]'></span>
                <span> </span>Shops
              </h4>
            <?php } else { ?>
              <h4 style="color:#f94f15">Maduka ya <span> </span>
                <span class="txt-rotate text-white" data-period="2000" data-rotate='[ "Nguo.", "Electronics.", "Furniture.", "Vyombo.", "Vinywaji.", "Vipodozi.", "Vifaa vya Magari.", "Mabegi." ]'></span>
              </h4>
            <?php } ?>
          </div>
        </div>
      </div>   
    </div>
</section>

<section class="">
  <div class="container">
    <div class="row justify-content-between">
      <div class="col-12 col-md-7 mb-lg-0 order-1 faida-i">
        <div class="d-flex justify-content-between mb-5">
          <div class="mr-3">
            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#1360ef"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="Calendar / Clock"> <path id="Vector" d="M12 7V12H17M12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12C21 16.9706 16.9706 21 12 21Z" stroke="#1360ef" stroke-width="1.08" stroke-linecap="round" stroke-linejoin="round"></path> </g> </g></svg>
          </div>
          <div>
            <h5 class="mb-2"><b><?php echo $_GET['it-saves-time']; ?></b></h5>
            <p class="mb-0"><?php echo $_GET['it-saves-time-desc']; ?></p>
          </div>
        </div>
        <div class="d-flex justify-content-between mb-5">
          <div class="mr-3">
            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#1360ef" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square">
              <polyline points="9 11 12 14 22 4"></polyline>
              <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
            </svg>
          </div>
          <div>
            <h5 class="mb-2"><b><?php echo $_GET['easy-to-use']; ?></b></h5>
            <p class="mb-0"><?php echo $_GET['easy-to-use-desc']; ?></p>
          </div>
        </div>
        <div class="d-flex justify-content-between mb-5">
          <div class="mr-3">
            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#1360ef"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="File / Cloud_Check"> <path id="Vector" d="M15 11L11 15L9 13M23 15C23 12.7909 21.2091 11 19 11C18.9764 11 18.9532 11.0002 18.9297 11.0006C18.4447 7.60802 15.5267 5 12 5C9.20335 5 6.79019 6.64004 5.66895 9.01082C3.06206 9.18144 1 11.3498 1 13.9999C1 16.7613 3.23858 19.0001 6 19.0001L19 19C21.2091 19 23 17.2091 23 15Z" stroke="#1360ef" stroke-width="1.08" stroke-linecap="round" stroke-linejoin="round"></path> </g> </g></svg>
          </div>
          <div>
            <h5 class="mb-2"><b><?php echo $_GET['security-of-data']; ?></b></h5>
            <p class="mb-0"><?php echo $_GET['security-of-data-desc']; ?></p>
          </div>
        </div>
        <div class="d-flex justify-content-between mb-5">
          <div class="mr-3">
            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#1360ef" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-grid">
              <rect x="3" y="3" width="7" height="7"></rect>
              <rect x="14" y="3" width="7" height="7"></rect>
              <rect x="14" y="14" width="7" height="7"></rect>
              <rect x="3" y="14" width="7" height="7"></rect>
            </svg>
          </div>
          <div>
            <h5 class="mb-2"><b><?php echo $_GET['all-your-businesses-in-one']; ?></b></h5>
            <p class="mb-0"><?php echo $_GET['all-your-businesses-in-one-desc']; ?></p>
          </div>
        </div>
        <div class="d-flex justify-content-between mb-5">
          <div class="mr-3">
            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#1360ef" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-wifi">
              <path d="M5 12.55a11 11 0 0 1 14.08 0"></path>
              <path d="M1.42 9a16 16 0 0 1 21.16 0"></path>
              <path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path>
              <line x1="12" y1="20" x2="12" y2="20"></line>
            </svg>
          </div>
          <div>
            <h5 class="mb-2"><b><?php echo $_GET['wherever-you-are']; ?></b></h5>
            <p class="mb-0"><?php echo $_GET['wherever-you-are-desc']; ?></p>
          </div>
        </div>
        <div class="d-flex justify-content-between">
          <div class="mr-3">
            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#1360ef" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square">
              <polyline points="9 11 12 14 22 4"></polyline>
              <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
            </svg>
          </div>
          <div>
            <h5 class="mb-2"><b><?php echo $_GET['daily-updates']; ?></b></h5>
            <p class="mb-0"><?php echo $_GET['daily-updates-desc']; ?></p>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-5 col-xl-5">
        <div class="d-flex align-items-center mb-4"> 
          <div class="mr-3 fa-3x">
              <span class="badge badge-primary p-1 px-3" style="color:#1360ef">
                  <i class="fa fa-exclamation fa-spin"></i>
              </span>
          </div>          
          <h4 class="mt-3"><b><?php echo $_GET['importance-of-using-lp']; ?></b></h4>
          <!-- <p class="lead mb-0">We use the latest technologies it voluptatem accusantium doloremque laudantium, totam rem aperiam.</p> -->
        </div> 
        <!-- <a href="#" class="btn btn-outline-primary mt-5">
                Learn More
              </a> -->
        <div class="row">
          <div class="col-12 col-md-10">
            <img class="img-fluid mb-8" src="web/images/hero/lev7.png" alt="Image">
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="pt-0">
  <div class="container">
    <div class="row align-items-center justify-content-between">
      <div class="col-12 col-lg-6 col-xl-5 order-lg-1">
        <div class="shadow rounded">
          <img class="img-fluid rounded" src="images/image-gallery/salesperson.jpg" alt="Image">
        </div>
      </div>     
      <div class="col-12 col-lg-6 col-xl-6 mb-8 mb-lg-0 kujua">
        <div class="d-flex align-items-center mb-4"> 
          <div class="mr-3 fa-3x">
              <span class="badge badge-primary p-1 px-3" style="color:#1360ef">
                  <i class="fa fa-info fa-spin"></i>
              </span>
          </div>
          <h4 class="mt-3"><b><?php echo $_GET['lp-will-help-you-to-know']; ?></b></h4>
          <!-- <p class="lead mb-0">We use the latest technologies it voluptatem accusantium doloremque laudantium, totam rem aperiam.</p> -->
        </div>
        <div>
          <div class="mb-3">
            <div class="d-flex align-items-center">
              <div class="badge-primary-soft rounded p-1">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check" style="margin-bottom: -3px;">
                  <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
              </div>
              <p class="mb-0 ml-3"><?php echo $_GET['sales-profit-expenses']; ?></p>
            </div>
          </div>
          <div class="mb-3">
            <div class="d-flex align-items-center">
              <div class="badge-primary-soft rounded p-1">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check" style="margin-bottom: -3px;">
                  <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
              </div>
              <p class="mb-0 ml-3"><?php echo $_GET['increase-decrease-of-products']; ?></p>
            </div>
          </div>
          <div class="mb-3">
            <div class="d-flex align-items-center">
              <div class="badge-primary-soft rounded p-1">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check" style="margin-bottom: -3px;">
                  <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
              </div>
              <p class="mb-0 ml-3"><?php echo $_GET['customer-records']; ?></p>
            </div>
          </div>
          <div>
            <div class="d-flex align-items-center">
              <div class="badge-primary-soft rounded p-1">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check" style="margin-bottom: -3px;">
                  <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
              </div>
              <p class="mb-0 ml-3"><?php echo $_GET['payments-installments']; ?></p>
            </div>
          </div>
          <div class="mb-3">
            <div class="d-flex align-items-center">
              <div class="badge-primary-soft rounded p-1">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check" style="margin-bottom: -3px;">
                  <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
              </div>
              <p class="mb-0 ml-3"><?php echo $_GET['transfer-records']; ?></p>
            </div>
          </div>
        </div>
      </div> 
    </div>
  </div>
</section>

<section class="pt-0">
  <div class="container">
    <div class="row justify-content-center text-center">
      <div class="col-12 col-md-12 col-lg-8 mb-8 mb-lg-0">
        <div class="mb-8"> 
          <!-- <span class="badge badge-primary-soft p-2 font-w-6">
                  Bootsland Team
              </span> -->
          <h2 class="mt-3 font-w-5"><?php echo $_GET['subscription-fees']; ?></h2>
          <p class="lead mb-0"><?php echo $_GET['subscription-fees-desc']; ?></p>
          <p class="lead mb-0"><b>(TZS)</b></p>
        </div>
      </div>
    </div>
    <!-- / .row -->
    <div class="row gharama" style="margin-top:60px">
      <div class="col-12 col-md-4 mb-8 mb-lg-0">
        <div class="text-center hover-translate py-3 px-5 pb-5 mwezi">
          <div class="mb-3">
            <!-- <img class="img-fluid rounded-top" src="assets/images/team/01.png" alt=""> -->
          </div>
          <div>
            <h6 class="mb-1"><?php echo $_GET['month']; ?></h6>
            <div class="d-flex justify-content-center"> 
              <!-- <span class="h2 mb-0 mt-2">$</span> -->
                  <span class="price h1">12,000</span>
                  <span class="h3 align-self-end mb-1">/=</span>
                </div>
            <small class="text-muted mb-3 d-block"><?php echo $_GET['per-each-shop']; ?></small>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4 mb-8 mb-lg-0">
        <div class="text-center shadow hover-translate py-3 px-5 pb-5 miez-3">
          <div class="mb-3">
            <!-- <img class="img-fluid rounded-top" src="assets/images/team/02.png" alt=""> -->
          </div>
          <div>
            <h6 class="mb-1"><?php echo $_GET['three-months']; ?></h6>
            <div class="d-flex justify-content-center"> 
              <!-- <span class="h2 mb-0 mt-2">$</span> -->
                  <span class="price h1">33,000</span>
                  <span class="h3 align-self-end mb-1">/=</span>
                </div>
            <small class="text-muted mb-3 d-block"><?php echo $_GET['per-each-shop']; ?></small>
            <div class="pt-3" align="right">
              <span class="badge badge-danger-soft p-1 py-0"> <small><?php echo $_GET['save']; ?> 3,000</small> </span>
            </div>          
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4 mb-8 mb-md-0">
        <div class="text-center hover-translate py-3 px-5 pb-5 miez-6">
          <div class="mb-3">
            <!-- <img class="img-fluid rounded-top" src="assets/images/team/03.png" alt=""> -->
          </div>
          <div>
            <h6 class="mb-1"><?php echo $_GET['six-months']; ?></h6>
            <div class="d-flex justify-content-center"> 
              <!-- <span class="h2 mb-0 mt-2">$</span> -->
                  <span class="price h1">60,000</span>
                  <span class="h3 align-self-end mb-1">/=</span>
                </div>
            <small class="text-muted mb-3 d-block"><?php echo $_GET['per-each-shop']; ?></small>
            <div class="pt-3" align="right">
              <span class="badge badge-primary-soft p-1"> <small><?php echo $_GET['save']; ?> 12,000</small> </span>
            </div>          
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-3 col-md-6" style="display: none;">
        <div class="text-center shadow hover-translate py-3 px-5 pb-5 mwaka">
          <div class="mb-3">
            <!-- <img class="img-fluid rounded-top" src="assets/images/team/04.png" alt=""> -->
          </div>
          <div>
            <h6 class="mb-1"><?php echo $_GET['year']; ?></h6>
            <div class="d-flex justify-content-center"> 
              <!-- <span class="h2 mb-0 mt-2">$</span> -->
                  <span class="price h1">108,000</span>
                  <span class="h3 align-self-end mb-1">/=</span>
                </div>
            <small class="text-muted mb-3 d-block"><?php echo $_GET['per-each-shop']; ?></small> 
            <div class="pt-3" align="right">
              <span class="badge badge-info-soft p-1"> <small><?php echo $_GET['save']; ?> 36,000</small> </span>
            </div>          
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="jiunge pt-5">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="d-flex align-items-center mb-4"> 

          <div class="mr-3 fa-3x">
              <span class="badge badge-primary p-1 px-3" style="color:#1360ef">
                  <i class="fa fa-crosshairs fa-spin"></i>
              </span>
          </div>
          <h4 class="mt-3 mb-0"><?php echo $_GET['join-us-today']; ?></h4>
        </div>
      </div>
    </div>
    <div class="row align-items-center">
      <div class="col-lg-5 col-12 mb-8 mb-lg-0">
        <div class="shadow rounded p-3">
          <img src="images/image-gallery/graph.png" alt="Image" class="img-fluid rounded">
        </div>
      </div>
      <div class="col-lg-7 col-12">
        <div class="row text-center p-3 jiunge-i">
          <div class="col-lg-6 col-md-6">
            <div class="counter bg-primary rounded p-5 shadow">
              <div class="counter-desc text-white">
                <h5><?php echo $_GET['accounts']; ?></h5>
                <span class="count-number display-4" data-to="{{$data['accounts']+10}}" data-speed="2000">{{$data['accounts']+10}}</span>
                <!-- <span class="display-4">k</span>  -->
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 mt-5">
            <div class="counter bg-white rounded p-5 shadow">
              <div class="counter-desc">
                <h5><?php echo $_GET['users']; ?></h5>
                <span class="count-number display-4 text-primary" data-to="{{$data['users']+10}}" data-speed="2000">{{$data['users']+10}}</span>
                <!-- <span class="display-4 text-primary">k</span>  -->
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 mt-5 mt-md-0">
            <div class="counter bg-white rounded p-5 shadow">
              <div class="counter-desc">
                <h5><?php echo $_GET['shops-stores']; ?></h5>
                <span class="count-number display-4 text-primary" data-to="{{$data['stores']+10}}" data-speed="2000">{{$data['stores']+10}}</span>
                <!-- <span class="display-4 text-primary">k</span>  -->
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 mt-5">
            <div class="counter bg-orange rounded p-5 shadow">
              <div class="counter-desc text-white">
                <h5><?php echo $_GET['customers']; ?></h5>
                <span class="count-number display-4" data-to="{{$data['customers']+10}}" data-speed="2000">{{$data['customers']+10}}</span>
                <!-- <span class="display-4">k</span>  -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
  </div>

<!-- muongozo modal -->
    <div class="modal fade" id="soma-muongozo" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="myLargeModalLabel">Jinsi ya Kutumia Mfumo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: 0.9 !important;">
                    <span aria-hidden="true" class="text-danger" style="opacity: 0.9 !important;"><i class="fa fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                  <div class="row mwongozo-row">
                    <div class="col-md-6 mwongozo-desc">
                      <b>1. Jinsi ya kujiunga (kufungua akaunti) kwenye mfumo</b>
                      <div class="youtube">
                        <!-- <iframe src="https://www.youtube.com/embed/gKulcoTa4WE" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe> -->
                      </div>
                    </div>
                    <div class="col-md-6 mwongozo-desc">
                      <b>2. Jinsi ya kulogin kwenye mfumo</b>
                      <div class="youtube">
                        <!-- <iframe src="https://www.youtube.com/embed/MYXfz5ZTCnE" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe> -->
                      </div>
                    </div>
                    <div class="col-md-6 mwongozo-desc">
                      <b>3. Jinsi ya kujaza taarifa za bidhaa zako kwenye mfumo</b>
                      <div class="youtube">
                        <!-- <iframe src="https://www.youtube.com/embed/BjFLz6yLtwQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe> -->
                      </div>
                    </div>
                    <div class="col-md-6 mwongozo-desc">
                      <b>4. Jinsi ya kuongeza stock (idadi ya bidhaa) kwenye mfumo</b>
                      <div class="youtube">
                        <!-- <iframe src="https://www.youtube.com/embed/-NwN6oaW2Xg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe> -->
                      </div>
                    </div>
                    <div class="col-md-6 mwongozo-desc">
                      <b>5. Jinsi ya kuuza bidhaa na kuona ripoti za mauzo</b>
                      <div class="youtube">
                        <!-- <iframe src="https://www.youtube.com/embed/zJKva4Om-yQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe> -->
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

  function getSearchParams(k){
   var p={};
   location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(s,k,v){p[k]=v})
   return k?p[k]:p;
  }

  // slider
  window.onload = function() {
    // typewriter
    var elements = document.getElementsByClassName('txt-rotate');
    for (var i=0; i<elements.length; i++) {
      var toRotate = elements[i].getAttribute('data-rotate');
      var period = elements[i].getAttribute('data-period');
      if (toRotate) {
        new TxtRotate(elements[i], JSON.parse(toRotate), period);
      }
    }
    // INJECT CSS
    var css = document.createElement("style");
    css.type = "text/css";
    css.innerHTML = ".txt-rotate > .wrap { border-right: 0.08em solid #666 }";
    document.body.appendChild(css);
    // end typewriter

    // slider
    let slider = document.querySelector('#slider');
    let move = document.querySelector('#move');
    let moveLi = Array.from(document.querySelectorAll('#slider #move li'));
    let forword = document.querySelector('#slider #forword');
    let back = document.querySelector('#slider #back');
    let counter = 1;
    let time = 3000;
    let line = document.querySelector('#slider #line');
    let dots = document.querySelector('#slider #dots');
    let dot;

    for (i = 0; i < moveLi.length; i++) {

        dot = document.createElement('li');
        dots.appendChild(dot);
        dot.value = i;
    }

    dot = dots.getElementsByTagName('li');

    line.style.animation = 'line ' + (time / 1000) + 's linear infinite';
    dot[0].classList.add('active');

    function moveUP() {

        if (counter == moveLi.length) {

            moveLi[0].style.marginLeft = '0%';
            counter = 1;

        } else if (counter >= 1) {

            moveLi[0].style.marginLeft = '-' + counter * 100 + '%';
            counter++;
        } 

        if (counter == 1) {

            dot[moveLi.length - 1].classList.remove('active');
            dot[0].classList.add('active');

        } else if (counter > 1) {

            dot[counter - 2].classList.remove('active');
            dot[counter - 1].classList.add('active');

        }

    }

    function moveDOWN() {

        if (counter == 1) {

            moveLi[0].style.marginLeft = '-' + (moveLi.length - 1) * 100 + '%';
            counter = moveLi.length;
            dot[0].classList.remove('active');
            dot[moveLi.length - 1].classList.add('active');

        } else if (counter <= moveLi.length) {

            counter = counter - 2;
            moveLi[0].style.marginLeft = '-' + counter * 100 + '%';   
            counter++;

            dot[counter].classList.remove('active');
            dot[counter - 1].classList.add('active');

        }  

    }

    for (i = 0; i < dot.length; i++) {

        dot[i].addEventListener('click', function(e) {

            dot[counter - 1].classList.remove('active');
            counter = e.target.value + 1;
            dot[e.target.value].classList.add('active');
            moveLi[0].style.marginLeft = '-' + (counter - 1) * 100 + '%';

        });

    }

    forword.onclick = moveUP;
    back.onclick = moveDOWN;

    let autoPlay = setInterval(moveUP, time);

    slider.onmouseover = function() {

        autoPlay = clearInterval(autoPlay);
        line.style.animation = '';

    }

    slider.onmouseout = function() {

        autoPlay = setInterval(moveUP, time);
        line.style.animation = 'line ' + (time / 1000) + 's linear infinite';

    }
  // end slider
}

// start typewriter
var TxtRotate = function(el, toRotate, period) {
  this.toRotate = toRotate;
  this.el = el;
  this.loopNum = 0;
  this.period = parseInt(period, 10) || 2000;
  this.txt = '';
  this.tick();
  this.isDeleting = false;
};

TxtRotate.prototype.tick = function() {
  var i = this.loopNum % this.toRotate.length;
  var fullTxt = this.toRotate[i];

  if (this.isDeleting) {
    this.txt = fullTxt.substring(0, this.txt.length - 1);
  } else {
    this.txt = fullTxt.substring(0, this.txt.length + 1);
  }

  this.el.innerHTML = '<span class="wrap">'+this.txt+'</span>';

  var that = this;
  var delta = 300 - Math.random() * 100;

  if (this.isDeleting) { delta /= 2; }

  if (!this.isDeleting && this.txt === fullTxt) {
    delta = this.period;
    this.isDeleting = true;
  } else if (this.isDeleting && this.txt === '') {
    this.isDeleting = false;
    this.loopNum++;
    delta = 500;
  }

  setTimeout(function() {
    that.tick();
  }, delta);
};
// end typewriter


  $(function(){

    var tab = getSearchParams("tab");
    if (tab == "guidance") {
      $('#soma-muongozo').modal('toggle');
    }

    if ($(window).width() < 992) {
      // $('.top-slider').addClass('col-md-12').removeClass('col-md-5');
      $('.top-section-c').addClass('container-fluid').removeClass('container');
      $('.top-slider').removeClass('offset-md-1');
      $('.top-title').addClass('col-md-6').removeClass('col-md-5');

      $('.top-left-m').addClass('col-md-12').removeClass('col-md-7');
      $('.mwongozo-desc').addClass('col-md-12').removeClass('col-md-6');
    } else {
      $('.top-section-c').addClass('container').removeClass('container-fluid');
      $('.top-title').addClass('col-md-5').removeClass('col-md-6');

      $('.top-slider').addClass('col-md-5').removeClass('col-md-12');
      $('.top-left-m').addClass('col-md-7').removeClass('col-md-12');
      $('.mwongozo-desc').addClass('col-md-6').removeClass('col-md-12');
    }
  });
  
  if ($(window).width() < 992) {
    // $('.top-slider').addClass('col-md-12').removeClass('col-md-5');
      $('.top-slider').removeClass('offset-md-1');
      $('.top-title').addClass('col-md-6').removeClass('col-md-5');

    $('.top-left-m').addClass('col-md-12').removeClass('col-md-7');
      $('.mwongozo-desc').addClass('col-md-12').removeClass('col-md-6');
  } else {
      $('.top-title').addClass('col-md-5').removeClass('col-md-6');

    $('.top-slider').addClass('col-md-5').removeClass('col-md-12');
    $('.top-left-m').addClass('col-md-7').removeClass('col-md-12');
      $('.mwongozo-desc').addClass('col-md-6').removeClass('col-md-12');
  }
</script>
@endsection