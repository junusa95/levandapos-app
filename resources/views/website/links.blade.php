


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Levanda POS</title>

        <!-- Fonts -->


        <link rel="stylesheet" href="{{ asset('web/css/bootstrap.min.css') }}">
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>

        <link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}">
        
        <!-- Styles -->
        <style>
            body {
                /* background: rgb(71,138,226); */
                /* background: linear-gradient(0deg, rgba(71,138,226,1) 11%, rgba(34,193,195,1) 90%); */

                /* background: linear-gradient(-45deg, #01214d, #19beda, #01214d, #01214d); */

                background: #00377C;

                min-height: 100vh;
            }
            .t-logo {
                text-align: center;
            }
            

            .link-block:hover {
                color: #001F3F;
                /* background-color: #43c8f5; */
            }
            .link-block .svg {
                padding-top: 2px;margin-right: 20px;
            }
            .title-block {color: #fff;}
            .svg.whatsapp {color: #075e54;}
            .svg.instagram {color: #dd2a7b;}
            /* .svg.facebook {color: #1877F2;} */
            .svg.youtube {color: #CD201F;}
            .svg.web {color: #5833FF;}
            .link-block svg {
                width: 30px; height: 30px;
            }
            .link-block .title {
                width: 85%;padding-top: 4px;padding-left: 10px; margin-right: 20px;
            }
            .link-block .arrow-r {
                float: right;width: 30px;
            }
            .link-block .arrow-r img {width: inherit;}

            .footer {margin-top: 20px;}
            .footer .svg {padding-right: 10px;}
            .footer svg {
                width: 30px; height: 30px;
            }
            
            .link-block {
                border: 2px solid currentColor;
                border-radius: 1rem;
                color: #000;background-color: #eee;border-color: #f94f15;
                margin-bottom: 15px;
                padding: 10px;
                cursor: pointer;
                overflow: hidden;
                position: relative;
                text-decoration: none;
                transition: 0.2s transform ease-in-out;
                will-change: transform;
                z-index: 0;
                display: flex;
            }
            .link-block::after {
                background-color: #00377C;
                border-radius: 1rem;
                content: '';
                display: block;
                height: 100%;
                width: 100%;
                position: absolute;
                left: 0;
                top: 0;
                transform: translate(-100%, 0) rotate(10deg);
                transform-origin: top left;
                transition: 0.2s transform ease-out;
                will-change: transform;
                z-index: -1;
            }
            .link-block:hover::after {
                transform: translate(0, 0);
            }
            .link-block:hover {
                border: 2px solid transparent;border-color: #f94f15;
                color: #fff;
                transform: scale(1.05);
                will-change: transform;
            }
            .link-block .img {
                width: 30px;
            }
            .footer-icons .img {
                width: 40px;
            }
            .footer-icons a:hover {
                text-decoration: none;
            }
            .footer-icons .img {display: inline-block;margin-right: 5px;margin-left: 5px;}
            .link-block .img img, .footer-icons .img img {
                width: inherit;
            }

            .ad-banner img {
                width: 100%;
            }

            .download-btn .btn {border: 2px solid #fff;font-size: 1.1rem;margin: 3px;}

.success {
    z-index: 999;
}
.success .h-outer {
  position: absolute;
  margin-top: 30vh;
  width: 90%;
  text-align: center;
  background: #000;opacity: 0.8;color: #fff;
}
.success h1 {
  font-size: 200%;font-weight: bold;
  font-family: sans-serif;
  
  /* opacity: 1; */
}

.suuccess canvas {
  overflow-y: hidden;
  overflow-x: hidden;
  width: 100%;
  margin: 0;
}
.success input, .success button {display: inline-block;}

@media screen and (max-width: 500px) {
    .success .h-outer {opacity: 1;margin-left: 5%;}
}

        </style>
    </head>
    <body>

        <div class="row mx-0 mt-3">
            <div class="col-12" style="">
                <div class="t-logo mt-3">
                    <img src="/images/logo_pos_white.png" width="100" class="img-responsive">
                </div>
                <div align="center" style="color:#fff">
                    A simplified Sales and Inventory Management system for your Business
                </div>
            </div>
        
            <div class="col-3">
                <!-- <div style="background-color: lime;">
                    s
                </div> -->
            </div>
            <div class="col-md-6 pt-5">
                <!-- <div class="title-block" style="margin-top: 30px;" align="center">
                    <h5>TIGO PESA</h5>
                </div> -->
                <div class="link-block open-page" link="/" id="download-android">
                    <div class="img">
                        <img src="/images/link2.png" class="img-responsive">      
                    </div>
                    <div class="title">Website</div>
                    <div class="arrow-r mt-1">
                        <img src="/images/angleright.png" class="img-responsive">
                    </div>
                </div>
                <div class="link-block open-page" link="/new-account" id="download-ios">
                    <div class="img">
                        <img src="/images/register.png" class="img-responsive">      
                    </div>
                    <div class="title">Jisajili / Register</div>
                    <div class="arrow-r mt-1">
                        <img src="/images/angleright.png" class="img-responsive">
                    </div>
                </div>
                <div class="link-block open-page" link="https://youtube.com/playlist?list=PLIA0DfELblTwPSLYZ4B1oNpvMIc98jj2w&si=6aicCDClWwz41RU2">
                    <div class="img">
                        <img src="/images/youtube.webp" class="img-responsive">      
                    </div>
                    <div class="title">Tazama Jinsi ya Kutumia / Demo</div>
                    <div class="arrow-r mt-1">
                        <img src="/images/angleright.png" class="img-responsive">
                    </div>
                </div>
                <div class="link-block open-page" link="https://wa.me/+255656040073" id="jiunge-kikoba">
                    <div class="img">
                        <img src="/images/whatsapp.webp" class="img-responsive">      
                    </div>
                    <div class="title">Tuchati WhatsApp</div>
                    <div class="arrow-r mt-1">
                        <img src="/images/angleright.png" class="img-responsive">
                    </div>
                </div>
                <div class="link-block open-page" link="https://whatsapp.com/channel/0029VanVwzY8vd1SCxd0nS0Y" id="nivueshe-plus">
                    <div class="img">
                        <img src="/images/whatsapp.webp" class="img-responsive">      
                    </div>
                    <div class="title">Follow WhatsApp Channel</div>
                    <div class="arrow-r mt-1">
                        <img src="/images/angleright.png" class="img-responsive">
                    </div>
                </div>
            </div>
            <div class="col-3">

            </div>
        </div>

        <div class="row mx-0 mt-4 ad-banner" style="display: none;">
            <div class="col-md-6 mb-3">
                <div>
                    <img src="/images/saizi-yako-slider.jpg" alt="">
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div>                    
                    <img src="/images/Cha-Wote-Mainland-Slider.png" alt="">
                </div>
            </div>
        </div>
  
        <div class="footer mt-5">
            <div class="container">
                <div class="row pb-3">
                    <div class="col-12 footer-icons" align="center">
                        <a href="https://wa.me/+255656040073">
                            <div class="img">
                                <img src="/images/whatsapp.webp" class="img-responsive">      
                            </div>
                        </a>
                        <a href="https://www.instagram.com/levanda_pos/">
                            <div class="img">
                                <img src="/images/instagram.webp" class="img-responsive">      
                            </div>
                        </a>
                        <a href="https://web.facebook.com/levandapos">
                            <div class="img">
                                <img src="/images/facebook.png" class="img-responsive">      
                            </div>
                        </a>
                        <a href="https://www.tiktok.com/@levanda_pos">
                            <div class="img">
                                <img src="/images/tiktok4.png" class="img-responsive">      
                            </div>
                        </a>
                        <a href="https://youtube.com/playlist?list=PLIA0DfELblTwPSLYZ4B1oNpvMIc98jj2w&si=6aicCDClWwz41RU2">
                            <div class="img">
                                <img src="/images/youtube.webp" class="img-responsive">      
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>




<!-- <canvas class="background"></canvas> --> 
<script type="module">


const possibleColors = [
  "DodgerBlue",
  "OliveDrab",
  "Gold",
  "Pink",
  "SlateBlue",
  "LightBlue",
  "Gold",
  "Violet",
  "PaleGreen",
  "SteelBlue",
  "SandyBrown",
  "Chocolate",
  "Crimson"
];


function randomFromTo(from, to) {
  return Math.floor(Math.random() * (to - from + 1) + from);
}




    if ($(window).width() < 480) {
        // $('.top-banner img').attr('src','/images/chawote.png');
    }

    
    $(document).on('click','.open-page',function(e){
        e.preventDefault();
        var link = $(this).attr('link');
        window.open(link, '_blank');
    });
    
    
</script>
        
    </body>
</html>
