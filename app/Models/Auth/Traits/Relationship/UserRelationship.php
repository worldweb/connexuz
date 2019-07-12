<?php

namespace App\Models\Auth\Traits\Relationship;

use App\Models\Auth\PasswordHistory;
use App\Models\Auth\SocialAccount;
use App\Models\Invite\Invite;
use App\Models\System\Session;

/**
 * Class UserRelationship.
 */
trait UserRelationship {
	/**
	 * @return mixed
	 */
	public function providers() {
		return $this->hasMany(SocialAccount::class);
	}

	/**
	 * @return mixed
	 */
	public function sessions() {
		return $this->hasMany(Session::class);
	}

	/**
	 * @return mixed
	 */
	public function passwordHistories() {
		return $this->hasMany(PasswordHistory::class);
	}

	/**
	 * @return mixed
	 */
	public function user_invite() {
		return $this->hasMany(Invite::class);
	}
}
