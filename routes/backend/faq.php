<?php

use App\Http\Controllers\Backend\Faq\FaqController;

Route::group([
	'prefix' => 'faq',
	'as' => 'faq.',
	'namespace' => 'Faq',
], function () {
	/*
		 * User CRUD
	*/
	Route::get('', [FaqController::class, 'index'])->name('index');
	Route::get('create', [FaqController::class, 'create'])->name('create');
	Route::post('store', [FaqController::class, 'store'])->name('store');

	/*
		     * Specific Faq
	*/
	Route::group(['prefix' => '{faq}'], function () {
		// faq
		Route::get('edit', [FaqController::class, 'edit'])->name('edit');
		Route::patch('/', [FaqController::class, 'update'])->name('update');
		//Route::delete('/', [FaqController::class, 'destroy'])->name('destroy');

		// Deleted
		Route::get('delete', [FaqController::class, 'destroy'])->name('destroy');
		//Route::get('restore', [UserStatusController::class, 'restore'])->name('user.restore');
	});

});
