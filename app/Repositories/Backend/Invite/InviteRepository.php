<?php

namespace App\Repositories\Backend\Invite;

use App\Exceptions\GeneralException;
use App\Models\Invite\Invite;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

/**
 * Class InviteRepository.
 */
class InviteRepository extends BaseRepository {
	/**
	 * @return string
	 */
	public function model() {
		return Invite::class;
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
	 * @return Invite
	 * @throws \Exception
	 * @throws \Throwable
	 */
	public function create(array $data): Invite {

	}

	/**
	 * @param Invite  $invite
	 * @param array $data
	 *
	 * @return Invite
	 * @throws GeneralException
	 * @throws \Exception
	 * @throws \Throwable
	 */
	public function update(Invite $invite, array $data): Invite {

		return DB::transaction(function () use ($invite, $data) {
			$data['status'] = (!empty($data['status'])) ? $data['status'] : '0';
			if ($invite->update([
				'name' => $data['name'],
				'status' => $data['status'],
			])) {

				return $invite;
			}

			throw new GeneralException(__('exceptions.backend.invites.update_error'));
		});
	}

	/**
	 * @param Invite $invite
	 *
	 * @return Invite
	 * @throws GeneralException
	 * @throws \Exception
	 * @throws \Throwable
	 */
	public function destroy(Invite $invite): Invite {
		return DB::transaction(function () use ($invite) {

			// Delete associated comments
			//$invite->deleteInviteComments()->delete();
			$is_deleted = $invite->delete();

			if ($is_deleted) {

				//event(new UserPermanentlyDeleted($user));
				return $invite;
			}

			throw new GeneralException(__('exceptions.backend.invites.delete_error'));
		});
	}
}
