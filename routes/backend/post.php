<?php

use App\Http\Controllers\Backend\Post\PostController;

Route::group([
	'prefix' => 'post',
	'as' => 'post.',
	'namespace' => 'Post',
], function () {

	/*
    * For DataTables
    */
    Route::post('get', 'TableController')->name('get');

	/*
		 * User CRUD
	*/
	Route::get('', [PostController::class, 'index'])->name('index');
	Route::get('create', [PostController::class, 'create'])->name('create');
	Route::post('store', [PostController::class, 'store'])->name('store');

	/*
		     * Specific Post
	*/
	Route::group(['prefix' => '{post}'], function () {
		// post
		Route::get('/', [PostController::class, 'show'])->name('show');
		Route::get('edit', [PostController::class, 'edit'])->name('edit');
		Route::patch('/', [PostController::class, 'update'])->name('update');
		//Route::delete('/', [PostController::class, 'destroy'])->name('destroy');

		// Deleted
		Route::get('delete', [PostController::class, 'destroy'])->name('destroy');
		//Route::get('restore', [UserStatusController::class, 'restore'])->name('user.restore');
	});

});
