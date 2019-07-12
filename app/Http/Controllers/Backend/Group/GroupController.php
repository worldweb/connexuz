<?php

namespace App\Http\Controllers\Backend\Group;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Group\StoreGroupRequest;
use App\Http\Requests\Backend\Group\UpdateGroupRequest;
use App\Models\Auth\User;
use App\Models\Group\Group;
use App\Repositories\Backend\Group\GroupRepository;
use Illuminate\Http\Request;

class GroupController extends Controller {
	/**
	 * @var GroupRepository
	 */
	protected $groupRepository;

	/**
	 * GroupController constructor.
	 *
	 * @param GroupRepository $groupRepository
	 */
	public function __construct(GroupRepository $groupRepository) {
		$this->groupRepository = $groupRepository;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request) {
		return view('backend.group.index')
			->withGroups($this->groupRepository->getActivePaginated('', 'id', 'asc'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		try {

			return view('backend.group.create')
				->withGroup(new group())
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
	public function store(StoreGroupRequest $request) {

		$this->groupRepository->create($request->only(
			'name',
			'status'
		));

		return redirect()->route('admin.group.index')->withFlashSuccess(__('alerts.backend.groups.created'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Group $group) {
		return view('backend.group.edit')
			->withGroup($group);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Group $group, UpdateGroupRequest $request) {

		$this->groupRepository->update($group, $request->only(
			'name',
			'status'
		));

		return redirect()->route('admin.group.index')->withFlashSuccess(__('alerts.backend.groups.updated'));

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request, Group $group) {
		$this->groupRepository->destroy($group);

		//event(new UserDeleted($user));

		return redirect()->route('admin.group.index')->withFlashSuccess(__('alerts.backend.groups.deleted'));
	}
}
