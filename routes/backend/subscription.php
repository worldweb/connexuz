<?php

use App\Http\Controllers\Backend\Subscription\SubscriptionController;

Route::group([
	'prefix' => 'subscription',
	'as' => 'subscription.',
	'namespace' => 'Subscription',
], function () {
	/*
		 * User CRUD
	*/
	Route::get('', [SubscriptionController::class, 'index'])->name('index');
	Route::get('create', [SubscriptionController::class, 'create'])->name('create');
	Route::post('store', [SubscriptionController::class, 'store'])->name('store');

	/*
		     * Specific Subscription
	*/
	Route::group(['prefix' => '{subscription}'], function () {
		// subscription
		Route::get('edit', [SubscriptionController::class, 'edit'])->name('edit');
		Route::patch('/', [SubscriptionController::class, 'update'])->name('update');
		//Route::delete('/', [SubscriptionController::class, 'destroy'])->name('destroy');

		// Deleted
		Route::get('delete', [SubscriptionController::class, 'destroy'])->name('destroy');
		//Route::get('restore', [UserStatusController::class, 'restore'])->name('user.restore');
	});

});
