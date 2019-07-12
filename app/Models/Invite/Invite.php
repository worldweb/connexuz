<?php

namespace App\Models\Invite;

use App\Models\Auth\User;
use App\Models\Invite\Traits\Attribute\InviteAttribute;
use Illuminate\Database\Eloquent\Model;

class Invite extends Model {

	use InviteAttribute;

	protected $table = 'user_invites';
	protected $fillable = ['user_id', 'invite_user_id', 'status', 'create_at', 'update_at'];

	/**
	 * Get the user
	 */
	public function users() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	/**
	 * Get the Invite user
	 */
	public function invite_user() {
		return $this->belongsTo(User::class, 'invite_user_id', 'id');
	}
        
}
