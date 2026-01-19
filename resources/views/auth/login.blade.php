@extends('layouts.appweb')

@section('css')
<style type="text/css">
    .login-btn {display: none;}
    .auth-box {
        position: relative;
        z-index: 9;
        margin-top: 100px;
    }
    .ball {
      position: absolute;
      border-radius: 100%;
      opacity: 0.7;
    }
    .spacer {display:none}
    @media screen and (max-width: 1200px) {     
        .navbar.navbar-fixed-top {z-index: 999;}   
        #left-sidebar.sidebar {margin-top: 30px !important;z-index: 99;}
    }
    @media screen and (max-width: 1199px) {
        .auth-b-2 {margin-top: 30px;}
    }
    @media screen and (max-width: 480px) {
        .spacer {display:block}
    }
    @media screen and (max-width: 400px) {
        #left-sidebar.sidebar {margin-top: 0px !important;}
        .mt-container {margin-top: 70px;}
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

    <div class="ball"> </div>

    <div class="container">
        <div class="auth-box mt-container" style="display: inline-block;">
            <div class="top">
                <!-- <img src="{{ asset('images/logo-white.svg') }}" alt="Lucid"> -->
                <h2>Login</h2>
            </div>
            <div class="card shadow">
                <div class="header">
                    <p class="lead"><?php echo $_GET['login-to-your-account']; ?></p>
                </div>
                <div class="body">
                    @if(session()->has('error'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <i class="fa fa-warning"></i>  {{ session()->get('error') }}
                        </div>
                    @endif 
                    <form class="form-auth-small" method="POST" action="{{ route('login') }}">
                    @csrf
                        <div class="form-group">
                            <label for="signin-email" class="control-label sr-only">Username</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" id="signin-email" name="username" placeholder="Username">
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="signin-password" class="control-label sr-only">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="signin-password" placeholder="Password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group clearfix">
                            <label class="fancy-checkbox element-left">
                                <!-- <input type="checkbox">
                                <span>Remember me</span> -->
                            </label>                                
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg btn-block">LOGIN</button>
                        <div class="bottom">
                            <!-- <span class="helper-text m-b-10"><i class="fa fa-lock"></i> <a href="#">Forgot password?</a></span> -->
                            <span><span class="lead"><?php echo $_GET['dont-have-an-account']; ?> ?</span> <a href="/new-account"><?php echo $_GET['register']; ?></a></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- @if(Cookie::get("language") == 'en')
        <div class="auth-box auth-b-2" style="display: inline-block;">
            <h4>Do you want to be <br> <b>Levanda POS Agent?</b></h4>
            <div class="mt-4">
                <a href="/agent-registration" class="btn btn-info btn-sm">Click to register</a>
                <a href="/about-levanda-pos-agent" class="ml-1 read-p-a" style="text-decoration: underline;">Read about Levanda POS Agent</a>
            </div>
        </div>
        @else 
        <div class="auth-box auth-b-2" style="display: inline-block;">
            <h4>Unataka kuwa <br> <b> Wakala wa Levanda POS?</b></h4>
            <div class="mt-4">
                <a href="/agent-registration" class="btn btn-info btn-sm">Bonyeza Kujisajili</a><div class="mt-2 spacer"> </div>
                <a href="/about-levanda-pos-agent" class="ml-1 read-p-a" style="text-decoration: underline;">Soma kuhusu Levanda POS Wakala</a>
            </div>
        </div>
        @endif -->
    </div>
</div>

@endsection

@section('js')
<script type="text/javascript">
    // Some random colors
const colors = ["#3CC157", "#2AA7FF", "#1B1B1B", "#FCBC0F", "#F85F36"];

const numBalls = 15;
const balls = [];

for (let i = 0; i < numBalls; i++) {
  let ball = document.createElement("div");
  ball.classList.add("ball");
  ball.style.background = colors[Math.floor(Math.random() * colors.length)];
  ball.style.left = `${Math.floor(Math.random() * 70)}vw`;
  ball.style.top = `${Math.floor(Math.random() * 75)}vh`;
  ball.style.transform = `scale(${Math.random()})`;
  ball.style.width = `${Math.random()}em`;
  ball.style.height = ball.style.width;
  
  balls.push(ball);
  document.body.append(ball);
}

// Keyframes
balls.forEach((el, i, ra) => {
  let to = {
    x: Math.random() * (i % 2 === 0 ? -11 : 11),
    y: Math.random() * 12
  };

  let anim = el.animate(
    [
      { transform: "translate(0, 0)" },
      { transform: `translate(${to.x}rem, ${to.y}rem)` }
    ],
    {
      duration: (Math.random() + 1) * 2000, // random duration
      direction: "alternate",
      fill: "both",
      iterations: Infinity,
      easing: "ease-in-out"
    }
  );
});
</script>
@endsection
