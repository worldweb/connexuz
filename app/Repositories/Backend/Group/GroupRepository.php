<?php

namespace App\Repositories\Backend\Group;

use App\Exceptions\GeneralException;
use App\Models\Group\Group;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

/**
 * Class GroupRepository.
 */
class GroupRepository extends BaseRepository {
	/**
	 * @return string
	 */
	public function model() {
		return Group::class;
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
	 * @return Group
	 * @throws \Exception
	 * @throws \Throwable
	 */
	public function create(array $data): Group {
		return DB::transaction(function () use ($data) {
			$data['status'] = (!empty($data['status'])) ? $data['status'] : '0';
			$group = parent::create([
				'name' => $data['name'],
				'status' => $data['status'],
			]);

			if ($group) {
				return $group;
			}

			throw new GeneralException(__('exceptions.backend.groups.create_error'));
		});
	}

	/**
	 * @param Group  $group
	 * @param array $data
	 *
	 * @return Group
	 * @throws GeneralException
	 * @throws \Exception
	 * @throws \Throwable
	 */
	public function update(Group $group, array $data): Group {

		return DB::transaction(function () use ($group, $data) {
			$data['status'] = (!empty($data['status'])) ? $data['status'] : '0';
			if ($group->update([
				'name' => $data['name'],
				'status' => $data['status'],
			])) {

				return $group;
			}

			throw new GeneralException(__('exceptions.backend.groups.update_error'));
		});
	}

	/**
	 * @param Group $group
	 *
	 * @return Group
	 * @throws GeneralException
	 * @throws \Exception
	 * @throws \Throwable
	 */
	public function destroy(Group $group): Group {
		return DB::transaction(function () use ($group) {

			// Delete associated comments
			//$group->deleteGroupComments()->delete();
			$is_deleted = $group->delete();

			if ($is_deleted) {

				//event(new UserPermanentlyDeleted($user));
				return $group;
			}

			throw new GeneralException(__('exceptions.backend.groups.delete_error'));
		});
	}
}
