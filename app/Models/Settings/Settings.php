<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model {

	protected $table = 'settings';
	protected $fillable = ['id', 'setting_key', 'setting_value', 'created_at', 'updated_at'];

}
