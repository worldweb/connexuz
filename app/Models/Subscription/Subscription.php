<?php

namespace App\Models\Subscription;

use App\Models\Subscription\Traits\Attribute\SubscriptionAttribute;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model {

	use SubscriptionAttribute;

	protected $table = 'subscription';
	protected $fillable = ['name', 'price', 'no_of_days','no_of_free_days','status', 'create_at', 'update_at'];

}
