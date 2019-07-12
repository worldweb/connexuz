<?php

namespace App\Http\Controllers\Backend\Subscription;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Subscription\StoreSubscriptionRequest;
use App\Http\Requests\Backend\Subscription\UpdateSubscriptionRequest;
use App\Models\Auth\User;
use App\Models\Subscription\Subscription;
use App\Repositories\Backend\Subscription\SubscriptionRepository;
use Illuminate\Http\Request;

class SubscriptionController extends Controller {
	/**
	 * @var SubscriptionRepository
	 */
	protected $subscriptionRepository;

	/**
	 * SubscriptionController constructor.
	 *
	 * @param SubscriptionRepository $subscriptionRepository
	 */
	public function __construct(SubscriptionRepository $subscriptionRepository) {
		$this->subscriptionRepository = $subscriptionRepository;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request) {
		return view('backend.subscription.index')
			->withSubscriptions($this->subscriptionRepository->getActivePaginated('', 'id', 'asc'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		try {

			return view('backend.subscription.create')
				->withSubscription(new Subscription());
		} catch (\Exception $ex) {

		}

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreSubscriptionRequest $request) {

		$this->subscriptionRepository->create($request->only(
			'name', 'status', 'price','no_of_days','no_of_free_days'
		));

		return redirect()->route('admin.subscription.index')->withFlashSuccess(__('alerts.backend.subscriptions.created'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Subscription $subscription) {
		return view('backend.subscription.edit')
			->withSubscription($subscription);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Subscription $subscription, UpdateSubscriptionRequest $request) {

		$this->subscriptionRepository->update($subscription, $request->only(
			'name', 'status', 'price','no_of_days','no_of_free_days'
		));

		return redirect()->route('admin.subscription.index')->withFlashSuccess(__('alerts.backend.subscriptions.updated'));

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request, Subscription $subscription) {
		$this->subscriptionRepository->destroy($subscription);

		//event(new UserDeleted($user));

		return redirect()->route('admin.subscription.index')->withFlashSuccess(__('alerts.backend.subscriptions.deleted'));
	}
}
