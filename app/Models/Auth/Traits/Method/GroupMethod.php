<?php

namespace App\Models\Auth\Traits\Method;

/**
 * Trait GroupMethod.
 */
trait GroupMethod {
	/**
	 * @return mixed
	 */
	public function isAdmin() {
		return $this->name === config('access.users.admin_role');
	}
}
