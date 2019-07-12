@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.frontend.page_title.interaction') )

@push('after-styles')
{{ style('css/owlcarousel/css/owl.carousel.min.css') }}
{{ style('css/owlcarousel/css/owl.theme.default.min.css') }}
@endpush

@section('content')

@include('frontend.interaction.top')
<style>
    span.deleteicon {
        position: relative;
    }
    span.deleteicon span {
        position: absolute;
        display: block;
        top: 5px;
        right: 0px;
        width: 16px;
        height: 16px;
        background: url('http://cdn.sstatic.net/stackoverflow/img/sprites.png?v=4') 0 -690px;
        cursor: pointer;
    }
    span.deleteicon input {
        padding-right: 16px;
        box-sizing: border-box;
    }
    .navbar-expand-lg .navbar-collapse {
        position: relative;
    }
    .mypost_reset.btn.btn-sm {
        position: absolute;
        bottom: -23px;
        left: 28%;
        padding: 0;
    }

    @media screen and (max-width:991px) {
        ul.navbar-nav {
            clear: both;
        }
    }
</style>
@if (session()->has('flash_success'))
@if(session()->get('flash_success') == 'Post added Successfully.')
<script>
    $(document).ready(function () {
        $("html, body").animate({
        scrollTop: $('#after_search_post').offset().top
        }, 'slow');
                $('input.deletable').wrap('<span class="deleteicon" />').after($('<span/>');
        $('body').on('click', '.deletable', function () {
//            alert(899);
            $(this).prev('input').val('').trigger('change').focus();
        })
        );
    });
</script>    
@endif
@endif

<!-- START MY friend POST SECTION -->
<section class="wp-main-post-listing-wrap-area " id="friendpost_search">
    <input type="hidden" id="frenpost_page_number" value="0" />
    <input type="hidden" id="frnposttotal_data" value="1" />

    <div class="container">

        <div class="wp-list-title-wrap">
            <div class="row">
                <div class="col-md-8 col-sm-7 col-6">
                    <div class="conn-my-post-details-title-wrap">
                        <h4 class="conn-my-post-details-title">My Friend Post</h4>
                    </div>
                </div>
                <div class="col-md-4 col-sm-5 col-6">
                    <div class="conn-invite-btn-wrap" style="clear:both;">
                        {{-- html()->form('POST', route('frontend.index'))->class('col-md-12')->id('friendposts_search_frontend')->open() --}}
                        <input class="form-control mr-sm-12 col-md-12 friendposts_search_frontend deletable" type="search" name="friendposts_search_frontend" placeholder="Filter post's by friend. Enter a name" value="{{$request->get('friendposts_search_frontend')}}" aria-label="Search" autocomplete="off">
                        <a class="friendpost_reset btn btn-sm" style="color:blue; float: right;"  >Reset</a>
                        {{-- html()->form()->close() --}}     
                    </div>
                </div>
            </div>
        </div>
        <div class="wp-scrollble-main-post-list-wrap" id="frenpostscroll">


        </div>
        <span style="display:none" class="div_loader" id="imgfrnposts"><img src="{{ asset('images/loader.gif') }}" /></span>
    </div>

    <script>
        $(document).ready(function () {

            var friendpost_input_val = $('.friendposts_search_frontend').val();
            if (friendpost_input_val == '') {
                $('.friendpost_reset').hide();
            } else {
                $('.friendpost_reset').show();
            }

            $(document).on('click', '.friendpost_reset', function () {
                $('.friendposts_search_frontend').val('');
                $('.friendpost_reset').hide();
                frnpostsajax();
            });

            $('.invite_frn_btn').show();    // Invite friends to Connexuz Button show

            var csrftoken = $('meta[name="csrf-token"]').attr('content');
            var frnpost_total_data = $("#frnposttotal_data").val();

            $('.friendposts_search_frontend').keypress(function (e) {
                $('.friendpost_reset').show();
                if (e.keyCode == 13) {
                    $('#frenpost_page_number').val('0');
                    $("#frnposttotal_data").val('1');
                    frnpostsajax();
                }
            });

            if (frnpost_total_data > 0) {
                frnpostsajax();
            }

            function frnpostsajax() {
                var csrftoken = $('meta[name="csrf-token"]').attr('content');
                var friendposts_search_frontend = $('.friendposts_search_frontend').val();
                if (friendposts_search_frontend == '') {
                    $('#frenpost_page_number').val('0');
                }

                $.ajax({
                    type: 'POST',
                    url: '{{route("frontend.ajax_friendposts","ajax_friendposts")}}',
                    data: {"_token": csrftoken, pageNumber: $('#frenpost_page_number').val(), frnsearchdata: $('.friendposts_search_frontend').val()},
                    beforeSend: function () {
                        $('#imgfrnposts').fadeIn();
                    },
                    success: function (data) {
                        $('#imgfrnposts').fadeOut();
                        var get_frenpost_page = parseInt($('#frenpost_page_number').val()) + parseInt("{{$pagelimit}}");
                        $('#frenpost_page_number').val(get_frenpost_page);
                        $("#frenpostscroll").html(data.html);
                        $("#frnposttotal_data").val(data.total_data);
                        $("#frenpostscroll").scrollTop('0px');

                    }
                });
            }

            $("#frenpostscroll").scroll(function () {
                if ($(this).scrollTop() >= $(this)[0].scrollHeight - 500) {
                    var frnpost_total_data = $("#frnposttotal_data").val();
                    if (frnpost_total_data > 0) {
                        $.ajax({
                            type: 'POST',
                            url: '{{route("frontend.ajax_friendposts","ajax_friendposts")}}',
                            data: {"_token": csrftoken, pageNumber: $('#frenpost_page_number').val(), frnsearchdata: $('.friendposts_search_frontend').val()},
                            beforeSend: function () {
                                $('#imgfrnposts').fadeIn();
                            },
                            success: function (data) {
                                $('#imgfrnposts').fadeOut();

                                var get_frenpost_page = parseInt($('#frenpost_page_number').val()) + parseInt("{{$pagelimit}}");
                                $('#frenpost_page_number').val(get_frenpost_page);
                                if (data.total_data) {
                                    $("#frenpostscroll").append(data.html);
                                }
                                $("#frnposttotal_data").val(data.total_data);
                            }
                        });
                    }
                }
            });
        });

    </script>

</section>
<!-- END MY Friend POST SECTION -->

<div class="container">
    <hr class="section-full-devider"/>
</div>

<!-- START MY POST SECTION -->
<section class="wp-main-post-listing-wrap-area" id="after_search_post">
    <input type="hidden" id="mypost_page_number" value="0" />
    <input type="hidden" id="myposttotal_data" value="1" />
    <div class="container">
        <div class="wp-list-title-wrap">
            <div class="row">
                <div class="col-md-10 col-sm-9 col-8">
                    <div class="conn-my-post-details-title-wrap">
                        <h4 class="conn-my-post-details-title">My Post</h4>
                    </div>
                </div>

                <!--                <div class="col-md-2 col-sm-3 col-4">
                                    <div class="conn-invite-btn-wrap">
                                        <button class="btn btn-primary conn-invite-btn" data-toggle="modal" data-target="#SendInvite">Invites</button>
                                    </div>
                                </div>-->
            </div>
        </div>
        <div class="wp-scrollble-main-post-list-wrap" id="mypostsscroll">

        </div>
        <span style="display:none" class="div_loader" id="imgmyposts"><img src="{{ asset('images/loader.gif') }}" /></span>
    </div>

    <script>
        $(document).ready(function () {
            $('.mypost_reset').hide();
            var csrftoken = $('meta[name="csrf-token"]').attr('content');
            var myposttotal_data = $("#myposttotal_data").val();



            $(document).on('keyup', '.posts_search_header', function () {

                if ($(this).val() != '') {
                    $('.mypost_reset').show();
                } else {
                    $('.mypost_reset').hide();
                }
            });


            $(document).on('click', '.mypost_reset', function () {
                $('.posts_search_header').val('');
                $('.mypost_reset').hide();
                mypostsajax();
                $('html, body').animate({
                    scrollTop: $('#after_search_post').offset().top
                }, 'slow');
            });

            $('.posts_search_header').keypress(function (e) {
                if (e.keyCode == 13) {
                    $('#mypost_page_number').val('0');
                    $("#myposttotal_data").val('1');
                    mypostsajax();
                    $('html, body').animate({
                        scrollTop: $('#after_search_post').offset().top
                    }, 'slow');
                }
            });

            if (myposttotal_data > 0) {
                mypostsajax();
            }

            function mypostsajax() {
                var csrftoken = $('meta[name="csrf-token"]').attr('content');
                var myposts_search_frontend = $('.posts_search_header').val();
                if (myposts_search_frontend == '') {
                    $('#mypost_page_number').val('0');
                }

                $.ajax({
                    type: 'POST',
                    url: '{{route("frontend.ajax_myposts","ajax_myposts")}}',
                    data: {"_token": csrftoken, pageNumber: $('#mypost_page_number').val(), posts_search_header: $('.posts_search_header').val()},
                    beforeSend: function () {
                        $('#imgmyposts').fadeIn();
                    },
                    success: function (data) {
                        $('#imgmyposts').fadeOut();
                        var get_frenpost_page = parseInt($('#mypost_page_number').val()) + parseInt("{{$pagelimit}}");
                        $('#mypost_page_number').val(get_frenpost_page);
                        $("#mypostsscroll").html(data.html);
                        $("#myposttotal_data").val(data.total_data);
                        $("#mypostsscroll").scrollTop('0px');

                    }
                });
            }

            $("#mypostsscroll").scroll(function () {

                if ($(this).scrollTop() >= $(this)[0].scrollHeight - 500) {
                    var myposttotal_data = $("#myposttotal_data").val();

                    if (myposttotal_data > 0) {
                        $.ajax({
                            type: 'POST',
                            url: '{{route("frontend.ajax_myposts","ajax_myposts")}}',
                            data: {"_token": csrftoken, pageNumber: $('#mypost_page_number').val(), posts_search_header: $('.posts_search_header').val()},
                            beforeSend: function () {
                                $('#imgmyposts').fadeIn();
                            },
                            success: function (data) {
                                $('#imgmyposts').fadeOut();
                                var get_frenpost_page = parseInt($('#mypost_page_number').val()) + parseInt("{{$pagelimit}}");
                                $('#mypost_page_number').val(get_frenpost_page);
                                if (data.total_data) {
                                    $("#mypostsscroll").append(data.html);
                                }
                                $("#myposttotal_data").val(data.total_data);
                            }
                        });
                    }
                }
            });
        });
    </script>
</section>
<!-- END MY POST SECTION -->
<script>
    $(document).on('click', '.postLike', function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var u_id = $(this).data("id");

        $.ajax({
            url: "post/add-like",
            method: 'post',
            data: {
                i_id: u_id
            },
            success: function (result) {
                if (result.success) {
                    $('#postLike-' + u_id).addClass('active');
                } else {
                    $('#postLike-' + u_id).removeClass('active');
                }
            }
        });
    });
    $(document).on('click', '.commentLike', function () {
//$(".commentLike").click(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var u_id = $(this).data("id");
        var p_id = $(this).data("post");

        $.ajax({
            url: "comment/add-like",
            method: 'post',
            data: {
                c_id: u_id,
                p_id: p_id
            },
            success: function (result) {
                if (result.success) {
                    $('#comment-' + u_id).addClass('active');
                } else {
                    $('#comment-' + u_id).removeClass('active');
                }
            }
        });
    });
</script>
<!-- The Modal -->
<div class="modal fade" id="postModal">
    <div class="modal-dialog modal-lg">
        <!--  Loader  -->
        <div id="popUpLoader">
            <div class="widget-loader"><div class="load-dots"><span></span><span></span><span></span></div></div>
        </div>
        <!--  Loader  -->
        <div class="modal-content align-content-center">
            <button type="button" class="close modal-close-btn-abs" data-dismiss="modal">&times;</button>
            <!-- Modal body -->
            <div class="modal-body" id="posts-data">
                {{-- body will be render from news.blade.php from popup --}}
            </div>
        </div>
    </div>
</div>

@push('after-scripts')

{!! script('css/owlcarousel/js/owl.carousel.min.js') !!}

<script>
    $(document).on('click', '.post_btn_comment', function () {
        var postcomment = $('.mainpost_comment').val();
        if (postcomment == '') {
            $('.error_postcomment').attr('style', 'border-color:red');
        } else {
            $('#comment-form').submit();
        }
    });

    $(document).on("click", ".posts-view-popup", function () {
        var id = $(this).data('id');
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "POST",
            url: '{{route("frontend.post.view")}}',
            data: "id=" + id,
            success: function (data) {
                $("#posts-data").html(data.postsDetailHtml);
                $("#popUpLoader .widget-loader").hide();
            }
        });
    });
    $('.user-post-img-video-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        mouseDrag: false,
        dots: false,
        autoplay: false,
        URLhashListener: true,
        video: true,
        lazyLoad: true,
        autoplayTimeout: 5000,
        onTranslate: function () {
            $('.owl-item').find('video').each(function () {
                this.pause();
            });
        },
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    });
</script>
@endpush
@endsection

@section('popup')
@include('frontend.popup.invite')
@include('frontend.popup.create-post')
@endsection
