<?php

namespace App\Models\Post;

use App\Models\Auth\User;
use App\Models\Comment\CommentLikes;
use App\Models\Post\Post;
use Illuminate\Database\Eloquent\Model;

class PostComment extends Model {
	protected $table = 'post_comments';
	protected $fillable = ['user_id', 'post_id', 'description','reply_user_id','parent_id'];

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

	/**
	 * Get the post comment.
	 */
	public function comment_likes() {
		return $this->hasMany(CommentLikes::class, 'comment_id', 'id')->with('user_name');
	}

	/**
	 * Get the post replay comment.
	 */
	public function replay_comment() {
		return $this->hasMany(PostComment::class,'parent_id')->where('parent_id','!=',null)->with('replay_comment');
	}
}
