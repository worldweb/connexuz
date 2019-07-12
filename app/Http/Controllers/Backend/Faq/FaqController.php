<?php

namespace App\Http\Controllers\Backend\Faq;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Faq\StoreFaqRequest;
use App\Http\Requests\Backend\Faq\UpdateFaqRequest;
use App\Models\Auth\User;
use App\Models\Faq\Faq;
use App\Repositories\Backend\Faq\FaqRepository;
use Illuminate\Http\Request;

class FaqController extends Controller {
	/**
	 * @var FaqRepository
	 */
	protected $faqRepository;

	/**
	 * FaqController constructor.
	 *
	 * @param FaqRepository $faqRepository
	 */
	public function __construct(FaqRepository $faqRepository) {
		$this->faqRepository = $faqRepository;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request) {
		return view('backend.faq.index')
			->withFaqs($this->faqRepository->getActivePaginated('', 'id', 'asc'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		try {

			return view('backend.faq.create')
				->withFaq(new faq())
				->withUser(User::where('active', '1')->pluck('first_name', 'id'));
		} catch (\Exception $ex) {

		}

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreFaqRequest $request) {

		$this->faqRepository->create($request->only(
			'title', 'status', 'description'
		));

		return redirect()->route('admin.faq.index')->withFlashSuccess(__('alerts.backend.faqs.created'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Faq $faq) {
		return view('backend.faq.edit')
			->withFaq($faq);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Faq $faq, UpdateFaqRequest $request) {

		$this->faqRepository->update($faq, $request->only(
			'title', 'status', 'description'
		));

		return redirect()->route('admin.faq.index')->withFlashSuccess(__('alerts.backend.faqs.updated'));

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request, Faq $faq) {
		$this->faqRepository->destroy($faq);

		//event(new UserDeleted($user));

		return redirect()->route('admin.faq.index')->withFlashSuccess(__('alerts.backend.faqs.deleted'));
	}
}
