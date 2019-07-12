@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.frontend.page_title.interaction') )

@push('after-styles')
    {{ style('css/owlcarousel/css/owl.carousel.min.css') }}
    {{ style('css/owlcarousel/css/owl.theme.default.min.css') }}
@endpush

@section('content')

    @include('frontend.interaction.top')
    <!-- START MY POST SECTION -->
    <section class="wp-main-post-listing-wrap-area">
        <div class="container">
            <div class="wp-list-title-wrap">
                <div class="row">
                    <div class="col-md-10 col-sm-9 col-8">
                        <div class="conn-my-post-details-title-wrap">
                            <h4 class="conn-my-post-details-title">My Post</h4>
                        </div>
                    </div>

                    <div class="col-md-2 col-sm-3 col-4">
                        <div class="conn-invite-btn-wrap">
                            <button class="btn btn-primary conn-invite-btn" data-toggle="modal" data-target="#SendInvite">Invites</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wp-scrollble-main-post-list-wrap">
                @if(count($myPostData)>0)
                    @foreach($myPostData as $myPost)
                        @php
                            $post_type = 'text';
                            $cl = "";
                        @endphp
                         @if(count($myPost->post_images) > 0)
                            @php $cl = "wp-single-img-video"; @endphp
                         @endif
                        <div class="wp-single-post-list {{$cl}}">
                            <div class="row m-0">

                                <div class="col-md-6 p-0">
                                    @if(count($myPost->post_images) > 0)
                                        <div class="conn-my-post-img-wrap" type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">

                                            <div class="owl-carousel owl-theme user-post-img-video-carousel">
                                                @foreach($myPost->post_images as $media)
                                                    @if($media->type == 'video')
                                                        <div class="item">
                                                            <video width="100%" controls id="video-one">
                                                                <source src="{{asset('video/post/'.$myPost->id.'/'.$media->name)}}" type="video/mp4">

                                                                Your browser does not support HTML5 video.
                                                            </video>
                                                        </div>
                                                    @else
                                                        <div class="item">
                                                            <img src="{{asset('images/post/'.$myPost->id.'/'.$media->name)}}" class="img-fluid">
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        @php
                                            $post_type = 'media';
                                        @endphp
                                    @else
                                        <div class="wp-single-post-content-wrap-area">
                                            <div class="wp-single-post-content-wrap">
                                                <div class="media">
                                                <?php 
                                                $headers = @get_headers($myPost->user->avatar_location);
                                                if($headers && $headers[0] != 'HTTP/1.1 404 Not Found')
                                                {
                                                    $url_exist = true;
                                                }
                                                else
                                                {
                                                    $url_exist = false;
                                                }
                                                ?>
                                                @if($url_exist)
                                                    <img src="{{$myPost->user->avatar_location}}" alt="{{$myPost->user->name}}" class="mr-3 mt-1 rounded-circle" width="40px">
                                                @else
                                                    <img src="{{ asset('images/user.png') }}" alt="{{$myPost->user->name}}" class="mr-3 mt-1 rounded-circle" width="40px">
                                                @endif
                                                    <div class="media-body">
                                                        <div class="conn-my-post-details-user-title">
                                                            <h5 class="publisher-name-text">{{$myPost->user->first_name.' '.$myPost->user->last_name}} </h5>
                                                            <p class="published-time-ago-text">Published at {{ $myPost->created_at->diffForHumans() }}</p>
                                                        </div>
                                                        <div class="conn-like-unlike-icon-wrap">
                                                            <span class="conn-like-icon"><a href="javascript:void(0);" id="postLike-{{$myPost->id}}" class="{{(getPostUserLike($myPost->user_id,$myPost->id))?'postLike active':'postLike'}}" data-id="{{$myPost->id}}" ><i class="fas fa-thumbs-up"> </i> Like</a>
                                                                @if(!empty($myPost->post_likes) && count($myPost->post_likes) > 0)
                                                                    <div class="wp-total-likes-name-and-count">
                                                                        @foreach($myPost->post_likes as $items)
                                                                            <span>{{$items->user->first_name.' '.$items->user->last_name}}</span>
                                                                        @endforeach
                                                                        @if(count($myPost->post_likes) > 5)
                                                                        <span>.. {{count($myPost->post_likes) - 5}} more</span>
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                            </span>
                                                            <!-- <span class="conn-unlike-icon"><a href="#"><i class="fas fa-thumbs-down"> 0</i></a></span> -->
                                                            <span class="expand-post-btn-icon"><a href="javascript:void(0)" title="Read more" class="r-bttn posts-view-popup" data-toggle="modal" data-target="#postModal" data-id="{{$myPost->id}}" data-placement="top"><i class="fas fa-expand"></i></a></span>
                                                        </div>

                                                        <div class="conn-my-post-commemnt-content">
                                                            {!! $myPost->description !!}</div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6 p-0">
                                    <div class="wp-single-post-content-wrap-area">
                                        @if($post_type == 'media')
                                            <div class="wp-single-post-content-wrap">
                                                <div class="media">
                                                <?php 
                                                $headers = @get_headers($myPost->user->avatar_location);
                                                if($headers && $headers[0] != 'HTTP/1.1 404 Not Found')
                                                {
                                                    $url_exist = true;
                                                }
                                                else
                                                {
                                                    $url_exist = false;
                                                }
                                                ?>
                                                @if($url_exist)
                                                    <img src="{{$myPost->user->avatar_location}}" alt="{{$myPost->user->name}}" class="mr-3 mt-1 rounded-circle" width="40px">
                                                @else
                                                    <img src="{{ asset('images/user.png') }}" alt="{{$myPost->user->name}}" class="mr-3 mt-1 rounded-circle" width="40px">
                                                @endif
                                                    
                                                    <div class="media-body">
                                                        <div class="conn-my-post-details-user-title">
                                                            <h5 class="publisher-name-text">{{$myPost->user->first_name.' '.$myPost->user->last_name}} </h5>
                                                            <p class="published-time-ago-text">Published about {{ $myPost->created_at->diffForHumans() }}</p>
                                                        </div>
                                                        <div class="conn-like-unlike-icon-wrap">
                                                            <span class="conn-like-icon"><a href="javascript:void(0);" id="postLike-{{$myPost->id}}" class="{{(getPostUserLike($myPost->user_id,$myPost->id))?'postLike active':'postLike'}}" data-id="{{$myPost->id}}" ><i class="fas fa-thumbs-up"> </i> Like</a>
                                                                @if(!empty($myPost->post_likes) && count($myPost->post_likes) > 0)
                                                                    <div class="wp-total-likes-name-and-count">
                                                                        @foreach($myPost->post_likes as $items)
                                                                            <span>{{$items->user->first_name.' '.$items->user->last_name}}</span>
                                                                        @endforeach
                                                                        @if(count($myPost->post_likes) > 5)
                                                                        <span>.. {{count($myPost->post_likes) - 5}} more</span>
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                            </span>
                                                            <!-- <span class="conn-unlike-icon"><a href="#"><i class="fas fa-thumbs-down"> 0</i></a></span> -->
                                                            <span class="expand-post-btn-icon"><a href="javascript:void(0)" title="Read more" class="r-bttn posts-view-popup" data-toggle="modal" data-target="#postModal" data-id="{{$myPost->id}}" data-placement="top"><i class="fas fa-expand"></i></a></span>
                                                        </div>
                                                        <p class="conn-my-post-commemnt-content">
                                                        <div class="conn-my-post-commemnt-content">
                                                           {!! $myPost->description !!}</div>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if(count($myPost->post_comments)>0)
                                            @php $post_comments = $myPost->post_comments @endphp
                                            <div class="wp-single-post-comment-listing-wrap">
                                                @foreach($myPost->post_comments as $comment)
                                                    <div class="single-media-comment-list">
                                                        <div class="media">
                                                        <?php 
                                                        $headers = @get_headers($comment->user->avatar_location);
                                                        if($headers && $headers[0] != 'HTTP/1.1 404 Not Found')
                                                        {
                                                            $url_exist = true;
                                                        }
                                                        else
                                                        {
                                                            $url_exist = false;
                                                        }
                                                        ?>
                                                        @if($url_exist)
                                                            <img src="{{$comment->user->avatar_location}}" alt="{{$comment->user->name}}" class="mr-3 mt-1 rounded-circle" width="40px">
                                                        @else
                                                            <img src="{{ asset('images/user.png') }}" alt="{{$comment->user->name}}" class="mr-3 mt-1 rounded-circle" width="40px">
                                                        @endif
                                                            
                                                            <div class="media-body">
                                                                <div class="conn-my-post-details-user-title">
                                                                    <h5 class="publisher-name-text">
                                                                        {{getUserName($comment->user_id)}}
                                                                        <span class="comments-text-content">
                                                                            {!! $comment->description !!}
                                                                        </span>
                                                                        <div class="like-comment-replay-wrap-boxx">
                                                                            <a href="javascript:void(0);" id="comment-{{$comment->id}}" class="{{(getCommentUserLike($comment->user_id,$comment->id))?'like-comment-replay-link lin commentLike active':'like-comment-replay-link lin commentLike'}}" data-id="{{$comment->id}}" data-post="{{$myPost->id}}" ><i class="fas fa-thumbs-up"> </i> Like</a>
                                                                            @if($comment->user_id != $logged_in_user->id)
                                                                            <a href="javascript:void(0);" class="like-comment-replay-link link replay_comment"><i class="fas fa-reply"></i> Reply</a>
                                                                            @endif
                                                                        </div>
                                                                        @if(!empty($comment->replay_comment) && count($comment->replay_comment)>0)
                                                                        @foreach($comment->replay_comment as $replay_comments)
                                                                        <div class="single-media-comment-list">
			<div class="media">
            <?php 
            $headers = @get_headers($replay_comments->user->avatar_location);
            if($headers && $headers[0] != 'HTTP/1.1 404 Not Found')
            {
                $url_exist = true;
            }
            else
            {
                $url_exist = false;
            }
            ?>
            @if($url_exist)
                <img src="{{$replay_comments->user->avatar_location}}" alt="{{$replay_comments->user->name}}" class="mr-3 mt-1 rounded-circle" width="40px">
            @else
                <img src="{{ asset('images/user.png') }}" alt="{{$replay_comments->user->name}}" class="mr-3 mt-1 rounded-circle" width="40px">
            @endif
                
                <div class="media-body">
					<div class="conn-my-post-details-user-title">
						<h5 class="publisher-name-text">
							{{getUserName($replay_comments->user_id)}}
							<span class="comments-text-content">
								{!! $replay_comments->description !!}
							</span>
						</h5>
					</div>
				</div>
</div>
</div>
                                                                        @endforeach
                                                                        @endif
                                                                        @if($comment->user_id != $logged_in_user->id)
                                                                        <div class="wp-single-poste-single-commemnt-replay-wrap replay-form">
                                                                <div class="wp-single-poste-single-commemnt-replay-img-wrap">
                                                                <?php 
                                                                $headers = @get_headers($logged_in_user->avatar_location);
                                                                if($headers && $headers[0] != 'HTTP/1.1 404 Not Found')
                                                                {
                                                                    $url_exist = true;
                                                                }
                                                                else
                                                                {
                                                                    $url_exist = false;
                                                                }
                                                                ?>
                                                                @if($url_exist)
                                                                    <img src="{{$logged_in_user->avatar_location}}" alt="{{$logged_in_user->name}}" class="mr-3 mt-1 rounded-circle" width="40px">
                                                                @else
                                                                    <img src="{{ asset('images/user.png') }}" alt="{{$logged_in_user->name}}" class="mr-3 mt-1 rounded-circle" width="40px">
                                                                @endif
                                                                </div>
                                                                <div class="wp-single-poste-single-commemnt-replay-form-wrap">
                                                                {{ html()->form('POST', route('frontend.post.comment.send'))->class('post-comment-form')->id('replay-comment-form')->open() }}

                                                                        {{ html()->textarea('post_comment')
                                                                        ->class('form-control')
                                                                        ->placeholder('Post a Comment')
                                                                        ->attributes(['rows' =>'1'])
                                                                        }}
                                                                    {{ html()->hidden('post_id')
                                                                        ->value($myPost->id)
                                                                        }}
                                                                    {{ html()->hidden('user_id')
                                                                        ->value($myPost->user_id)
                                                                        }}
                                                                        {{ html()->hidden('replay')
                                                                        ->value('1')
                                                                        }}
                                                                        {{ html()->hidden('comment_id')
                                                                        ->value($comment->id)
                                                                        }}

                                                                        {{ form_submit('
                                                        <i class="fab fa-telegram-plane"></i>')->class('btn btn-sumnit-comment post-comment') }}

                                                                        {{ html()->form()->close() }}
                                                                </div>
                                                            </div>
                                                            @endif
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif

                                        <div class="wp-single-post-comment-wrap">
                                            <div class="media connexus-comment-section-wrap connexus-input-section-wrap">
                                                <?php 
                                                $headers = @get_headers($myPost->user->avatar_location);
                                                if($headers && $headers[0] != 'HTTP/1.1 404 Not Found')
                                                {
                                                    $url_exist = true;
                                                }
                                                else
                                                {
                                                    $url_exist = false;
                                                }
                                                ?>
                                                @if($url_exist)
                                                <img src="{{$myPost->user->avatar_location}}" alt="{{$myPost->user->name}}" class="mr-3 mt-1 rounded-circle" width="40px">
                                                @else
                                                <img src="{{ asset('images/user.png') }}" alt="{{$myPost->user->name}}" class="mr-3 mt-1 rounded-circle" width="40px">
                                                @endif
                                                <div class="media-body">
                                                    {{ html()->form('POST', route('frontend.post.comment.send'))->class('post-comment-form')->id('comment-form')->open() }}

                                                        {{ html()->textarea('post_comment')
                                                            ->class('form-control')
                                                            ->placeholder('Post a Comment')
                                                            ->attributes(['rows' =>'1'])
                                                             }}
                                                        {{ html()->hidden('post_id')
                                                            ->value($myPost->id)
                                                             }}
                                                        {{ html()->hidden('user_id')
                                                            ->value($myPost->user_id)
                                                             }}
                                                             {{ html()->hidden('replay')
                                                                        ->value('0')
                                                                        }}

                                                        {{ form_submit('
                                                        <i class="fab fa-telegram-plane"></i>')->class('btn btn-sumnit-comment post-comment') }}


                                                        <button class="btn btn-sumnit-comment post-comment" type="submit"><i class="fab fa-telegram-plane"></i></button>
                                                    {{ html()->form()->close() }}
                                                </div>
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
    </section>
    <!-- END MY POST SECTION -->
    <div class="container">
        <hr class="section-full-devider"/>
    </div>
    <!-- START MY friend POST SECTION -->
    <section class="wp-main-post-listing-wrap-area">
        <div class="container">
            <div class="wp-list-title-wrap">
                <div class="row">
                    <div class="col-md-10 col-sm-9 col-8">
                        <div class="conn-my-post-details-title-wrap">
                            <h4 class="conn-my-post-details-title">My Friend Post</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wp-scrollble-main-post-list-wrap">
                @if(count($friendPostData)>0)
                    @foreach($friendPostData as $myFriend)
                        <div class="wp-single-post-list">
                            <div class="row m-0">
                                @php
                                    $post_type = 'text';
                                @endphp
                                <div class="col-md-6 p-0">
                                    @if(count($myFriend->post_images) > 0)
                                        <div class="conn-my-post-img-wrap" type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">

                                            <div class="owl-carousel owl-theme user-post-img-video-carousel">
                                                @foreach($myFriend->post_images as $media)
                                                    @if($media->type == 'video')
                                                        <div class="item">
                                                            <video width="100%" controls id="video-one">
                                                                <source src="{{asset('video/post/'.$myFriend->id.'/'.$media->name)}}" type="video/mp4">

                                                                Your browser does not support HTML5 video.
                                                            </video>
                                                        </div>
                                                    @else
                                                        <div class="item">
                                                            <img src="{{asset('images/post/'.$myFriend->id.'/'.$media->name)}}" class="img-fluid">
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        @php
                                            $post_type = 'media';
                                        @endphp
                                    @else
                                        <div class="wp-single-post-content-wrap-area">
                                            <div class="wp-single-post-content-wrap">
                                                <div class="media">
                                                <?php 
                                                $headers = @get_headers($myFriend->user->avatar_location);
                                                if($headers && $headers[0] != 'HTTP/1.1 404 Not Found')
                                                {
                                                    $url_exist = true;
                                                }
                                                else
                                                {
                                                    $url_exist = false;
                                                }
                                                ?>
                                                @if($url_exist)
                                                <img src="{{$myFriend->user->avatar_location}}" alt="{{$myFriend->user->name}}" class="mr-3 mt-1 rounded-circle" width="40px">
                                                @else
                                                <img src="{{ asset('images/user.png') }}" alt="{{$myFriend->user->name}}" class="mr-3 mt-1 rounded-circle" width="40px">
                                                @endif
                                                    
                                                    <div class="media-body">
                                                        <div class="conn-my-post-details-user-title">
                                                            <h5 class="publisher-name-text">{{$myFriend->user->first_name.' '.$myFriend->user->last_name}} </h5>
                                                            <p class="published-time-ago-text">Published at {{ $myFriend->created_at->diffForHumans() }}</p>
                                                        </div>
                                                        <div class="conn-like-unlike-icon-wrap">
                                                            <span class="conn-like-icon"><a href="javascript:void(0);" id="postLike-{{$myFriend->id}}" class="{{(getPostUserLike(Auth::user()->id,$myFriend->id))?'postLike active':'postLike'}}" data-id="{{$myFriend->id}}" ><i class="fas fa-thumbs-up"> </i> Like</a>
                                                                @if(!empty($myFriend->post_likes) && count($myFriend->post_likes) > 0)
                                                                    <div class="wp-total-likes-name-and-count">
                                                                        @foreach($myFriend->post_likes as $items)
                                                                            <span>{{$items->user->first_name.' '.$items->user->last_name}}</span>
                                                                        @endforeach
                                                                        @if(count($myFriend->post_likes) > 5)
                                                                        <span>.. {{count($myFriend->post_likes) - 5}} more</span>
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                            </span>
                                                            <!-- <span class="conn-unlike-icon"><a href="#"><i class="fas fa-thumbs-down"> 0</i></a></span> -->
                                                            <span class="expand-post-btn-icon"><a href="javascript:void(0)" title="Read more" class="r-bttn posts-view-popup" data-toggle="modal" data-target="#postModal" data-id="{{$myFriend->id}}" data-placement="top"><i class="fas fa-expand"></i></a></span>
                                                        </div>

                                                        <div class="conn-my-post-commemnt-content">
                                                            {!! $myFriend->description !!}</div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6 p-0">
                                    <div class="wp-single-post-content-wrap-area">
                                        @if($post_type == 'media')
                                            <div class="wp-single-post-content-wrap">
                                                <div class="media">
                                                <?php 
                                                $headers = @get_headers($myFriend->user->avatar_location);
                                                if($headers && $headers[0] != 'HTTP/1.1 404 Not Found')
                                                {
                                                    $url_exist = true;
                                                }
                                                else
                                                {
                                                    $url_exist = false;
                                                }
                                                ?>
                                                @if($url_exist)
                                                <img src="{{$myFriend->user->avatar_location}}" alt="{{$myFriend->user->name}}" class="mr-3 mt-1 rounded-circle" width="40px">
                                                @else
                                                <img src="{{ asset('images/user.png') }}" alt="{{$myFriend->user->name}}" class="mr-3 mt-1 rounded-circle" width="40px">
                                                @endif
                                                    
                                                    <div class="media-body">
                                                        <div class="conn-my-post-details-user-title">
                                                            <h5 class="publisher-name-text">{{$myFriend->user->first_name.' '.$myFriend->user->last_name}} </h5>
                                                            <p class="published-time-ago-text">Published about {{ $myFriend->created_at->diffForHumans() }}</p>
                                                        </div>
                                                        <div class="conn-like-unlike-icon-wrap">
                                                            <span class="conn-like-icon"><a href="javascript:void(0);" id="postLike-{{$myFriend->id}}" class="{{(getPostUserLike(Auth::user()->id,$myFriend->id))?'postLike active':'postLike'}}" data-id="{{$myFriend->id}}" ><i class="fas fa-thumbs-up"> </i> Like</a>
                                                                @if(!empty($myFriend->post_likes) && count($myFriend->post_likes) > 0)
                                                                    <div class="wp-total-likes-name-and-count">
                                                                        @foreach($myFriend->post_likes as $items)
                                                                            <span>{{$items->user->first_name.' '.$items->user->last_name}}</span>
                                                                        @endforeach
                                                                        @if(count($myFriend->post_likes) > 5)
                                                                        <span>.. {{count($myFriend->post_likes) - 5}} more</span>
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                            </span>
                                                            <!-- <span class="conn-unlike-icon"><a href="#"><i class="fas fa-thumbs-down"> 0</i></a></span> -->
                                                            <span class="expand-post-btn-icon"><a href="javascript:void(0)" title="Read more" class="r-bttn posts-view-popup" data-toggle="modal" data-target="#postModal" data-id="{{$myFriend->id}}" data-placement="top"><i class="fas fa-expand"></i></a></span>
                                                        </div>
                                                        <p class="conn-my-post-commemnt-content">
                                                        <div class="conn-my-post-commemnt-content">
                                                           {!! $myFriend->description !!}</div>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if(count($myFriend->post_comments)>0)
                                            @php $post_comments = $myFriend->post_comments @endphp
                                            <div class="wp-single-post-comment-listing-wrap">
                                                @foreach($myFriend->post_comments as $comment)
                                                    <div class="single-media-comment-list">
                                                        <div class="media">
                                                        <?php 
                                                        $headers = @get_headers($comment->user->avatar_location);
                                                        if($headers && $headers[0] != 'HTTP/1.1 404 Not Found')
                                                        {
                                                            $url_exist = true;
                                                        }
                                                        else
                                                        {
                                                            $url_exist = false;
                                                        }
                                                        ?>
                                                        @if($url_exist)
                                                            <img src="{{$comment->user->avatar_location}}" alt="{{$comment->user->name}}" class="mr-3 mt-1 rounded-circle" width="40px">
                                                        @else
                                                            <img src="{{ asset('images/user.png') }}" alt="{{$comment->user->name}}" class="mr-3 mt-1 rounded-circle" width="40px">
                                                        @endif
                                                            
                                                            <div class="media-body">
                                                                <div class="conn-my-post-details-user-title">
                                                                    <h5 class="publisher-name-text">
                                                                        {{getUserName($comment->user_id)}}
                                                                        <span class="comments-text-content">
                                                                            {!! $comment->description !!}
                                                                        </span>
                                                                        <div class="like-comment-replay-wrap-boxx">
                                                                            <a href="javascript:void(0);" id="comment-{{$comment->id}}" class="{{(getCommentUserLike($comment->user_id,$comment->id))?'like-comment-replay-link lin commentLike active':'like-comment-replay-link lin commentLike'}}" data-id="{{$comment->id}}" data-post="{{$myFriend->id}}" ><i class="fas fa-thumbs-up"> </i> Like</a>
                                                                            @if($comment->user_id != $logged_in_user->id)
                                                                            <a href="javascript:void(0);" class="like-comment-replay-link link replay_comment"><i class="fas fa-reply"></i> Reply</a>
                                                                            @endif
                                                                        </div>
                                                                        @if(!empty($comment->replay_comment) && count($comment->replay_comment)>0)
                                                                        @foreach($comment->replay_comment as $replay_comments)
                                                                        <div class="single-media-comment-list">
			<div class="media">
            <?php 
            $headers = @get_headers($replay_comments->user->avatar_location);
            if($headers && $headers[0] != 'HTTP/1.1 404 Not Found')
            {
                $url_exist = true;
            }
            else
            {
                $url_exist = false;
            }
            ?>
            @if($url_exist)
                <img src="{{$replay_comments->user->avatar_location}}" alt="{{$replay_comments->user->name}}" class="mr-3 mt-1 rounded-circle" width="40px">
            @else
                <img src="{{ asset('images/user.png') }}" alt="{{$replay_comments->user->name}}" class="mr-3 mt-1 rounded-circle" width="40px">
            @endif
                
                <div class="media-body">
					<div class="conn-my-post-details-user-title">
						<h5 class="publisher-name-text">
							{{getUserName($replay_comments->user_id)}}
							<span class="comments-text-content">
								{!! $replay_comments->description !!}
							</span>
						</h5>
					</div>
				</div>
</div>
</div>
                                                                        @endforeach
                                                                        @endif
                                                                        @if($comment->user_id != $logged_in_user->id)
                                                                        <div class="wp-single-poste-single-commemnt-replay-wrap replay-form">
                                                                <div class="wp-single-poste-single-commemnt-replay-img-wrap">
                                                                <?php 
                                                                $headers = @get_headers($logged_in_user->avatar_location);
                                                                if($headers && $headers[0] != 'HTTP/1.1 404 Not Found')
                                                                {
                                                                    $url_exist = true;
                                                                }
                                                                else
                                                                {
                                                                    $url_exist = false;
                                                                }
                                                                ?>
                                                                @if($url_exist)
                                                                    <img src="{{$logged_in_user->avatar_location}}" alt="{{$logged_in_user->name}}" class="mr-3 mt-1 rounded-circle" width="40px">
                                                                @else
                                                                    <img src="{{ asset('images/user.png') }}" alt="{{$logged_in_user->name}}" class="mr-3 mt-1 rounded-circle" width="40px">
                                                                @endif
                                                                    
                                                                </div>
                                                                <div class="wp-single-poste-single-commemnt-replay-form-wrap">
                                                                {{ html()->form('POST', route('frontend.post.comment.send'))->class('post-comment-form')->id('replay-comment-form')->open() }}

                                                                        {{ html()->textarea('post_comment')
                                                                        ->class('form-control')
                                                                        ->placeholder('Post a Comment')
                                                                        ->attributes(['rows' =>'1'])
                                                                        }}
                                                                    {{ html()->hidden('post_id')
                                                                        ->value($myPost->id)
                                                                        }}
                                                                    {{ html()->hidden('user_id')
                                                                        ->value($myPost->user_id)
                                                                        }}
                                                                        {{ html()->hidden('replay')
                                                                        ->value('1')
                                                                        }}
                                                                        {{ html()->hidden('comment_id')
                                                                        ->value($comment->id)
                                                                        }}

                                                                        {{ form_submit('
                                                        <i class="fab fa-telegram-plane"></i>')->class('btn btn-sumnit-comment post-comment') }}

                                                                        {{ html()->form()->close() }}
                                                                </div>
                                                            </div>
                                                            @endif
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif

                                        <div class="wp-single-post-comment-wrap">
                                            <div class="media connexus-comment-section-wrap connexus-input-section-wrap">
                                            <?php 
                                            $headers = @get_headers($myFriend->user->avatar_location);
                                            if($headers && $headers[0] != 'HTTP/1.1 404 Not Found')
                                            {
                                                $url_exist = true;
                                            }
                                            else
                                            {
                                                $url_exist = false;
                                            }
                                            ?>
                                                @if($url_exist)
                                                <img src="{{ $myFriend->user->avatar_location }}" alt="{{$myFriend->user->name}}" class="mr-3 mt-1 rounded-circle" width="40px">
                                                @else
                                                <img src="{{ asset('images/user.png') }}" alt="{{ $myFriend->user->name }}" class="mr-3 mt-1 rounded-circle" width="40px">
                                                @endif
                                                <div class="media-body">
                                                    {{ html()->form('POST', route('frontend.post.comment.send'))->class('post-comment-form')->id('comment-form')->open() }}

                                                        {{ html()->textarea('post_comment')
                                                            ->class('form-control')
                                                            ->placeholder('Post a Comment')
                                                            ->attributes(['rows' =>'1'])
                                                             }}
                                                        {{ html()->hidden('post_id')
                                                            ->value($myFriend->id)
                                                             }}
                                                        {{ html()->hidden('user_id')
                                                            ->value($myFriend->user_id)
                                                             }}
                                                             {{ html()->hidden('replay')
                                                                        ->value('0')
                                                                        }}

                                                        {{ form_submit('
                                                        <i class="fab fa-telegram-plane"></i>')->class('btn btn-sumnit-comment post-comment') }}


                                                        <button class="btn btn-sumnit-comment post-comment" type="submit"><i class="fab fa-telegram-plane"></i></button>
                                                    {{ html()->form()->close() }}
                                                </div>
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
    </section>
    <!-- END MY Friend POST SECTION -->

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
            
            $(document).on("click", ".posts-view-popup", function () {
                var id = $(this).data('id');
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: "POST",
                    url: '{{route('frontend.post.view')}}',
                    data: "id="+id,
                    success: function(data){
                        $("#posts-data").html(data.postsDetailHtml);
                        $("#popUpLoader .widget-loader").hide();
                    }
                });
            });
                $('.user-post-img-video-carousel').owlCarousel({
                        loop:true,
                        margin:10,
                        nav:true,
                        mouseDrag:false,
                        dots:false,
                        autoplay:false,
                        video: true,
                        lazyLoad: true,
                        autoplayTimeout:5000,
                        responsive:{
                            0:{
                                items:1
                            },
                            600:{
                                items:1
                            },
                            1000:{
                                items:1
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
