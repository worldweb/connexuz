<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Model;

class UserSettings extends Model {

	protected $table = 'user_settings';
	protected $fillable = ['id', 'setting_key', 'setting_value', 'created_at', 'updated_at'];

}
