@extends('frontend.layouts.login-app')

@section('title', app_name() . ' | ' . __('labels.frontend.auth.login_box_title'))

@section('content')
    <div class="col-md-5">
        <div class="conn-login-popup-wrap">
            <div class="form-wrap">
                <div class="tabs-content">
                    <div class="tabs">
                        <h4 class="signup-tab"><a href="{{route('frontend.auth.register')}}">Sign Up</a></h4>
                        <h4 class="login-tab"><a class="active" href="javascript:void(0);">Login</a></h4>
                    </div>
                    <!--.tabs-->

                    <!--.signup-tab-content-->
                    <div id="login-tab-content" class="active">
                        <div class="form-content-text-wrap">
                            <h3>Login Now</h3>
                            <!-- <p>Complete the below form to get instant access.</p> -->
                        </div>
                        {{ html()->form('POST', route('frontend.auth.login.post'))
                            ->class('login-form')
                            ->id('login-form')
                            ->open() }}
                            <div class="input-wrap">
                                <i class="fas fa-envelope"></i>
                                {{ html()->email('email')
                                    ->class('input')
                                    ->placeholder(__('validation.attributes.frontend.email'))
                                    ->attribute('maxlength', 191)
                                    ->required() }}
                            </div>
                            <div class="input-wrap">
                                <i class="fas fa-unlock"></i>
                                {{ html()->password('password')
                                        ->class('input')
                                        ->placeholder(__('validation.attributes.frontend.password'))
                                        ->required() }}
                            </div>
                            <div class="help-text forget-password-wrap">
                                <p><a href="{{ route('frontend.auth.password.reset') }}">Forget your password?</a></p>
                            </div>
                            <div class="login-btn-wrap">
                                {{ form_submit(__('labels.frontend.auth.login_button'))->class('login-btn') }}
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
