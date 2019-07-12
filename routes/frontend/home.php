<?php

use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\User\AccountController;
use App\Http\Controllers\Frontend\User\DashboardController;
use App\Http\Controllers\Frontend\User\ProfileController;

/*
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */

/*Route::get('contact', [ContactController::class, 'index'])->name('contact');
Route::post('contact/send', [ContactController::class, 'send'])->name('contact.send');*/

/*
 * These frontend controllers require the user to be logged in
 * All route names are prefixed with 'frontend.'
 * These routes can not be hit if the password is expired
 */
Route::group(['middleware' => ['auth', 'password_expires','payment_subscription']], function () {

	Route::any('/', [HomeController::class, 'index'])->name('index');
        Route::any('/ajax_friendposts', [HomeController::class, 'ajax_friendposts'])->name('ajax_friendposts');
        Route::any('/ajax_myposts', [HomeController::class, 'ajax_myposts'])->name('ajax_myposts');
        Route::post('/check_subscription', [AccountController::class, 'check_subscription'])->name('check_subscription');

	Route::group(['namespace' => 'Post', 'as' => 'post.'], function () {
		Route::post('post/comment/send', 'PostController@postCommnet')->name('comment.send');
		Route::post('post/create', 'PostController@createPost')->name('create');
		Route::post('post/add-like', 'PostController@addPostLike')->name('add.like');
		Route::post('comment/add-like', 'PostController@addCommentLike')->name('comment.like');
		Route::post('/popup/view', 'PostController@popupData')->name('view');
	});

	Route::group(['namespace' => 'User', 'as' => 'user.'], function () {
		/* User Dashboard Specific */
		Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

		/* User Account Specific */
		Route::get('account', [AccountController::class, 'index'])->name('account');

		/* User Profile Specific */
		Route::patch('profile/update', [ProfileController::class, 'update'])->name('profile.update');

		Route::patch('profile/updateprofile', [ProfileController::class, 'updateprofile'])->name('profile.updateprofile');

		/* 21_11_2018 */
		Route::post('profile/deleteinterest', [ProfileController::class, 'deleteInterest'])->name('delete.interest');
		// Invite User
		Route::post('invite/send', [ProfileController::class, 'inviteUser'])->name('invite.send');

		/* profile image save */
		Route::post('profile/image-crop', [ProfileController::class, 'imageCropPost'])->name('image.crop.post');
		/* cover image save */
		Route::post('profile/cover-image-crop', [ProfileController::class, 'coverImageCropPost'])->name('cover.image.crop.post');

		/* User Friend Profile View */
		Route::get('user/friend/{id}', [ProfileController::class, 'friendProfile'])->name('friend.profile');
	});

	// Network
	Route::group(['namespace' => 'Network', 'as' => 'network.'], function () {
		Route::get('networks', 'NetworkController@index')->name('list');
		Route::post('networks/search-friend', 'NetworkController@searchFriend')->name('search.friend');
		Route::post('networks/add-friend', 'NetworkController@addFriend')->name('add.friend');
	});

	// Help
	Route::group(['namespace' => 'Help', 'as' => 'help.'], function () {
		Route::get('help/', 'HelpController@index')->name('list');
	});
});

Route::group(['middleware' => ['auth', 'password_expires']], function () {
	Route::group(['namespace' => 'User', 'as' => 'user.'], function () {
		/* User Settings */
		Route::get('settings', [AccountController::class, 'settings'])->name('settings');
		Route::post('change-status', [AccountController::class, 'changeStatus'])->name('change.status');
		Route::post('charge-card', [AccountController::class, 'createAnAcceptPaymentTransaction'])->name('charge.card');
	});
});
