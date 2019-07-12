@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.frontend.page_title.profile') )

@section('content')

@include('frontend.user.profile-photo')

@push('after-styles')
    {{ style('css/croppie.css') }}
@endpush

{{ html()->modelForm($logged_in_user, 'PATCH', route('frontend.user.profile.updateprofile'))->class('form-horizontal profile_form_submit')->attribute('enctype', 'multipart/form-data')->open() }}

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
                            <a href="#basic-info" class="nav-link show active conn-basic-info-tab" data-toggle="tab" role="tab"
                               aria-controls="basic-info" onclick="$('.hidden_form').val(0);$('#basic_info').val(1)">Basic information</a>
                        </li>
                        <li class="nav-item">
                            <a href="#edcu" class="nav-link conn-edcu-tab" data-toggle="tab" role="tab" aria-controls="edcu" onclick="$('.hidden_form').val(0);$('#edu_info').val(1)">Education and work</a>
                        </li>
                        <li class="nav-item">
                            <a href="#my-intern" class="nav-link conn-my-inter-tab" data-toggle="tab" role="tab" aria-controls="my-intern" onclick="$('.hidden_form').val(0);$('#interest_info').val(1)">My interest</a>
                        </li>
                        <li class="nav-item">
                            <a href="#change-password" class="nav-link conn-change-pass-tab" data-toggle="tab" role="tab" aria-controls="change-password" onclick="$('.hidden_form').val(0);$('#password_info').val(1)">Change password</a>
                        </li>
                    </ul>

                    <div class="tab-content">


                        <!-- <START---basic-info> -->
                        <div class="tab-pane fade show active" id="basic-info" role="tabpanel">
                            <div class="main-details-wrap">
                                <div class="title-wrap">
                                    <p class="title-name">Edit basic information</p>
                                </div>
                                <div class="deatils-content-wrap">
                                    <p class="content-text">
                                        {{ $logged_in_user->about }}
                                    </p>
                                </div>
                                <div class="main-detail-of-field-wrap">

                                    <div class="form-row first-group">
                                        <div class="form-group col-md-6">
                                            <label for="first_name" class="input-name">First name*</label>
                                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First name" value="{{ $logged_in_user->first_name }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="last_name" class="input-name">Last name*</label>
                                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last name" value="{{ $logged_in_user->last_name }}">
                                        </div>
                                    </div>
                                    <div class="form-group first-group">
                                        <label for="email" class="input-name">My Email*</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ $logged_in_user->email }}">
                                    </div>
                                    <div class="form-group first-group date-of-birth-field">
                                        <label for="date_of_birth" class="input-name">Date of Birth*</label>
                                        <input type="text" class="form-control" id="date_of_birth" name="date_of_birth" placeholder="" value="{{ \Carbon\Carbon::parse($logged_in_user->date_of_birth)->format('m/d/Y') }}">
                                    </div>
                                    <div class="form-group first-group radio-btn-field">
                                        <div class="row">
                                            <legend class="col-form-label col-sm-2 pt-0">i am a*</legend>
                                            <div class="col-sm-9">
                                                <div class="form-check-inline">

                                                    <input class="form-check-input" type="radio" name="gender" id="gender_male" value="1" {{ ($logged_in_user->gender == 1) ? "checked": "" }}>
                                                    <label class="form-check-label" for="gender_male">Male</label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <input class="form-check-input" type="radio" name="gender" id="gender_female" value="2" {{ ($logged_in_user->gender == 2) ? "checked": "" }}>
                                                    <label class="form-check-label" for="gender_female">Female</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row first-group">
                                        <div class="form-group col-md-6">
                                            <label for="city" class="input-name">City*</label>
                                            <input type="text" class="form-control" id="city" name="city" value="{{ $logged_in_user->city }}" placeholder="City">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="country" class="input-name">Country*</label>
                                            
                                            {!! Form::select('country',$countries, isset($logged_in_user->country) ? $logged_in_user->country : '', ['class' => 'form-control','id' => 'country','data-placeholder'=>'-- Select Country --','placeholder'=>'-- Select Country --','required'=>'required'])
                                                                    !!}
                                            
                                        </div>
                                    </div>
                                    <div class="form-group first-group">
                                        <label for="inputAddress" class="input-name">About*</label>
                                        <textarea class="form-control" id="about" name="about" rows="3">{{ $logged_in_user->about }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputAddress" class="input-name" style="float:right"><b>* -- Mandatory fields</b></label>
                                    </div>
                                    <input type="hidden" id="basic_info" name="basic_info" class="hidden_form" value="1" >
                                    <div class="save-btn-warp text-center">
                                        <input type="submit" class="save-btn" value="Save Changes">
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- <END---basic-info> -->
                        <!-- <START---EDU> -->
                        <div class="tab-pane fade" id="edcu" role="tabpanel">
                            <div class="main-details-wrap">
                                <div class="title-wrap">
                                    <p class="title-name">My Education</p>
                                </div>

                                <div class="main-detail-of-field-wrap">
                                    <div class="form-group first-group">
                                        <label for="university" class="input-name">My school / College / University</label>
                                        <input type="text" class="form-control" id="university" name="university" value="{{ $logged_in_user->university }}" placeholder="">
                                    </div>
                                    <div class="form-row first-group">
                                        <div class="form-group col-md-6">
                                            <label for="education_from_date" class="input-name">From</label>
                                            <input type="text" class="form-control" id="education_from_date" name="education_from_date" value="{{ (!empty($logged_in_user->education_from_date))? \Carbon\Carbon::parse($logged_in_user->education_from_date)->format('m/d/Y') : '' }}" placeholder="From Date">
                                        </div>
                                        <div class="form-group col-md-6 first-group">
                                            <label for="education_to_date" class="input-name">To</label>
                                            <input type="text" class="form-control" id="education_to_date" name="education_to_date" value="{{ (!empty($logged_in_user->education_to_date))? \Carbon\Carbon::parse($logged_in_user->education_to_date)->format('m/d/Y') : '' }}" placeholder="To Date">
                                        </div>
                                    </div>
                                    <div class="form-group first-group">
                                        <label for="education_about" class="input-name">My work experience</label>
                                        <textarea class="form-control" id="education_about" name="education_about" rows="3">{{ $logged_in_user->education_about }}</textarea>
                                    </div>
                                    <div class="form-group form-check">
                                        <input id="graduted" type="checkbox" name="graduted" value="1" {{ ($logged_in_user->graduted == 1) ? "checked": "" }}>
                                        <label for="graduted">Graduted</label>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputAddress" class="input-name" style="float:right"><b>* -- Mandatory fields</b></label>
                                    </div>
                                    <input type="hidden" id="edu_info" name="edu_info" class="hidden_form" value="0" >
                                    <div class="save-btn-warp text-center">
                                        <input type="submit" class="save-btn" value="Save Changes">
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- <END---EDUC> -->
                        <!-- <START---INTER> -->
                        <div class="tab-pane fade" id="my-intern" role="tabpanel">
                            <div class="main-details-wrap">
                                <div class="title-wrap">
                                    <p class="title-name">My interest</p>
                                </div>

                                <div class="main-detail-of-field-wrap">
                                    <div class="serach-genrens">
                                        <ul class="search-genres-list">
                                            @if($interest->count())
                                            @foreach($interest as $ik)
                                            @php
                                            echo '<li class="search-genres-list-item">'.$ik->title.' <a href="javascript:;" class="delete_interest" data-id="'.$ik->id.'"> <i class="fa fa-times"></i> </a></li>'
                                            @endphp
                                            @endforeach
                                            @endif
                                        </ul>
                                    </div>

                                    <div class="form-row first-group search-field">
                                        <div class="form-group col-md-12">
                                            <label for="user_interests" class="input-name">Add Interest</label>
                                            <input type="text" class="form-control" id="user_interests" name="user_interests" placeholder="e.g (Bycicle,Photography,shopping)">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="inputAddress" class="input-name" style="float:right"><b>* -- Mandatory fields</b></label>
                                        </div>
                                        <input type="hidden" id="interest_info" name="interest_info" class="hidden_form" value="0" >
                                        <div class="form-group col-md-4">
                                            <label for="blank_label" class="input-name">&nbsp;</label>
                                            <div class="save-btn-warp text-center">
                                                <input type="submit" class="save-btn" value="Save Changes">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- <END---INTER> -->
                        <!-- <START---ACCOUNT> -->

                        <!-- <END---ACCOUNT> -->
                        <!-- <START---PASSWORD> -->
                        <div class="tab-pane fade" id="change-password" role="tabpanel">
                            <div class="main-details-wrap">
                                <div class="title-wrap">
                                    <p class="title-name">Change Password</p>
                                </div>
                                <div class="main-detail-of-field-wrap">

                                    <div class="form-group first-group">
                                        <label for="old_password" class="input-name">Old Password*</label>
                                        <input type="password" class="form-control" id="old_password" name="old_password" placeholder="">
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="password" class="input-name">New Password*</label>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="confirmed" class="input-name">Confirm Password*</label>
                                            <input type="password" class="form-control" id="confirmed" name="confirmed" placeholder="">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="inputAddress" class="input-name" style="float:right"><b>* -- Mandatory fields</b></label>
                                        </div>
                                    </div>
                                    <input type="hidden" id="password_info" name="password_info" class="hidden_form" value="0" >
                                    <div class="save-btn-warp text-center">
                                        <input type="submit" class="save-btn" value="Save Changes">
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
{{ html()->closeModelForm() }}

@endsection

@push('after-scripts')
    {!! script('js/croppie.js') !!}
@endpush
