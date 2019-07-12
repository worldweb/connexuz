<?php

namespace App\Repositories\Backend\UserSubscription;

use App\Exceptions\GeneralException;
use App\Models\UserSubscription\UserSubscription;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

/**
 * Class UserSubscriptionRepository.
 */
class UserSubscriptionRepository extends BaseRepository {
	/**
	 * @return string
	 */
	public function model() {
		return UserSubscription::class;
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
	 * @return UserSubscription
	 * @throws \Exception
	 * @throws \Throwable
	 */
	public function create(array $data): UserSubscription {
		return DB::transaction(function () use ($data) {
			$subscription = parent::create($data);

			if ($subscription) {
				return $subscription;
			}

			throw new GeneralException(__('exceptions.frontend.user.settings.create_error'));
		});
	}

	/**
	 * @param UserSubscription  $userSubscription
	 * @param array $data
	 *
	 * @return UserSubscription
	 * @throws GeneralException
	 * @throws \Exception
	 * @throws \Throwable
	 */
	public function update(UserSubscription $userSubscription, array $data): UserSubscription {

	}

	/**
	 * @param UserSubscription $userSubscription
	 *
	 * @return UserSubscription
	 * @throws GeneralException
	 * @throws \Exception
	 * @throws \Throwable
	 */
	public function destroy(UserSubscription $userSubscription): UserSubscription {
		
	}
}
