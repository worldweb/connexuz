<?php

namespace App\Models\Auth;

use App\Models\Auth\Traits\Attribute\GroupAttribute;
use App\Models\Auth\Traits\Method\GroupMethod;

/**
 * Class Group.
 */
class Group extends \Spatie\Permission\Models\Group {
	use GroupAttribute,
		GroupMethod;
}
