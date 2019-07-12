<?php

use App\Http\Controllers\Backend\UserSubscription\UserSubscriptionController;

Route::group([
	'prefix' => 'usersubscription',
	'as' => 'usersubscription.',
	'namespace' => 'UserSubscription',
], function () {
	/*
		 * User CRUD
	*/
	Route::get('', [UserSubscriptionController::class, 'index'])->name('index');

});
