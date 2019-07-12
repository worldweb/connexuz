<?php

namespace App\Models\Group;

use App\Models\Group\Traits\Attribute\GroupAttribute;
use Illuminate\Database\Eloquent\Model;

class Group extends Model {

	use GroupAttribute;

	protected $table = 'user_group';
	protected $fillable = ['name', 'create_at', 'update_at'];

}
