<!DOCTYPE html>
@langrtl
    <html lang="{{ app()->getLocale() }}" dir="rtl">
@else
    <html lang="{{ app()->getLocale() }}">
@endlangrtl
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>404</title>
        <meta name="description" content="@yield('meta_description', 'Connexuz')">
        <meta name="author" content="@yield('meta_author', 'Anil')">
        @yield('meta')
        <style>
            @import url('https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i');
            html, body, section.ConneXuz-page-not-found-wrap {
                position: relative;
                background: #60bafd;
            }
            .container {
                width: 100%;
                padding-right: 15px;
                padding-left: 15px;
                margin-right: auto;
                margin-left: auto
            }
            @media (min-width:576px) {
                .container {
                    max-width: 540px
                }
            }
            @media (min-width:768px) {
                .container {
                    max-width: 720px
                }
            }
            @media (min-width:992px) {
                .container {
                    max-width: 960px
                }
            }
            @media (min-width:1200px) {
                .container {
                    max-width: 1140px
                }
            }
            .main-404-error-content-block {
                padding: 0;
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }
            .text-center {
                text-align: center;
            }
            .notfound-404 .connexuz-opps-text {
                font-size: 250px;
                font-weight: bold;
                letter-spacing: 0;
                background: url(images/bg.jpg) transparent;
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-size: cover;
                background-position: center;
                font-family: Poppins;
                margin: 0;
            }
            .main-404-error-content-block .connexuz-404-text {
                font-size: 30px;
                font-weight: bold;
                letter-spacing: 1px;
                text-transform: uppercase;
                color: #fff;
                text-shadow: 3px 3px 5px rgba(0, 0, 0, 0.65);
                margin: 20px 0;
                font-family: Poppins;
                margin: 20px 0 40px;
            }
            .go-to-home-btn-wrap .btn-go-to-home {
                background: #0046d5;
                color: #fff;
                text-transform: uppercase;
                font-weight: bold;
                letter-spacing: 1px;
                padding: 11px 25px;
                border-radius: 50px;
                box-shadow: 0px 6px 8px 1px #090923ad;
                transition: 0.5s;
                border: 2px solid #0046d5;
                text-decoration: none;
                font-family: Poppins;
            }
            .go-to-home-btn-wrap .btn-go-to-home:hover {
                border: 2px solid #0046d5;
                background: transparent;
                color: #0046d5;
                box-shadow: none;
            }
            @media screen and (max-width:767px){
                .notfound-404 .connexuz-opps-text {
                    font-size: 110px;
                }
                .main-404-error-content-block {
                    max-width: 100%;
                    position: relative;
                    top: unset;
                    transform: unset;
                    left: unset;
                    padding: 50px 0
                }
                .connexuz-header-img a {
                    text-align: center;
                    margin: 0 auto;
                    display: block;
                }
            }
            @media screen and (max-width:320px){
                .notfound-404 .connexuz-opps-text {
                    font-size: 95px;
                }
            }
        </style>

    </head>
    <body class="login-page">

        <header class="login-header">
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        <div class="connexuz-header-img">
                            <a href="{{route('frontend.index')}}"><img src="{{asset('images/logo.png')}}" alt="Logo" /></a>
                        </div>
                    </div>
                    <!-- <div class="col-md-5">
                        <div class="connexuz-contact-info">
                            <ul class="contact-wrap">
                                <li class="list-inline-item contact-item-phone"><span class="icon-custom-wrap"><i class="fas fa-phone"></i></span>Phone: <a href="tel:">012345 6789</a></li>
                                <li class="list-inline-item contact-item-email"><span class="icon-custom-wrap"><i class="fas fa-envelope"></i></span>Email: <a href="mailto:">connexuz.com</a></li>
                            </ul>
                        </div>
                    </div> -->
                </div>
            </div>
        </header>

        <div id="app">
            <main class="login-background-wrap">

        <section class="ConneXuz-page-not-found-wrap">
            <div class="container">
                <div class="main-404-error-content-block">
                    <div class="notfound">
                        <div class="notfound-404">
                            <h1 class="connexuz-opps-text text-center">Oops!</h1>
                        </div>
                        <h2 class="connexuz-404-text text-center">404 - Page not found</h2>
                        <div class="go-to-home-btn-wrap text-center">
                            <a href="{{ route('frontend.index') }}" class="btn btn-go-to-home text-center">Go To Homepage</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
</main><!-- container -->
        </div><!-- #app -->

    </body>
</html>
