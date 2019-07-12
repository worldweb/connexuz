<?php

namespace App\Http\Controllers\Backend\UserSubscription;

use App\Http\Controllers\Controller;
use App\Models\UserSubscription\UserSubscription;
use App\Repositories\Backend\UserSubscription\UserSubscriptionRepository;
use Illuminate\Http\Request;

class UserSubscriptionController extends Controller {
	/**
	 * @var UserSubscriptionRepository
	 */
	protected $userSubscriptionRepository;

	/**
	 * UserSubscriptionController constructor.
	 *
	 * @param UserSubscriptionRepository $userSubscriptionRepository
	 */
	public function __construct(UserSubscriptionRepository $userSubscriptionRepository) {
		$this->userSubscriptionRepository = $userSubscriptionRepository;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request) {
		return view('backend.user_subscription.index')
			->withUserSubscriptions($this->userSubscriptionRepository
					->with('users', 'subscription')
					->orderBy('created_at', 'desc')
					->paginate());
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(UserSubscription $userSubscription) {
		
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, UserSubscription $userSubscription) {

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request, UserSubscription $userSubscription) {

	}
}
