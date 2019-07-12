<?php

namespace App\Models\UserSubscription;

use App\Models\Auth\User;
use App\Models\UserSubscription\Traits\Attribute\UserSubscriptionAttribute;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subscription\Subscription;

class UserSubscription extends Model {

	use UserSubscriptionAttribute;

	protected $table = 'user_subscription';
	protected $fillable = ['user_id', 'subscription_id','transaction_id', 'status', 'created_at', 'updated_at','payment_method','payment_amount','payment_ref_no','payment_response','payment_status','payment_date'];

	/**
	 * Get the user
	 */
	public function users() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	/**
	 * Get the UserSubscription user
	 */
	public function subscription() {
		return $this->belongsTo(Subscription::class, 'subscription_id', 'id');
	}
        
}
