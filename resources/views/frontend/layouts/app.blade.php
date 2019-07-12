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
        
        {{ style('css/bootstrap.min.css') }}
        {{ style('css/font-awesome.min.css') }}
        {{ style(mix('css/frontend.css')) }}
        {{ style('//code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css') }}
        {{ style('css/style.css') }}
        {{ style('css/custom.css') }}
        {{ style('css/toastr.min.css') }}

        @stack('after-styles')
    </head>
    <body>
        @include('includes.partials.logged-in-as')
        @include('frontend.includes.nav')

        @yield('content')

        <!-- Scripts -->
        @stack('before-scripts')
        {!! script('js/jquery-3.3.1.min.js') !!}
        {!! script('//code.jquery.com/ui/1.11.4/jquery-ui.js') !!}
        {!! script('js/bootstrap.min.js') !!}

        {!! script('js/popper.min.js') !!}
        {!! script('js/jquery.validate.js') !!}
        <!-- {!! script('js/jquery-validate.bootstrap-tooltip.js') !!} -->
        {!! script('js/additional-methods.js') !!}
        {!! script('js/ckeditor/ckeditor.js') !!}
        {!! script('js/custom.js') !!}
        {!! script('js/toastr.min.js') !!}
        @stack('after-scripts')
        
        <script>
            $(document).ready(function(){
                
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "check_subscription",
                    method: 'post',
                    success: function(result) {
                        if(result){
//                            window.location = 'settings';
                        }
                    }
                });
                
                
            });
        </script>
        @include('includes.partials.ga')
        @include('includes.partials.flash-messages')
        @yield('popup')
    </body>
</html>
