
    <!-- below page for english-swahili words translation -->
    @include("layouts.translater") 
    
    <style type="text/css">        
      .lang-blc {border: 1px solid #ddd;padding: 0px 5px 0px 5px;margin-left: 10px;cursor: pointer;}
      .lang-blc .lw {font-size: 1rem;}
      .lang-drop {position: absolute;background: #fff;width: 100px;margin-left: -35px;margin-top: 3px; text-align: center;display: none;
        box-shadow: 0 1px 1px rgba(0,0,0,0.08), 0 2px 2px rgba(0,0,0,0.12), 0 4px 4px rgba(0,0,0,0.16), 0 8px 8px rgba(0,0,0,0.20);}
      .lang-drop .switch-lang {display: block;border-bottom: 0.5px solid #ebe8e8;padding: 5px;}
      .lang-drop .switch-lang:hover {background: #ebe8e8;}
      .show-lang {padding:3px}
      .show-lang img {height: 15px;margin-bottom:3px}
      .lang-drop .switch-lang img {height: 20px;}
      @media screen and (max-width: 767px) {
          .logout-li { display: none !important; }
      }
      @media screen and (max-width: 1230px) {
          .lang-blc { padding-bottom: 2px; }
      }
    </style>

                <div class="navbar-btn">
                    <button type="button" class="btn-toggle-offcanvas"><i class="lnr lnr-menu fa fa-bars"></i></button>
                </div>

                <div class="navbar-brand">
                    <a href="/home">
                        <!-- <img src="{{ asset('images/logo.svg') }}" alt="Lucid Logo" class="img-responsive logo"> -->
                        <span style="font-weight: bold;color: #21265F;">
                            @if(Session::get('company'))
                                {{Session::get('company')['name']}}
                                <input type="hidden" class="tcname" value="{{Session::get('company')['name']}}">
                            @else
                                <input type="hidden" class="tcname" value="POS">
                                POS
                            @endif
                        </span>                        
                    </a>                
                </div>
                
                <div class="navbar-right" style="">
                    <!-- <form id="navbar-search" class="navbar-form search-form">
                        <input value="" class="form-control" placeholder="Search here..." type="text">
                        <button type="button" class="btn btn-default"><i class="icon-magnifier"></i></button>
                    </form>  -->               

                    <div id="navbar-menu">
                        <ul class="nav navbar-nav">
                            <li>                               
                                <!-- @if(Cookie::get("language"))              
                                    @if(Cookie::get("language") == 'en')
                                        <span class="switch-lang" check="sw">
                                            <img src="/images/sw.jpg"> <span>SW</span>
                                        </span>
                                    @else
                                        <span class="switch-lang" check="en">
                                            <img src="/images/en.png"> <span>EN</span>
                                        </span>
                                    @endif
                                @else
                                    <span class="switch-lang" check="en">
                                        <img src="/images/en.png"> <span>EN</span>
                                    </span>
                                @endif     -->    

                                <div class="lang-blc">                                              
                                  @if(Cookie::get("language"))              
                                      @if(Cookie::get("language") == 'en')
                                          <span class="show-lang">
                                              <img src="/images/en.png"> <span class="lw">en</span>
                                          </span>
                                      @else
                                          <span class="show-lang">
                                              <img src="/images/sw.jpg"> <span class="lw">sw</span>
                                          </span>
                                      @endif
                                  @else
                                    <span class="show-lang">
                                        <img src="/images/sw.jpg"> <span class="lw">sw</span>
                                    </span>
                                  @endif 
                                  <i class="fa fa-angle-down"></i>  
                                  <div class="lang-drop">          
                                        <span class="switch-lang" check="en">
                                            <img src="/images/en.png"> <span>English</span>
                                        </span>                 
                                        <span class="switch-lang" check="sw">
                                            <img src="/images/sw.jpg"> <span>Swahili</span>
                                        </span>                
                                    <!-- @if(Cookie::get("language"))              
                                        @if(Cookie::get("language") == 'en')
                                            <span class="switch-lang" check="sw">
                                                <img src="/images/sw.jpg"> <span class="lw">SW</span>
                                            </span>
                                        @else
                                            <span class="switch-lang" check="en">
                                                <img src="/images/en.png"> <span>EN</span>
                                            </span>
                                        @endif
                                    @else
                                        <span class="switch-lang" check="en">
                                            <img src="/images/en.png"> <span>EN</span>
                                        </span>
                                    @endif  -->
                                  </div>       
                                </div>                            
                            </li>
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle icon-menu" data-toggle="dropdown" style="padding-top: 8px;">
                                    <i class="icon-bell"></i>
                                    <span class="notification-dot" style="display:none"></span> 
                                </a>
                                <ul class="dropdown-menu render notifications">
                                    <li class="header"><strong><?php echo $_GET['notifications']; ?></strong></li>
                                </ul>
                            </li>
                            <li class="logout-li">
                                <a href="#" class="icon-menu user-logout" style="padding-top: 8px;"><i class="icon-login"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
