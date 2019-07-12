<?php

namespace App\Models\Interest;

use Illuminate\Database\Eloquent\Model;

class Interest extends Model {

        protected $table = "interest";
        public $timestamps = false;
	protected $fillable = ['user_id', 'title'];

	/**
	 * Get the user
	 */
	public function users() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

}
