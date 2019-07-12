<?php

use App\Http\Controllers\Backend\Settings\SettingsController;

Route::group([
	'prefix' => 'setting',
	'as' => 'setting.',
	'namespace' => 'Settings',
], function () {
	/*
		 * Setting CRUD
	*/
	Route::get('', [SettingsController::class, 'index'])->name('index');
	Route::post('store', [SettingsController::class, 'store'])->name('store');

	/*
		     * Specific Setting
	*/
	Route::group(['prefix' => '{setting}'], function () {
		// user
		Route::get('/', [SettingsController::class, 'show'])->name('show');
		Route::get('edit', [SettingsController::class, 'edit'])->name('edit');
		Route::patch('/', [SettingsController::class, 'update'])->name('update');
		//Route::delete('/', [SettingsController::class, 'destroy'])->name('destroy');

		// Deleted
		Route::get('delete', [SettingsController::class, 'destroy'])->name('destroy');
		//Route::get('restore', [UserStatusController::class, 'restore'])->name('user.restore');
	});

});
