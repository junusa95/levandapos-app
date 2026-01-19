

                
@include("layouts.translater")

<style>
    .navbar-brand {padding-left: 10px !important;}
    .navbar-nav li::after {display: none;}
    .show-lang {line-height: 0px;}
    .lang-blc .fa {padding-left: 3px;}
    .lang-blc .lang-in {display: flex;align-items: center;padding: 2px 3px;}
</style>
                <div class="navbar-btn">
                    <button type="button" class="btn-toggle-offcanvas"><i class="lnr lnr-menu fa fa-bars"></i></button>
                </div>

                <div class="navbar-brand">
                    <a href="/">
                        <img src="images/pos_logo3.png" alt="pos">                                            
                    </a>                
                </div>
                
                <div class="navbar-right">
                    <!-- <form id="navbar-search" class="navbar-form search-form">
                        <input value="" class="form-control" placeholder="Search here..." type="text">
                        <button type="button" class="btn btn-default"><i class="icon-magnifier"></i></button>
                    </form>  -->               

                    <div id="navbar-menu">
                        <ul class="nav navbar-nav">
                            <!-- <li class="nav-item agent"><a class="nav-link" href="/about-levanda-pos-agent">Levanda POS Agent</a></li> -->
                            <li><a class="btn btn-primary btn-sm login-btn" style="margin-top: -3px;" href="/login">Login</a></li>
                            <li>
                                <div class="lang-blc" style="padding: 0px;">  
                                    <div class="lang-in">                                        
                                        @if(Cookie::get("language"))              
                                            @if(Cookie::get("language") == 'en')
                                                <span class="show-lang">
                                                    <img src="/images/en.png"> <span class="lw">en</span>
                                                </span>
                                            @else
                                                <div class="show-lang">
                                                    <img src="/images/sw.jpg"> <span class="lw">sw</span>
                                                </div>
                                            @endif
                                        @else
                                          <span class="show-lang">
                                              <img src="/images/sw.jpg"> <span class="lw">sw</span>
                                          </span>
                                        @endif 
                                        <i class="fa fa-angle-down"></i>  
                                    </div>    
                                  <div class="lang-drop">      
                                    <span class="switch-lang" check="en">
                                        <img src="/images/en.png"> <span>English</span>
                                    </span>
                                    <span class="switch-lang" check="sw">
                                        <img src="/images/sw.jpg"> <span class="lw">Swahili</span>
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
                        </ul>
                    </div>
                </div>
