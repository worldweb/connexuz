<?php

namespace App\Http\Controllers\Backend\Auth\User;

use App\Models\Auth\User;
use App\Models\Interest\Interest;
use App\Http\Controllers\Controller;
use App\Events\Backend\Auth\User\UserDeleted;
use App\Repositories\Backend\Auth\RoleRepository;
use App\Repositories\Backend\Auth\UserRepository;
use App\Repositories\Backend\Auth\PermissionRepository;
use App\Http\Requests\Backend\Auth\User\StoreUserRequest;
use App\Http\Requests\Backend\Auth\User\ManageUserRequest;
use App\Http\Requests\Backend\Auth\User\UpdateUserRequest;

/**
 * Class UserController.
 */
class UserController extends Controller {

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * UserController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    /**
     * @param ManageUserRequest $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(ManageUserRequest $request) {
        //dd($this->userRepository->getActivePaginated('', 'id', 'desc'));
        return view('backend.auth.user.index')
			->withUsers($this->userRepository
					->orderBy('updated_at', 'desc')
					->paginate());
    }

    /**
     * @param ManageUserRequest    $request
     * @param RoleRepository       $roleRepository
     * @param PermissionRepository $permissionRepository
     *
     * @return mixed
     */
    public function create(ManageUserRequest $request, RoleRepository $roleRepository, PermissionRepository $permissionRepository) {
        return view('backend.auth.user.create')
                        ->withRoles($roleRepository->with('permissions')->get(['id', 'name']))
                        ->withPermissions($permissionRepository->get(['id', 'name']));
    }

    /**
     * @param StoreUserRequest $request
     *
     * @return mixed
     * @throws \Throwable
     */
    public function store(StoreUserRequest $request) {

        $this->userRepository->create($request->only(
                        'first_name', 'last_name', 'email', 'password', 'mobile_number', 'active', 'confirmed', 'confirmation_email', 'roles', 'permissions', 'date_of_birth', 'gender', 'city', 'country', 'about', 'university', 'education_from_date', 'education_to_date', 'education_about', 'graduted', 'user_interests'
        ));

        return redirect()->route('admin.auth.user.index')->withFlashSuccess(__('alerts.backend.users.created'));
    }

    /**
     * @param ManageUserRequest $request
     * @param User              $user
     *
     * @return mixed
     */
    public function show(ManageUserRequest $request, User $user) {
        $interest = Interest::where("user_id", '=', $user->id)->get();
       // dd($user);
        return view('backend.auth.user.show')
                        ->withUser($user)
                        ->withInterest($interest);
    }

    /**
     * @param ManageUserRequest    $request
     * @param RoleRepository       $roleRepository
     * @param PermissionRepository $permissionRepository
     * @param User                 $user
     *
     * @return mixed
     */
    public function edit(ManageUserRequest $request, RoleRepository $roleRepository, PermissionRepository $permissionRepository, User $user) {
        $interest = Interest::where("user_id", '=', $user->id)->get();

        return view('backend.auth.user.edit', compact('interest'))
                        ->withUser($user)
                        ->withRoles($roleRepository->get())
                        ->withUserRoles($user->roles->pluck('name')->all())
                        ->withPermissions($permissionRepository->get(['id', 'name']))
                        ->withUserPermissions($user->permissions->pluck('name')->all());
    }

    /**
     * @param UpdateUserRequest $request
     * @param User              $user
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function update(UpdateUserRequest $request, User $user) {
        $this->userRepository->update($user, $request->only(
                        'first_name', 'last_name', 'email', 'mobile_number', 'roles', 'permissions', 'date_of_birth', 'gender', 'city', 'country', 'about', 'university', 'education_from_date', 'education_to_date', 'education_about', 'graduted', 'user_interests'
        ));

        return redirect()->route('admin.auth.user.index')->withFlashSuccess(__('alerts.backend.users.updated'));
    }

    /**
     * @param ManageUserRequest $request
     * @param User              $user
     *
     * @return mixed
     * @throws \Exception
     */
    public function destroy(ManageUserRequest $request, User $user) {
        $this->userRepository->deleteById($user->id);

        event(new UserDeleted($user));

        return redirect()->route('admin.auth.user.deleted')->withFlashSuccess(__('alerts.backend.users.deleted'));
    }

}
