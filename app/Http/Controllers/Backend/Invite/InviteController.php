<?php

namespace App\Http\Controllers\Backend\Invite;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Invite\StoreInviteRequest;
use App\Models\Invite\Invite;
use App\Repositories\Backend\Invite\InviteRepository;
use Illuminate\Http\Request;

class InviteController extends Controller {
	/**
	 * @var InviteRepository
	 */
	protected $inviteRepository;

	/**
	 * InviteController constructor.
	 *
	 * @param InviteRepository $inviteRepository
	 */
	public function __construct(InviteRepository $inviteRepository) {
		$this->inviteRepository = $inviteRepository;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request) {
		return view('backend.invite.index')
			->withInvites($this->inviteRepository
					->with('users', 'invite_user')
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
	public function store(StoreInviteRequest $request) {

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Invite $invite) {
		return view('backend.invite.edit')
			->withInvite($invite);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Invite $invite) {

		$this->inviteRepository->update($invite, $request->only(
			'name',
			'status'
		));

		return redirect()->route('admin.invite.index')->withFlashSuccess(__('alerts.backend.invites.updated'));

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request, Invite $invite) {

	}
}
