 @extends('frontend.layouts.app')

 @section('title', app_name() . ' | ' . __('labels.frontend.page_title.settings'))

 @section('content')

<!-- START<profile-cover-img> -->
<section class="conn-profile-details-main-section-wrap">
    <div class="">
        <div class="row">
            <div class="col-md-12">
                <div class="conn-profile-cover-img-section-wrap">
                    <img src="{{ $logged_in_user->cover_image }}" class="img-fluid conn-profile-cover-img">
                    <div class="conn-profile-img-wrap-section">
                        <img src="{{ $logged_in_user->avatar_location }}" class="img-fluid conn-profile-cover-img-subimg rounded-circle">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END<profile-cover-img> -->

<!-- START<profile-cover-details> -->
<section class="conn-profile-details-sub-section-wrap">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="conn-main-tabs-section">

                    <ul class="nav nav-tabs nav-tabs--vertical nav-tabs--left" role="navigation">
                        <div class="conn-profile-name-wrap">
                            <p class="text-left profile-name">{{ $logged_in_user->name }}</p>
                        </div>
                         <li class="nav-item">
                            <a href="#payment" class="nav-link  show active conn-edcu-tab" data-toggle="tab" role="tab" aria-controls="edcu">Payment</a>
                        </li> 
                        <li class="nav-item">
                            <a href="#setting" class="nav-link show conn-basic-info-tab" data-toggle="tab" role="tab" aria-controls="setting">Setting</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- <START---ACCOUNT> -->
                        <div class="tab-pane fade show " id="setting" role="tabpanel">
                            <div class="main-details-wrap">
                                <div class="title-wrap">
                                    <p class="title-name">Account Settings</p>
                                </div>
                                <!-- <div class="deatils-content-wrap">
                                    <p class="content-text">
                                        Aenean pharetra risus quis placerat euismod. Praesent mattis lorem eget massa euismod sollicitudin. Donec porta nulla ut blandit vehicula. Mauris sagittis lorem nec mauris placerat, et molestie elit vehicula. Donec libero ex, condimentum et mi dapibus,
                                        euismod ornare ligula.
                                    </p>
                                </div> -->
                                <div class="main-detail-of-field-wrap">
                                    <div class="slide-btn-wrap">
                                        <div class="row">
                                            <div class="col-md-8 col-8">
                                                <div class="slide-btn-wrap-text">
                                                    <p class="slide-btn-wrap-text-title">Show Comment</p>
                                                    <p class="second-text">Enable this if you want to allow to show comments on your post</p>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-4">
                                                <div class="block for-slide-btn">
                                                    <input data-index="1" id="show_comment" type="checkbox" {{ (auth()->user()->show_comment) ? 'checked' : '' }} onchange="change_status('show_comment','{{ route('frontend.user.change.status') }}','{{ csrf_token() }}')">
                                                    <label for="show_comment"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="slide-btn-wrap">
                                        <div class="row">
                                            <div class="col-md-8 col-8">
                                                <div class="slide-btn-wrap-text">
                                                    <p class="slide-btn-wrap-text-title">Add Comment</p>
                                                    <p class="second-text">Enable this if you want to allow to add comments on your post</p>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-4">
                                                <div class="block for-slide-btn">
                                                    <input data-index="1" id="add_comment" type="checkbox" {{ (auth()->user()->add_comment) ? 'checked' : '' }} onchange="change_status('add_comment','{{ route('frontend.user.change.status') }}','{{ csrf_token() }}')">
                                                    <label for="add_comment"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="slide-btn-wrap">
                                        <div class="row">
                                            <div class="col-md-8 col-8">
                                                <div class="slide-btn-wrap-text">
                                                    <p class="slide-btn-wrap-text-title">Add Like</p>
                                                    <p class="second-text">Enable this if you want to allow to add likes on your post</p>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-4">
                                                <div class="block for-slide-btn">
                                                    <input data-index="1" id="add_likes" type="checkbox" {{ (auth()->user()->add_likes) ? 'checked' : '' }} onchange="change_status('add_likes','{{ route('frontend.user.change.status') }}','{{ csrf_token() }}')">
                                                    <label for="add_likes"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="slide-btn-wrap">
                                        <div class="row">
                                            <div class="col-md-8 col-8">
                                                <div class="slide-btn-wrap-text">
                                                    <p class="slide-btn-wrap-text-title">Show Profile</p>
                                                    <p class="second-text">Enable this if you want to allow others to see your profile</p>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-4">
                                                <div class="block for-slide-btn">
                                                    <input data-index="1" id="show_profile" type="checkbox" {{ (auth()->user()->show_profile) ? 'checked' : '' }} onchange="change_status('show_profile','{{ route('frontend.user.change.status') }}','{{ csrf_token() }}')">
                                                    <label for="show_profile"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="slide-btn-wrap">
                                        <div class="row">
                                            <div class="col-md-8 col-8">
                                                <div class="slide-btn-wrap-text">
                                                    <p class="slide-btn-wrap-text-title">Show Email</p>
                                                    <p class="second-text">Enable this if you want to allow others to see your email address</p>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-4">
                                                <div class="block for-slide-btn">
                                                    <input data-index="1" id="show_email" type="checkbox" {{ (auth()->user()->show_email) ? 'checked' : '' }} onchange="change_status('show_email','{{ route('frontend.user.change.status') }}','{{ csrf_token() }}')">
                                                    <label for="show_email"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="slide-btn-wrap">
                                            <div class="row">
                                                <div class="col-md-8 col-8">
                                                    <div class="slide-btn-wrap-text">
                                                        <p class="slide-btn-wrap-text-title">Enable sound</p>
                                                        <p class="second-text">You'll hear notification sound when someone sends you a private message</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-4">
                                                    <div class="block for-slide-btn">
                                                        <input data-index="1" id="sound" type="checkbox">
                                                        <label for="sound"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->

                                </div>
                            </div>
                        </div>
                        <!-- <END ACCOUNT> -->
                        <!-- <START PASSWORD> -->
                        <div class="tab-pane fade show active" id="payment" role="tabpanel">
                            <div class="main-details-wrap">
                                <div class="title-wrap">
                                    <p class="title-name">Payment</p>
                                </div>
                                <div class="main-detail-of-field-wrap connexuz-payment-wrap">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="deatils-content-wrap">
                                                {{ html()->form('POST', route('frontend.user.charge.card'))->id('paymentForm')->open() }}
                                                    <select name="plan" class="form-control">
                                                        <!-- <option value=""> Select </option> -->
                                                        @foreach($subscriptions as $subscription)
                                                            <option value="{{$subscription->id}}">{{$subscription->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" name="dataValue" id="dataValue" value="dataValue" />
                                                    <input type="hidden" name="dataDescriptor" id="dataDescriptor" value="dataDescriptor" />
                                                    <button type="submit"
                                                        class="AcceptUI"
                                                        data-billingAddressOptions='{"show":true, "required":true}'
                                                        data-apiLoginID="{{$settings['payment_login_id']}}"
                                                        data-clientKey="{{$settings['payment_client_key']}}"
                                                        data-acceptUIFormBtnTxt="Submit"
                                                        data-acceptUIFormHeaderTxt="Card Information"
                                                        data-responseHandler="responseHandler">Pay
                                                    </button>
                                                {{ html()->form()->close() }}
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div> 
                        <!-- <START---PASSWORD> -->




                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript"
    src="https://jstest.authorize.net/v3/AcceptUI.js"
    charset="utf-8">
</script>

    <script type="text/javascript">

    function responseHandler(response) {

        if (response.messages.resultCode === "Error") {
            var i = 0;
            while (i < response.messages.message.length) {
                console.log(
                    response.messages.message[i].code + ": " +
                    response.messages.message[i].text
                );
                i = i + 1;
            }
        } else {
            paymentFormUpdate(response.opaqueData);
        }
    }

    function paymentFormUpdate(opaqueData) {
        document.getElementById("dataDescriptor").value = opaqueData.dataDescriptor;
        document.getElementById("dataValue").value = opaqueData.dataValue;

        document.getElementById("paymentForm").submit();
    }

</script>
@endsection
