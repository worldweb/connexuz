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
        <title>@yield('title', app_name())</title>
        <meta name="description" content="@yield('meta_description', 'Connexuz')">
        <meta name="author" content="@yield('meta_author', 'Anil')">
        @yield('meta')

        {{-- See https://laravel.com/docs/5.5/blade#stacks for usage --}}
        @stack('before-styles')

        <!-- Check if the language is set to RTL, so apply the RTL layouts -->
        <!-- Otherwise apply the normal LTR layouts -->
        {{ style(mix('css/frontend.css')) }}
        {{ style('css/bootstrap.min.css') }}
        {{ style('css/font-awesome.min.css') }}
        {{ style('css/style.css') }}
        {{ style('css/custom.css') }}
        {{ style('css/toastr.min.css') }}

        @stack('after-styles')
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
                    <div class="col-md-5">
                        <div class="connexuz-contact-info">
                            <ul class="contact-wrap">
                                <li class="list-inline-item contact-item-phone"><span class="icon-custom-wrap"><i class="fas fa-phone"></i></span>Phone: <a href="tel:">{{ $settings['contact_number'] }}</a></li>
                                <li class="list-inline-item contact-item-email"><span class="icon-custom-wrap"><i class="fas fa-envelope"></i></span>Email: <a href="mailto:">{{ $settings['contact_email'] }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div id="app">
            <main class="login-background-wrap">
                <section class="conn-content-main-wrap connexuz-login-signup-wrap">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="conn-content-wrap">
                                    <div class="conn-content-title-wrap">
                                        <h1>{{ $settings['login_tagline_one'] }} <span style="display:block;">{{ $settings['login_tagline_two'] }}</span></h1>
                                    </div>
                                    <div class="conn-content-ul-wrap">
                                        <ul>
                                            <li>{{ $settings['login_content_one'] }}</li>
                                            <li>{{ $settings['login_content_two'] }}</li>
                                            <li>{{ $settings['login_content_three'] }}</li>
                                            <li>{{ $settings['login_content_four'] }}</li>
                                            <li>{{ $settings['login_content_five'] }}</li>
                                        </ul>
                                        <button type="button" class="btn conn-get-started-btn">Get started</button>
                                    </div>
                                </div>
                            </div>
                            @yield('content')
                        </div>
                    </div>
                </section>
            </main><!-- container -->
        </div><!-- #app -->

        <!-- Scripts -->
        @stack('before-scripts')
        {!! script(mix('js/manifest.js')) !!}
        {!! script(mix('js/vendor.js')) !!}
        {!! script(mix('js/frontend.js')) !!}

        {!! script('js/jquery-3.3.1.min.js') !!}
        {!! script('js/bootstrap.min.js') !!}
        {!! script('js/popper.min.js') !!}
        {!! script('js/jquery.validate.js') !!}
        {!! script('js/jquery-validate.bootstrap-tooltip.js') !!}
        
        {!! script('js/toastr.min.js') !!}
        @stack('after-scripts')

        @include('includes.partials.ga')
        @include('includes.partials.flash-messages')
        @yield('popup')
    </body>
</html>
