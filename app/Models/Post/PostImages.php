<?php

namespace App\Models\Post;

use App\Models\Post\Post;
use Illuminate\Database\Eloquent\Model;

class PostImages extends Model {
	protected $table = 'post_images';
	protected $fillable = ['name', 'post_id', 'type'];

	/**
	 * Get the post that belong to the post image.
	 */
	public function post() {
		return $this->belongsTo(Post::class, 'post_id', 'id');
	}
}
