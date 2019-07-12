<?php

use App\Http\Controllers\Backend\Invite\InviteController;

Route::group([
	'prefix' => 'invite',
	'as' => 'invite.',
	'namespace' => 'Invite',
], function () {
	/*
		 * User CRUD
	*/
	Route::get('', [InviteController::class, 'index'])->name('index');
	Route::get('create', [InviteController::class, 'create'])->name('create');
	Route::post('store', [InviteController::class, 'store'])->name('store');

	/*
		     * Specific Invite
	*/
	Route::group(['prefix' => '{invite}'], function () {
		// invite
		Route::get('edit', [InviteController::class, 'edit'])->name('edit');
		Route::patch('/', [InviteController::class, 'update'])->name('update');
		//Route::delete('/', [InviteController::class, 'destroy'])->name('destroy');

		// Deleted
		Route::get('delete', [InviteController::class, 'destroy'])->name('destroy');
		//Route::get('restore', [UserStatusController::class, 'restore'])->name('user.restore');
	});

});
