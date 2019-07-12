<section class="main-content-section">
    <div class="container">
        <!-- START-PROFILE-DETAILS-->
        <div class="conn-profile-details">
            <div class="row">
                <div class="col-md-4">
                    <div class="conn-profile-img-wrap">
                        <div class="connexuz-cover-img-wrap">
                            <img src="{{$logged_in_user->cover_image}}" class="img-fluid connexuz-cover-img">
                            <!-- <p class="conn-user-name">{{$logged_in_user->name}}</p> -->
                        </div>
                        <img src="{{$logged_in_user->avatar_location}}" class="img-fluid conn-user-img rounded-circle" width="70px" height="70px;">

                    </div>
                </div>
                <div class="col-md-8">
                    <div class="conn-profile-comments-wrap">
                        <div class="conn-profile-img-subwrap">
                            <img src="{{$logged_in_user->avatar_location}}" class="img-fluid conn-user-img rounded-circle" width="70px" height="70px;">
                        </div>
                        <div class="form-group conn-text-area">
                            {{ html()->textarea('description')
                                    ->class('form-control postModal customtextarea')
                                    ->placeholder('Post a comment, Picture or Video')
                                     }}
                        </div>
                        <div class="conn-profile-details-icon-wrap">
                            <a href="#" class="link-for link-for-edit" data-toggle="modal" data-target="#postCreate" data-backdrop="static" data-keyboard="false">
                                <i class="far fa-edit"></i>
                            </a>
                            <a href="#" class="link-for link-for-camera" data-toggle="modal" data-target="#postCreate" data-backdrop="static" data-keyboard="false" onclick="$('#post_image').click()">
                                <i class="fas fa-camera"></i>
                            </a>
                            <a href="#" class="link-for link-for-video" data-toggle="modal" data-target="#postCreate" data-backdrop="static" data-keyboard="false" onclick="$('#post_video').click()">
                                <i class="fas fa-video"></i>
                            </a>
<!--                            <a href="#" class="link-for link-for-location" data-toggle="modal" data-target="#postCreate" data-backdrop="static" data-keyboard="false">
                                <i class="fas fa-map-marker-alt"></i>
                            </a>-->
                        </div>
                        <div class="conn-profile-details-btn-wrap invite_frn_btn" style="display: none;">
                            <!-- <a href="#" class="conn-btn conn-publish-btn btn" data-toggle="modal" data-target="#postCreate" data-backdrop="static" data-keyboard="false">Publish</a> -->
                            <button class="btn btn-primary conn-invite-btn" data-toggle="modal" data-target="#SendInvite">Invite friends to Connexuz</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
