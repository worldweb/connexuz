<section class="conn-profile-details-main-section-wrap">
    <div class="">
        <div class="row">
            <div class="col-md-12">
                <div class="conn-profile-cover-img-section-wrap">
                    <img src="{{ $logged_in_user->cover_image }}" class="img-fluid conn-profile-cover-img cover_image">
                    <input type="file" name="cover_image" id="cover_image" accept=".png, .jpg, .jpeg" style="display:none">
                    <div class="upload-image-link-wrap cover_image_link_parent">
                        <a href="javascript:void(0)" class="upload-image-link" onclick="$('#cover_image').click()"><i class="fas fa-camera"></i></a>
                        <a href="javascript:;" id="openCoverImageCropPopup" data-toggle="modal" data-target="#coverImageCropPopup" style="display: none;"></a>
                    </div>
                    <div class="conn-profile-img-wrap-section">
                        <img src="{{ $logged_in_user->avatar_location }}" class="img-fluid conn-profile-cover-img-subimg rounded-circle">
                        <div class="upload-image-link-wrap">
                            <a href="javascript:void(0)"  class="upload-image-link" onclick="$('#profile_image').click()"><i class="fas fa-camera"></i></a>
                            <a href="javascript:;" id="openImageCropPopup" data-toggle="modal" data-target="#imageCropPopup" style="display: none;"></a>
                        </div>
                        <input type="file" name="profile_image" id="profile_image" accept=".png, .jpg, .jpeg" style="display:none">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- START PROFILE IMAGE MODAL POPUP -->
<div class="modal send-invitation-popup" id="imageCropPopup">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close modal-close-btn-abs" data-dismiss="modal">&times;</button>
            <div class="modal-body">
                <div class="col-md-12 text-center">
                    <div id="upload-demo" style="width:350px"></div>
                </div>
                <button class="btn btn-success upload-result">Save</button>
            </div>
        </div>
    </div>
</div>
<!-- START PROFILE IMAGE MODAL POPUP -->

<!-- START COVER IMAGE MODAL POPUP -->
<div class="modal single-post-poup" id="coverImageCropPopup">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close modal-close-btn-abs" data-dismiss="modal">&times;</button>
            <div class="modal-body">
                <div class="col-md-12 text-center">
                    <div id="cover-upload-demo" style="width:350px"></div>
                </div>
                <button class="btn btn-success cover-upload-save">Save</button>
            </div>
        </div>
    </div>
</div>
<!-- START COVER IMAGE MODAL POPUP -->

<script>
    $(document).on('click', '.conn-profile-img-wrap-section', function(){
        
        ('#profile_image').click();
    });
    
</script>