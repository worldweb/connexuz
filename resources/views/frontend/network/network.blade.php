@extends('frontend.layouts.app')
@section('title', app_name() . ' | ' . __('labels.frontend.page_title.network'))
@section('content')
@include('frontend.interaction.top')

<span id="loggedin_user_id">{{ $userId }}</span>
<!-- START-SEARCH-FRIENDS-SECTION -->
<section class="wp-main-post-listing-wrap-area">
    <div class="container">
        <div class="conn-my-frd-main-section-wrap">
            <div class="row">
                <div class="col-md-6">
                    <div class="connexus-networks-tab-wrap-box">
                        <ul class="connexus-networks-tab-listing">
                            <li class="connexus-networks-tab-list active" id="my_friends_tab">My Friends</li>
                            <li class="connexus-networks-tab-list" id="my_requests_tab">My Friend Requests</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3 offset-md-3">
                    <div class="wp-connexus-search-friends-friendlist">
                        <form class="form-inline">
                            <input class="form-control mr-sm-2 col-md-12" type="search" placeholder="Search Friends.." aria-label="Search" id="search_box">
                            <button type="button" class="search-friend-bnt btn-primary" id="search_button"><i class="fas fa-search"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="my-friends-tab-content all_close">
                <div class="conn-my-frd-section">
                    <div class="row">
                        @if($myFriends->count())
                        @foreach($myFriends as $mfk)
                        <div class="col-md-4">
                            <div class="conn-my-frd-section-details-wrap">
                                <div class="conn-my-frd-section-img-wrap">
                                    @if($mfk->cover_image != '')
                                    <img src="{{ $mfk->cover_image }}" class="img-fluid conn-my-frd-cover-img" width="100%">
                                    @else
                                    <img src="{{ url('storage/avatars/default_cover_img.png') }}" class="img-fluid conn-my-frd-cover-img" width="100%">
                                    @endif
                                    
                                </div>
                                <div class="conn-my-frd-section-profile-img-wrap">
                                    @if($mfk->avatar_location != '')
                                    <img src="{{ $mfk->avatar_location }}" class="img-fluid conn-user-img rounded-circle">
                                    @else
                                    <img src="{{ url('storage/avatars/default_profile_img.png') }}" class="img-fluid conn-user-img rounded-circle">
                                    @endif
                                    <p><a href="user/friend/{{ $mfk->invite_user_id }}" class="conn-frd-section-name">{{ $mfk->first_name }} {{ $mfk->last_name }}</a></p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                        @if($myAcceptedFriends->count())
                        @foreach($myAcceptedFriends as $mafk)
                        <div class="col-md-4">
                            <div class="conn-my-frd-section-details-wrap">
                                <div class="conn-my-frd-section-img-wrap">
                                    @if($mafk->cover_image != '')
                                    <img src="{{ $mafk->cover_image }}" class="img-fluid conn-my-frd-cover-img" width="100%">
                                    @else
                                    <img src="{{ url('storage/avatars/default_cover_img.png') }}" class="img-fluid conn-my-frd-cover-img" width="100%">
                                    @endif
                                    
                                </div>
                                <div class="conn-my-frd-section-profile-img-wrap">
                                    @if($mafk->avatar_location != '')
                                    <img src="{{ $mafk->avatar_location }}" class="img-fluid conn-user-img rounded-circle">
                                    @else
                                    <img src="{{ url('storage/avatars/default_profile_img.png') }}" class="img-fluid conn-user-img rounded-circle">
                                    @endif
                                    
                                    <p><a href="user/friend/{{ $mafk->user_id }}" class="conn-frd-section-name">{{ $mafk->first_name }} {{ $mafk->last_name }}</a></p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="my-requests-tab-content all_close">
                <div class="conn-my-frd-section">
                    <div class="row">
                        @if($myRequests->count())
                        
                        @foreach($myRequests as $mrk)

                        <div class="col-md-6" id="my_request_friend_{{ $mrk->uinvite_id }}">
                            <div class="connexuz-my-requests-block-wrap">
                                <div class="row">
                                    <div class="col-md-7 col-sm-6">
                                        <div class="row">
                                            <div class="col-md-4 col-5">
                                                <div class="my-request-user-image-wrap">
                                                    <img src="{{ $mrk->avatar_location }}" class="img-fluid my-request-user-image"/>
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-7">
                                                <div class="my-request-username-wrap">
                                                    <h3 class="my-request-username"><a href="user/friend/{{ $mrk->id }}">{{ $mrk->first_name }} {{ $mrk->last_name }}</a></h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-6">
                                        <div class="row">
                                            <div class="col-md-6 col-6 custom-paddinng-action-buttons">
                                                <a href="javascript:;" data-action="accept_friend" data-user-id="{{ $mrk->id }}"  data-uinvite-id="{{ $mrk->uinvite_id }}" class="btn my-request-btn confirm-btn">Accept</a>
                                            </div>
                                            <div class="col-md-6 col-6 custom-paddinng-action-buttons">
                                                <a href="javascript:;" data-action="reject_friend" data-user-id="{{ $mrk->id }}"  data-uinvite-id="{{ $mrk->uinvite_id }}" class="btn my-request-btn delete-btn">Reject</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>


            <div class="search-friend-tab-content all_close">
                <div class="conn-my-frd-section">
                    <div class="row append_search_result">

                    </div>
                     <div class="load_more_parent">
                        <a href="javascript:;" id="load_more" data-page="1">Load more</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END-SEARCH-FRIENDS-SECTION -->
@endsection

@section('popup')
    @include('frontend.popup.create-post')
@endsection
