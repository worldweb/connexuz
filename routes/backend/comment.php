<?php

use App\Http\Controllers\Backend\Comment\CommentController;

Route::group([
	'prefix' => 'comment',
	'as' => 'comment.',
	'namespace' => 'Comment',
], function () {
	/*
		 * User CRUD
	*/
	Route::get('', [CommentController::class, 'index'])->name('index');
	Route::get('create', [CommentController::class, 'create'])->name('create');
	Route::post('store', [CommentController::class, 'store'])->name('store');

	/*
		     * Specific Comment
	*/
	Route::group(['prefix' => '{comment}'], function () {
		// comment
		Route::get('edit', [CommentController::class, 'edit'])->name('edit');
		Route::patch('/', [CommentController::class, 'update'])->name('update');
		//Route::delete('/', [commentController::class, 'destroy'])->name('destroy');

		// Deleted
		Route::get('delete', [CommentController::class, 'destroy'])->name('destroy');
		//Route::get('restore', [UserStatusController::class, 'restore'])->name('user.restore');
	});

});
