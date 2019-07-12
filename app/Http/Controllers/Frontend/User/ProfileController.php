<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\User\UpdateProfileRequest;
use App\Models\Auth\User;
use App\Models\Interest\Interest;
use App\Repositories\Frontend\Auth\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

/**
 * Class ProfileController.
 */
class ProfileController extends Controller {

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * ProfileController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    /**
     * @param UpdateProfileRequest $request
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */
    public function update(UpdateProfileRequest $request) {
        $output = $this->userRepository->update(
                $request->user()->id, $request->only('first_name', 'last_name', 'email', 'avatar_type', 'avatar_location'), $request->has('avatar_location') ? $request->file('avatar_location') : false
        );

        // E-mail address was updated, user has to reconfirm
        if (is_array($output) && $output['email_changed']) {
            auth()->logout();

            return redirect()->route('frontend.auth.login')->withFlashInfo(__('strings.frontend.user.email_changed_notice'));
        }

        return redirect()->route('frontend.user.account')->withFlashSuccess(__('strings.frontend.user.profile_updated'));
    }

    /**
     * @param UpdateProfileRequest $request
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */
    public function updateprofile(UpdateProfileRequest $request) {

        $output = $this->userRepository->update(
                $request->user()->id, $request->only(
                        'first_name', 'last_name', 'email', 'avatar_type', 'avatar_location', 'date_of_birth', 'gender', 'city', 'country', 'about', 'university', 'education_from_date', 'education_to_date', 'education_about', 'graduted', 'user_interests', 'old_password', 'password'
                ), $request->has('avatar_location') ? $request->file('avatar_location') : false
        );

        // E-mail address was updated, user has to reconfirm
        if (is_array($output) && $output['email_changed']) {
            auth()->logout();

            return redirect()->route('frontend.auth.login')->withFlashInfo(__('strings.frontend.user.email_changed_notice'));
        }

        return redirect()->route('frontend.user.account')->withFlashSuccess(__('strings.frontend.user.profile_updated'));
    }

    /**
     * @param Request $request
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */
    public function deleteInterest(Request $request) {
        $interest = new Interest();
        $deleted = $interest->where('id', $request->only("i_id"))->delete();
        if ($deleted) {
            return response()->json(['success' => 'true']);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    /*
     * profile image store
     */

    public function imageCropPost(Request $request) {

        $data = $request->image;

        list($type, $data) = explode(';', $data);
        list(, $data) = explode(',', $data);

        $data = base64_decode($data);
        $image_name = time() . '.png';
        $path = public_path() . "/storage/avatars/" . $image_name;
        file_put_contents($path, $data);

        $output = $this->userRepository->updateUserAvatar($request->user()->id, url('/') . "/storage/avatars/" . $image_name);

        return response()->json(['success' => 'done', "image" => url('/') . "/storage/avatars/" . $image_name]);
    }

    /*
     * cover image store
     */

    public function coverImageCropPost(Request $request) {

        $data = $request->image;

        list($type, $data) = explode(';', $data);
        list(, $data) = explode(',', $data);

        $data = base64_decode($data);
        $image_name = time() . '.png';
        $path = public_path() . "/storage/avatars/" . $image_name;
        file_put_contents($path, $data);

        $output = $this->userRepository->updateUserCoverImage($request->user()->id, url('/') . "/storage/avatars/" . $image_name);

        return response()->json(['success' => 'done', "image" => url('/') . "/storage/avatars/" . $image_name]);
    }

    public function inviteUser(Request $request) {
        try {
            if (\Auth::check()) {
                $userData = auth()->user();
                $data = $request->all();
                $data['uid'] = $userData->id;

                $output = $this->userRepository->userInviteEmail($data);
                if ($output) {
                    return response()->json(['success' => true]);
                } else {
                    return response()->json(['success' => 'Try Again']);
                }
            } else {
                return redirect()->route('frontend.auth.login');
            }
        } catch (Exception $ex) {
            dd($ex);
            Log::error($ex->getMessage());
            //return view('errors.404');
        }
    }

    public function friendProfile($id, Request $request) {
        $interest = Interest::where("user_id", '=', $id)->get();
        $user = User::findorfail($id);
        return view('frontend.user.friend-profile-view')
                        ->withUserDetail($user)
                        ->withRequest($request)
                        ->withUserInterest($interest);
    }

}
