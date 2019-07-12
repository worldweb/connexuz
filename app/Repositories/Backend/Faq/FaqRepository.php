<?php

namespace App\Repositories\Backend\Faq;

use App\Exceptions\GeneralException;
use App\Models\Faq\Faq;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

/**
 * Class FaqRepository.
 */
class FaqRepository extends BaseRepository {
	/**
	 * @return string
	 */
	public function model() {
		return Faq::class;
	}

	/**
	 * @param int    $paged
	 * @param string $orderBy
	 * @param string $sort
	 *
	 * @return mixed
	 */
	public function getActivePaginated($paged = '', $orderBy = 'created_at', $sort = 'desc'): LengthAwarePaginator {
		return $this->model
			->orderBy($orderBy, $sort)
			->paginate($paged);
	}

	/**
	 * @param array $data
	 *
	 * @return Faq
	 * @throws \Exception
	 * @throws \Throwable
	 */
	public function create(array $data): Faq {
		return DB::transaction(function () use ($data) {
			$data['status'] = (!empty($data['status'])) ? $data['status'] : '0';
			$faq = parent::create([
				'title' => $data['title'],
				'status' => $data['status'],
				'description' => $data['description'],
			]);

			if ($faq) {
				return $faq;
			}

			throw new GeneralException(__('exceptions.backend.faqs.create_error'));
		});
	}

	/**
	 * @param Faq  $faq
	 * @param array $data
	 *
	 * @return Faq
	 * @throws GeneralException
	 * @throws \Exception
	 * @throws \Throwable
	 */
	public function update(Faq $faq, array $data): Faq {

		return DB::transaction(function () use ($faq, $data) {
			$data['status'] = (!empty($data['status'])) ? $data['status'] : '0';
			if ($faq->update([
				'title' => $data['title'],
				'status' => $data['status'],
				'description' => $data['description'],
			])) {

				return $faq;
			}

			throw new GeneralException(__('exceptions.backend.faqs.update_error'));
		});
	}

	/**
	 * @param Faq $faq
	 *
	 * @return Faq
	 * @throws GeneralException
	 * @throws \Exception
	 * @throws \Throwable
	 */
	public function destroy(Faq $faq): Faq {
		return DB::transaction(function () use ($faq) {

			// Delete associated comments
			//$faq->deletefaqComments()->delete();
			$is_deleted = $faq->delete();

			if ($is_deleted) {

				//event(new UserPermanentlyDeleted($user));
				return $faq;
			}

			throw new GeneralException(__('exceptions.backend.faqs.delete_error'));
		});
	}
}
