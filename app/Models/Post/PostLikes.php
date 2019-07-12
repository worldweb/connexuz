<?php

namespace App\Models\Post;

use App\Models\Auth\User;
use App\Models\Post\Post;
use Illuminate\Database\Eloquent\Model;

class PostLikes extends Model {
	protected $table = 'post_likes';
	protected $fillable = ['user_id', 'post_id', 'likes'];

	/**
	 * Get the user that owns the post comment.
	 */
	public function user() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	/**
	 * Get the post that belong to the post comment.
	 */
	public function post() {
		return $this->belongsTo(Post::class, 'post_id', 'id');
	}
}
