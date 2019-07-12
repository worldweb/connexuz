<?php

namespace App\Models\Post;

use App\Models\Auth\User;
use App\Models\Post\PostComment;
use App\Models\Post\PostImages;
use App\Models\Post\PostLikes;
use App\Models\Post\Traits\Attribute\PostAttribute;
use Illuminate\Database\Eloquent\Model;

class Post extends Model {

	use PostAttribute;

	protected $table = 'posts';
	protected $fillable = ['user_id', 'description', 'create_at', 'update_at'];

	/**
	 * Get the user that owns the post.
	 */
	public function user() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	/**
	 * Get the post images.
	 */
	public function post_images() {
		return $this->hasMany(PostImages::class, 'post_id', 'id');
	}

	/**
	 * Get the post comments.
	 */
	public function post_comments() {
		return $this->hasMany(PostComment::class, 'post_id', 'id')->where('reply_user_id',null)->with('comment_likes','replay_comment');
	}

	/**
	 * Get the post likes.
	 */
	public function post_likes() {
		return $this->hasMany(PostLikes::class, 'post_id', 'id')->with('user');
	}
        

}
