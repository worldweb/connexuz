@extends('frontend.layouts.login-app')

@section('title', app_name() . ' | ' . __('labels.frontend.auth.register_box_title'))

@section('content')
<div class="col-md-5">
    <div class="conn-login-popup-wrap">
        <div class="form-wrap">
            <div class="tabs-content">
                <div class="tabs">
                    <h4 class="signup-tab"><a class="active" href="javascript:void(0);">Sign Up</a></h4>
                    <h4 class="login-tab"><a href="{{route('frontend.auth.login')}}">Login</a></h4>
                </div>
                <!--.tabs-->
                <div id="signup-tab-content" class="active">
                    <div class="form-content-text-wrap">
                        <h3>Register Now , it's <span class="blue-text">free.</span></h3>
                        <p>Complete the below form to get instant access.</p>
                    </div>
                    {{ html()->form('POST', route('frontend.auth.register.post'))->class('signup-form')->id('signup-form')->open() }}
                    <div class="input-wrap">
                        <i class="fas fa-envelope"></i>
                        {{ html()->email('email')
                                        ->class('input')
                                        ->placeholder(__('validation.attributes.frontend.email'))
                                        ->attribute('maxlength', 191)
                                        ->required() }}
                    </div>
                    <div class="input-wrap">
                        <i class="fas fa-user"></i>
                        {{ html()->text('first_name')
                                        ->class('input')
                                        ->placeholder(__('validation.attributes.frontend.first_name'))
                                        ->attribute('maxlength', 191) }}
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
                    <div class="term-condittion-wrap" style="margin-bottom: 15px;">
                        <a href="#" data-toggle="modal" data-target="#terms_condition_modal">Terms & Conditions </a>
                        <span style="display: none;" class="terms_error"></span>
                    </div>
                    

                    @if(config('access.captcha.registration'))
                    <div class="input-wrap">
                        {!! Captcha::display() !!}
                        {{ html()->hidden('captcha_status', 'true') }}
                    </div>
                    @endif

                    <div class="Register-btn-wrap">
                        {{ form_submit(__('labels.frontend.auth.register_button'))->class('register-btn') }}
                    </div>
                    {{ html()->form()->close() }}
                </div>
                <!--.signup-tab-content-->

                <!--.login-tab-content-->
            </div>
            <!--.tabs-content-->
        </div>
        <!--.form-wrap-->
    </div>
</div>
<!-- START SEND INVITATION MODAL POPUP -->
<div class="modal send-invitation-popup" id="terms_condition_modal" style="display:none;">
    <div class="modal-dialog">
        <!--  Loader  -->
        <div id="popUpLoader">
            <div class="widget-loader">
                <div class="load-dots"><span></span><span></span><span></span></div>
            </div>
        </div>
        <!--  Loader  -->
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Terms & Conditions</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body signup-form">
                
                <div class="term-condittion-wrap">
                    <label for="remember_me" class="term-title" > 
                        <input type="checkbox" name="terms" id="terms" class="terms" value="1">
                        <div class="control__indicator" onclick="$('#terms').click()"></div>
                    </label>
                    &nbsp;<a href="#" class="termtitle" ><strong>Accept terms & condition</strong></a>
                </div>
                
            </div>
        </div>
    </div>
</div>
<!-- END SEND INVITATION MODAL POPUP -->
@endsection
{!! script('js/jquery-3.3.1.min.js') !!}
<script>
    $(document).ready(function () {
//        $('.register-btn').attr('disabled', 'disabled');
        /*$('#login-form').validate({
         errorClass: 'has-error',
         });*/
    });
    
    $(document).on('click','.termtitle',function(){
        
        if ($('.terms').prop("checked") == true) {
            $('.terms').prop("checked", false);
        }else
        if ($('.terms').prop("checked") == false) {
            $('.terms').prop("checked",true);
        }
    });
    

//    $(document).on('click', '#terms', function () {
//
//        if ($(this).prop("checked") == true) {
//            $('.register-btn').removeAttr('disabled', 'disabled');
//        } else if ($(this).prop("checked") == false) {
//            $('.register-btn').attr('disabled', 'disabled');
////                alert("Checkbox is unchecked.");
//        }
//
//    });
    
    $(document).on('click', '.register-btn', function () {

        if ($('#terms').prop("checked") == false) {
            
            $('.terms_error').show();
            $('.terms_error').html('<br><span style="color:red;">Please Accept terms & condition</span>');
            return false;
        }

    });
    

</script>
@section('after-scripts')

@endsection
