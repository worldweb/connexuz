<?php

namespace App\Repositories\Backend\Subscription;

use App\Exceptions\GeneralException;
use App\Models\Subscription\Subscription;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

/**
 * Class SubscriptionRepository.
 */
class SubscriptionRepository extends BaseRepository {
	/**
	 * @return string
	 */
	public function model() {
		return Subscription::class;
	}

	/**
	 * @param int    $paged
	 * @param string $orderBy
	 * @param string $sort
	 *
	 * @return mixed
	 */
	public function getActivePaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc'): LengthAwarePaginator {
		return $this->model
			->orderBy($orderBy, $sort)
			->paginate($paged);
	}

	/**
	 * @param array $data
	 *
	 * @return Subscription
	 * @throws \Exception
	 * @throws \Throwable
	 */
	public function create(array $data): Subscription {
		return DB::transaction(function () use ($data) {
			$data['status'] = (!empty($data['status'])) ? $data['status'] : '0';
			$subscription = parent::create([
				'name' => $data['name'],
				'status' => $data['status'],
				'price' => $data['price'],
				'no_of_days' => $data['no_of_days'],
				'no_of_free_days' => $data['no_of_free_days'],
			]);

			if ($subscription) {
				return $subscription;
			}

			throw new GeneralException(__('exceptions.backend.subscriptions.create_error'));
		});
	}

	/**
	 * @param Subscription  $subscription
	 * @param array $data
	 *
	 * @return Subscription
	 * @throws GeneralException
	 * @throws \Exception
	 * @throws \Throwable
	 */
	public function update(Subscription $subscription, array $data): Subscription {

		return DB::transaction(function () use ($subscription, $data) {
			$data['status'] = (!empty($data['status'])) ? $data['status'] : '0';
			if ($subscription->update([
				'name' => $data['name'],
				'status' => $data['status'],
				'price' => $data['price'],
				'no_of_days' => $data['no_of_days'],
				'no_of_free_days' => $data['no_of_free_days'],
			])) {

				return $subscription;
			}

			throw new GeneralException(__('exceptions.backend.subscriptions.update_error'));
		});
	}

	/**
	 * @param Subscription $subscription
	 *
	 * @return Subscription
	 * @throws GeneralException
	 * @throws \Exception
	 * @throws \Throwable
	 */
	public function destroy(Subscription $subscription): Subscription {
		return DB::transaction(function () use ($subscription) {

			// Delete associated comments
			//$subscription->deletesubscriptionComments()->delete();
			$is_deleted = $subscription->delete();

			if ($is_deleted) {

				//event(new UserPermanentlyDeleted($user));
				return $subscription;
			}

			throw new GeneralException(__('exceptions.backend.subscriptions.delete_error'));
		});
	}
}
