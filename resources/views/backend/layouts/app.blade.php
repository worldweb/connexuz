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
            {{ style(mix('css/backend.css')) }}
            {{ style('css/jquery-ui.css') }}
            {{ style('css/admin/datatables.bootstrap.css') }}
            {{ style('css/toastr.min.css') }}

            @stack('after-styles')
        </head>

        <body class="{{ config('backend.body_classes') }}">
            @include('backend.includes.header')

            <div class="app-body">
                @include('backend.includes.sidebar')

                <main class="main">
                    @include('includes.partials.logged-in-as')
                    {!! Breadcrumbs::render() !!}

                    <div class="container-fluid">
                        <div class="animated fadeIn">
                            <div class="content-header">
                                @yield('page-header')
                            </div><!--content-header-->

                            @yield('content')
                        </div><!--animated-->
                    </div><!--container-fluid-->
                </main><!--main-->

                @include('backend.includes.aside')
            </div><!--app-body-->

            @include('backend.includes.footer')

            <!-- Scripts -->
            @stack('before-scripts')
            {!! script('js/jquery-3.3.1.min.js') !!}
            {!! script(mix('js/manifest.js')) !!}
            {!! script(mix('js/vendor.js')) !!}
            {!! script(mix('js/backend.js')) !!}
            {!! script('js/toastr.min.js') !!}
            {!! script('//code.jquery.com/ui/1.11.4/jquery-ui.js') !!}
            {!! script('js/jquery.validate.js') !!}
            {!! script('js/additional-methods.js') !!}
            {!! script('js/ckeditor/ckeditor.js') !!}
            {!! script('js/admin/lib/datatable/jquery.dataTables.min.js') !!}
            {!! script('js/admin/lib/datatable/dataTables.bootstrap4.min.js') !!}
            {!! script('js/backend_customjs.js') !!}
            @stack('after-scripts')

            @include('includes.partials.ga')
            @include('includes.partials.flash-messages')
            @yield('popup')
        </body>
    </html>
