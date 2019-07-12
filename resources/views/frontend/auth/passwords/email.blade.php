@extends('frontend.layouts.login-app')

@section('title', app_name() . ' | ' . __('labels.frontend.passwords.reset_password_box_title'))

@section('content')
    <div class="col-md-5">
        <div class="conn-login-popup-wrap">
            <div class="form-wrap">
                <div class="tabs-content">
                    <div class="tabs">
                        <h3 class="login-tab"><a class="active" href="#login-tab-content">@lang('labels.frontend.passwords.reset_password_box_title')</a></h3>
                    </div>
                    <!--.tabs-->

                    <!--.signup-tab-content-->
                    <div id="login-tab-content" class="active">
                        <div class="form-content-text-wrap">

                            <!-- <p>Complete the below form to get instant access.</p> -->
                        </div>
                        {{ html()->form('POST', route('frontend.auth.password.email.post'))
                            ->class('forgot-form')
                            ->id('forgot-form')
                            ->open() }}
                    <input type="hidden" name="token" value="{{ app('request')->input('name') }}" />
                            <div class="input-wrap">
                                <i class="fas fa-envelope"></i>

                                {{ html()->email('email')
                                ->class('input')
                                ->placeholder(__('validation.attributes.frontend.email'))
                                ->attribute('maxlength', 191)
                                ->required()
                                ->autofocus() }}
                            </div>

                            <div class="help-text forget-password-wrap">
                                <p><a href="{{ route('frontend.auth.login') }}">Login</a> Or <a href="{{ route('frontend.auth.login') }}">Sign Up</a></p>
                            </div>
                            <div class="login-btn-wrap">
                                {{ form_submit(__('labels.frontend.passwords.send_password_reset_link_button'))->class('login-btn') }}
                            </div>
                         {{ html()->form()->close() }}
                    </div>
                    <!--.login-tab-content-->
                </div>
                <!--.tabs-content-->
            </div>
            <!--.form-wrap-->
        </div>
    </div>
@endsection

@section('after-scripts')
    <script>
        $(document).ready(function () {
            /*$('#login-form').validate({
                errorClass: 'has-error',
            });*/
        });

    </script>
@endsection
