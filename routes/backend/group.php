<?php

use App\Http\Controllers\Backend\Group\GroupController;

Route::group([
	'prefix' => 'group',
	'as' => 'group.',
	'namespace' => 'Group',
], function () {
	/*
		 * User CRUD
	*/
	Route::get('', [GroupController::class, 'index'])->name('index');
	Route::get('create', [GroupController::class, 'create'])->name('create');
	Route::post('store', [GroupController::class, 'store'])->name('store');

	/*
		     * Specific Group
	*/
	Route::group(['prefix' => '{group}'], function () {
		// group
		Route::get('edit', [GroupController::class, 'edit'])->name('edit');
		Route::patch('/', [GroupController::class, 'update'])->name('update');
		//Route::delete('/', [GroupController::class, 'destroy'])->name('destroy');

		// Deleted
		Route::get('delete', [GroupController::class, 'destroy'])->name('destroy');
		//Route::get('restore', [UserStatusController::class, 'restore'])->name('user.restore');
	});

});
