<?php

namespace App\Models\Comment;

use App\Models\Auth\User;
use App\Models\Comment\Traits\Attribute\CommentAttribute;
use App\Models\Post\Post;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

	use CommentAttribute;

	protected $table = 'post_comments';
	protected $fillable = ['user_id', 'comment_user_id', 'status', 'create_at', 'update_at'];

	/**
	 * Get the user
	 */
	public function users() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	/**
	 * Get the Comment user
	 */
	public function posts() {
		return $this->belongsTo(Post::class, 'post_id', 'id');
	}

	/**
	 * Get the reply user
	 */
	public function reply_user() {
		return $this->belongsTo(User::class, 'reply_user_id', 'id');
	}

}
