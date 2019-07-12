<!-- START SEND Add Post MODAL POPUP -->

<div class="modal social-post-popup" id="postCreate">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close modal-close-btn-abs" data-dismiss="modal">&times;</button>
            <div class="modal-body">
                <div class="post_comment_error" style="display: none; color: red; font-size: 14px; margin-bottom: 10px;">Please fillup any one field, Description OR Upload Image OR Upload Video<br></div>
                <div class="post-social-form-wrap">
                    {{ html()->form('POST', route('frontend.post.create'))->class('post-social-form')->id('addPost-form')->attribute('enctype', 'multipart/form-data')->open() }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ html()->textarea('post_description')
                                        ->class('form-control post_description_ckeditor')
                                        ->placeholder('Write what u wish')
                                        ->id('exampleFormControlTextarea')
                                }}
                            </div>
                        </div>
                    </div>
                    <!-- Start Image Preview Thumb -->
                    <div class="row">
                        <span id="file_error"></span>
                        <div class="col-md-12">
                            <div class="form-group img-preview">

                            </div>
                        </div>
                    </div>
                    <!-- End Image Preview Thumb -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="conn-profile-details-icon-wrap">
                                            <a href="javascript:void(0);" class="link-for link-for-camera">
                                                <input type="file" name="post_image[]" id="post_image" class="post_image" accept=".png, .jpg, .jpeg" multiple>
                                                <i class="fas fa-camera"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="link-for link-for-video">
                                                <input type="file" name="post_video[]" id="post_video" class="post_video" accept=".mp4" multiple>
                                                <i class="fas fa-video"></i>
                                            </a>
                                            <!--                                                <a href="javascript:void(0);" class="link-for link-for-location">
                                                                                                <i class="fas fa-map-marker-alt"></i>
                                                                                            </a>-->
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        {{ form_submit('Publish')->class('btn send-invitation-btn') }}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    {{ html()->form()->close() }}
                </div>
            </div>
            <div id="output"></div>
        </div>
    </div>
</div>
<!-- END SEND INVITATION MODAL POPUP -->
<script>
    
//    $(document).on('blur','.post_description_ckeditor',function(){
//        var textbox_data = CKEDITOR.instances.exampleFormControlTextarea.getData();
//        if (textbox_data===''){
//            $('.post_comment_error').show();
//            $('.send-invitation-btn').attr('type', 'button');
//            return false;
//        }else{
//            $('.send-invitation-btn').attr('type', 'submit');
//            $('.post_comment_error').hide();
//        }
//    });
    
//    $(document).on('click','.send-invitation-btn',function(){
//        
//        var textbox_data = CKEDITOR.instances.exampleFormControlTextarea.getData();
//        if (textbox_data===''){
//            $('.post_comment_error').show();
//            return false;
//        }else{
//            $('.post_comment_error').hide();
//        }
//        
//    });
    
    $(document).ready(function () {
//        $('.send-invitation-btn').attr('type', 'button');
        /* $('#addPost-form').validate({
         rules: {
         post_description: {
         required: true
         },
         }
         });*/

        var selDiv = "";
        var storedFiles = [];

        $(function () {
            // Multiple images preview in browser
            var imagesPreview = function (input, placeToInsertImagePreview) {

                if (input.files) {
//                    var filesAmount = input.files.length;
                    var filesAmount = 1;
                    $("<div class=\"gallery\">").appendTo(placeToInsertImagePreview);
                    for (var i = 0; i < filesAmount; i++) {
                        var reader = new FileReader();

                        reader.onload = function (event) {

                            $("<span class=\"single-updated-img\">" + "<img class=\"imageThumb\" src=\"" + event.target.result + "\" title=\"" + event.target.name + "\"/>" + "<i class=\"fas fa-times remove\"></span>" + "</i></span>").appendTo('div.gallery');

                            //$($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);

                            $(".remove").click(function () {
                                var file = $(this).parent(".imageThumb");
                                $(this).parent(".single-updated-img").remove();
                                for (var i = 0; i < storedFiles.length; i++) {
                                    if (storedFiles[i].name === file) {
                                        storedFiles.splice(i, 1);
                                        break;
                                    }
                                }
                            });
                            storedFiles.push(event.target);
                        }

                        reader.readAsDataURL(input.files[i]);
                    }
                    $("</div>").appendTo(placeToInsertImagePreview);
                }
            };

            function readURL(input) {

                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (event) {
                        $('.img-preview').html("<div class=\"gallery\"><span class=\"single-updated-img\">" + "<img class=\"imageThumb\" src=\"" + event.target.result + "\" title=\"" + event.target.name + "\"/>" + "<i class=\"fas fa-times remove\"></span>" + "</i></span></div>");
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            function loadMime(file, callback) {

                //List of known mimes
                var mimes = [
                    {
                        mime: 'image/jpeg',
                        pattern: [0xFF, 0xD8, 0xFF],
                        mask: [0xFF, 0xFF, 0xFF],
                    },
                    {
                        mime: 'image/png',
                        pattern: [0x89, 0x50, 0x4E, 0x47],
                        mask: [0xFF, 0xFF, 0xFF, 0xFF],
                    },
                    {
                        mime: 'image/gif',
                        pattern: [0x47, 0x49, 0x46, 0x38, 0x37, 0x61],
                        mask: [0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF],
                    },
                    {
                        mime: 'image/gif',
                        pattern: [0x47, 0x49, 0x46, 0x38, 0x39, 0x61],
                        mask: [0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF],
                    },
                    {
                        mime: 'image/bmp',
                        pattern: [0x42, 0x4D],
                        mask: [0xFF, 0xFF],
                    },
                    {
                        mime: 'image/x-icon',
                        pattern: [0x00, 0x00, 0x01, 0x00],
                        mask: [0xFF, 0xFF, 0xFF, 0xFF],
                    },
                    {
                        mime: 'image/x-icon',
                        pattern: [0x00, 0x00, 0x02, 0x00],
                        mask: [0xFF, 0xFF, 0xFF, 0xFF],
                    },
                    {
                        mime: 'image/webp',
                        pattern: [0x52, 0x49, 0x46, 0x46, 0x00, 0x00, 0x00, 0x00, 0x57, 0x45, 0x42, 0x50, 0x56, 0x50],
                        mask: [0xFF, 0xFF, 0xFF, 0xFF, 0x00, 0x00, 0x00, 0x00, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF],
                    },
                ];

                function check(bytes, mime) {
                    for (var x = 0, l = mime.mask.length; x < l; ++x) {
                        if ((bytes[x] & mime.mask[x]) - mime.pattern[x] !== 0) {
                            return false;
                        }
                    }
                    return true;
                }

                var blob = file.slice(0, 4); //read the first 4 bytes of the file

                var reader1 = new FileReader();
                reader1.onloadend = function (e) {
                    if (e.target.readyState === FileReader.DONE) {
                        var bytes = new Uint8Array(e.target.result);
                        for (var i = 0, l = mimes.length; i < l; ++i) {
                            if (check(bytes, mimes[i])){
//                                return callback("Mime: " + mimes[i].mime + " <br> Browser:" + file.type);
                                return true;
                            }
                        }

                        return callback("unknown");
                    }
                };
                reader1.readAsArrayBuffer(blob);
            }


//when selecting a file on the input
            $('#post_image').on('change', function () {
                
                var flag = 1;
                $("#file_error").html("");
                    var file_size = $(this)[0].files[0].size;
                    if (file_size > 10485760) {
                        $("#file_error").html('<span style="color:red">File size should be less than 10MB<span>');
                        $('.send-invitation-btn').attr('type', 'button');

                        return false;
                    } else {
                        
                        loadMime(this.files[0], function (mime) {
                            
                            if(mime == 'unknown'){
                                $("#file_error").html('<span style="color:red">Only jpg, jpeg, png files allow.<span>');
                                $('.send-invitation-btn').attr('type', 'button');
                                flag = 0;
                            }else{
                                flag = 1;
                            }
                        });
                        
                        if(flag){
                            $('.send-invitation-btn').attr('type', 'submit');
                            $("#file_error").html('');
                            readURL(this);
                        }
                    }
                    
                return true;
            });

            $('#post_imagedfsf').on('change', function () {
//                imagesPreview(this, 'div.img-preview');
                $("#file_error").html("");
                var file_size = $(this)[0].files[0].size;
                if (file_size > 10485760) {
                    $("#file_error").html('<span style="color:red">File size should be less than 10MB<span>');
                    $('.send-invitation-btn').attr('type', 'button');

                    return false;
                } else {
                    $('.send-invitation-btn').attr('type', 'submit');
                    $("#file_error").html('');
                    readURL(this);
                }

                return true;


            });

            $(document).on('click', '.remove', function () {
                var file = $(this).parent(".single-updated-img");
                file.parent(".gallery").remove();
                for (var i = 0; i < storedFiles.length; i++) {
                    if (storedFiles[i].name === file) {
                        storedFiles.splice(i, 1);
                        break;
                    }
                }
            });
        });

        // Set Target _blank when using link
        CKEDITOR.on('dialogDefinition', function (ev) {
            // Take the dialog name and its definition from the event data.
            var dialogName = ev.data.name;
            var dialogDefinition = ev.data.definition;

            if (dialogName == 'link') {
                var targetTab = dialogDefinition.getContents('target');
                // Set the default value for the URL field.
                var targetField = targetTab.get('linkTargetType');
                var targetName = targetTab.get('linkTargetName');
                targetField[ 'default' ] = '_blank';
                targetName[ 'default' ] = '_blank';
            }
        });
        // Set Target _blank when using link End

        CKEDITOR.replace('post_description', {
            toolbarGroups: [
                {name: 'clipboard', groups: ['clipboard', 'undo']}, // Group's name will be used to create voice label.
                {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
                {name: 'colors'},
                {name: 'links'},
                {name: 'styles'},
            ],
            removePlugins: 'elementspath'
        });

    });
</script>
