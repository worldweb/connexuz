<?php

namespace App\Models\Comment;

use App\Models\Auth\User;
use App\Models\Comment\Comment;
use Illuminate\Database\Eloquent\Model;

class CommentLikes extends Model {
	protected $table = 'comment_likes';
	protected $fillable = ['user_id', 'comment_id', 'post_id'];

	/**
	 * Get the user that owns the post comment.
	 */
	public function user() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	/**
	 * Get the post that belong to the post comment.
	 */
	public function comment() {
		return $this->belongsTo(Post::class, 'comment_id', 'id');
	}

	/**
	 * Get the user that owns the post comment.
	 */
	public function user_name() {
		return $this->belongsTo(User::class, 'user_id', 'id')->select(array('id', 'first_name', 'last_name'));
	}
}
