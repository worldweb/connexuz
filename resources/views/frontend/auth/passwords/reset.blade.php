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
                        {{ html()->form('POST', route('frontend.auth.password.reset'))
                            ->class('reset-form')
                            ->id('reset-form')
                            ->open() }}
                    <input type="hidden" name="token" value="{{$token}}" />
                            <div class="input-wrap">
                                <i class="fas fa-envelope"></i>

                                {{ html()->email('email')
                                ->class('input')
                                ->placeholder(__('validation.attributes.frontend.email'))
                                ->attribute('maxlength', 191)
                                ->required()
                                ->autofocus() }}
                            </div>

                            <div class="input-wrap">
                                <i class="fas fa-unlock"></i>
                                {{ html()->password('password')
                                        ->class('input')
                                        ->placeholder(__('validation.attributes.frontend.password'))
                                        ->required() }}
                            </div>
                            <div class="input-wrap">
                                <i class="fas fa-lock"></i>
                                {{ html()->password('password_confirmation')
                                            ->class('input')
                                            ->placeholder(__('validation.attributes.frontend.password_confirmation'))
                                            ->required() }}
                            </div>

                            <div class="login-btn-wrap">
                                {{ form_submit(__('labels.frontend.passwords.reset_password_button'))->class('login-btn') }}
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
