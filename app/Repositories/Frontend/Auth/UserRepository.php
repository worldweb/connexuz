<?php

namespace App\Repositories\Frontend\Auth;

use App\Events\Frontend\Auth\UserConfirmed;
use App\Events\Frontend\Auth\UserProviderRegistered;
use App\Exceptions\GeneralException;
use App\Models\Auth\SocialAccount;
use App\Models\Auth\User;
use App\Models\Interest\Interest;
use App\Models\Invite\Invite;
use App\Notifications\Frontend\Auth\UserNeedsConfirmation;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mail;

/**
 * Class UserRepository.
 */
class UserRepository extends BaseRepository {

    /**
     * @return string
     */
    public function model() {
        return User::class;
    }

    /**
     * @param $token
     *
     * @return bool|\Illuminate\Database\Eloquent\Model
     */
    public function findByPasswordResetToken($token) {
        foreach (DB::table(config('auth.passwords.users.table'))->get() as $row) {
            if (password_verify($token, $row->token)) {
                return $this->getByColumn($row->email, 'email');
            }
        }
        return false;
    }

    /**
     * @param $uuid
     *
     * @return mixed
     * @throws GeneralException
     */
    public function findByUuid($uuid) {
        $user = $this->model
                ->uuid($uuid)
                ->first();

        if ($user instanceof $this->model) {
            return $user;
        }

        throw new GeneralException(__('exceptions.backend.access.users.not_found'));
    }

    /**
     * @param $code
     *
     * @return mixed
     * @throws GeneralException
     */
    public function findByConfirmationCode($code) {
        $user = $this->model
                ->where('confirmation_code', $code)
                ->first();

        if ($user instanceof $this->model) {
            return $user;
        }

        throw new GeneralException(__('exceptions.backend.access.users.not_found'));
    }

    /**
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model|mixed
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data) {
//            echo '<pre>'; print_r($data); exit;
        return DB::transaction(function () use ($data) {
                    $user = parent::create([
                                'first_name' => $data['first_name'],
                                'last_name' => '',
                                'email' => $data['email'],
                                'subscription_expiry_date' => date('Y-m-d', strtotime('+1 months')),
                                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                                'active' => 1,
                                'password' => $data['password'],
                                // If users require approval or needs to confirm email
                                'confirmed' => config('access.users.requires_approval') || config('access.users.confirm_email') ? 0 : 1,
                    ]);

                    if ($user) {
                        /*
                         * Add the default site role to the new user
                         */
                        $user->assignRole(config('access.users.default_role'));
                    }

                    /*
                     * If users have to confirm their email and this is not a social account,
                     * and the account does not require admin approval
                     * send the confirmation email
                     *
                     * If this is a social account they are confirmed through the social provider by default
                     */
                    if (config('access.users.confirm_email')) {
                        // Pretty much only if account approval is off, confirm email is on, and this isn't a social account.
                        $user->notify(new UserNeedsConfirmation($user->confirmation_code));
                    }

                    /*
                     * Return the user object
                     */
                    return $user;
                });
    }

    /**
     * @param       $id
     * @param array $input
     * @param bool|UploadedFile  $image
     *
     * @return array|bool
     * @throws GeneralException
     */
    public function update($id, array $input, $image = false) {

        $user = $this->getById($id);
        $user->first_name = $input['first_name'];
        $user->last_name = $input['last_name'];
//        $user->avatar_type = $input['avatar_type'];
        $user->date_of_birth = ($input['date_of_birth'] != '') ? date('Y-m-d H:i:s', strtotime($input['date_of_birth'])) : null;
        $user->gender = isset($input['gender']) && $input['gender'] == '1' ? 1 : 2;
        $user->city = $input['city'];
        $user->country = $input['country'];
        $user->about = $input['about'];
        $user->university = $input['university'];
        $user->education_from_date = ($input['education_from_date'] != '') ? date('Y-m-d H:i:s', strtotime($input['education_from_date'])) : null;
        $user->education_to_date = ($input['education_to_date'] != '') ? date('Y-m-d H:i:s', strtotime($input['education_to_date'])) : null;
        $user->education_about = $input['education_about'];
        $user->graduted = isset($input['graduted']) && $input['graduted'] == '1' ? 1 : 0;

//        $deleted = Interest::where('user_id', $id)->delete();
        if (!empty($input["user_interests"])) {
            $input["user_interests"] = explode(",", $input["user_interests"]);
            if (is_array($input["user_interests"])) {
                foreach ($input["user_interests"] as $uik) {
                    $interest = new Interest();
                    $interest->user_id = $id;
                    $interest->title = trim($uik);
                    $interest->save();
                }
            } else {
                $interest = new Interest();
                $interest->user_id = $id;
                $interest->title = $input["user_interests"];
                $interest->save();
            }
        }

        // Upload profile image if necessary
        //        if ($image) {
        //            $user->avatar_location = $image->store('/avatars', 'public');
        //        } else {
        //            // No image being passed
        //            if ($input['avatar_type'] == 'storage') {
        //                // If there is no existing image
        //                if (!strlen(auth()->user()->avatar_location)) {
        //                    throw new GeneralException('You must supply a profile image.');
        //                }
        //            } else {
        //                // If there is a current image, and they are not using it anymore, get rid of it
        //                if (strlen(auth()->user()->avatar_location)) {
        //                    Storage::disk('public')->delete(auth()->user()->avatar_location);
        //                }
        //
		//                $user->avatar_location = null;
        //            }
        //        }

        if ($user->canChangeEmail()) {
            //Address is not current address so they need to reconfirm
            if ($user->email != $input['email']) {
                //Emails have to be unique
                if ($this->getByColumn($input['email'], 'email')) {
                    throw new GeneralException(__('exceptions.frontend.auth.email_taken'));
                }

                // Force the user to re-verify his email address if config is set
                if (config('access.users.confirm_email')) {
                    $user->confirmation_code = md5(uniqid(mt_rand(), true));
                    $user->confirmed = 0;
                    $user->notify(new UserNeedsConfirmation($user->confirmation_code));
                }
                $user->email = $input['email'];
                $updated = $user->save();

                // Send the new confirmation e-mail

                return [
                    'success' => $updated,
                    'email_changed' => true,
                ];
            }
        }

//        $user = $this->getById(auth()->id());
        if (!empty($input['old_password']) && !empty($input['password'])) {
            if (Hash::check($input['old_password'], $user->password)) {
//            if ($expired) {
                //                $user->password_changed_at = Carbon::now()->toDateTimeString();
                //            }
                $updatedPasswordReturn = $user->update(['password' => $input['password']]);
            } else {
                throw new GeneralException(__('exceptions.frontend.auth.password.change_mismatch'));
            }
        }

//        throw new GeneralException(__('exceptions.frontend.auth.password.change_mismatch'));

        return $user->save();
    }

    /**
     * @param      $input
     * @param bool $expired
     *
     * @return bool
     * @throws GeneralException
     */
    public function updatePassword($input, $expired = false) {

        $user = $this->getById(auth()->id());

        if (Hash::check($input['old_password'], $user->password)) {
            if ($expired) {
                $user->password_changed_at = Carbon::now()->toDateTimeString();
            }
            return $user->update(['password' => $input['password']]);
        }

        throw new GeneralException(__('exceptions.frontend.auth.password.change_mismatch'));
    }

    /**
     * @param $code
     *
     * @return bool
     * @throws GeneralException
     */
    public function confirm($code) {
        $user = $this->findByConfirmationCode($code);

        if ($user->confirmed == 1) {
            throw new GeneralException(__('exceptions.frontend.auth.confirmation.already_confirmed'));
        }

        if ($user->confirmation_code == $code) {
            $user->confirmed = 1;

            event(new UserConfirmed($user));

            return $user->save();
        }

        throw new GeneralException(__('exceptions.frontend.auth.confirmation.mismatch'));
    }

    /**
     * @param $data
     * @param $provider
     *
     * @return mixed
     * @throws GeneralException
     */
    public function findOrCreateProvider($data, $provider) {
        // User email may not provided.
        $user_email = $data->email ?: "{$data->id}@{$provider}.com";

        // Check to see if there is a user with this email first.
        $user = $this->getByColumn($user_email, 'email');

        /*
         * If the user does not exist create them
         * The true flag indicate that it is a social account
         * Which triggers the script to use some default values in the create method
         */
        if (!$user) {
            // Registration is not enabled
            if (!config('access.registration')) {
                throw new GeneralException(__('exceptions.frontend.auth.registration_disabled'));
            }

            // Get users first name and last name from their full name
            $nameParts = $this->getNameParts($data->getName());

            $user = parent::create([
                        'first_name' => $nameParts['first_name'],
                        'last_name' => $nameParts['last_name'],
                        'email' => $user_email,
                        'active' => 1,
                        'confirmed' => 1,
                        'password' => null,
                        'avatar_type' => $provider,
            ]);

            event(new UserProviderRegistered($user));
        }

        // See if the user has logged in with this social account before
        if (!$user->hasProvider($provider)) {
            // Gather the provider data for saving and associate it with the user
            $user->providers()->save(new SocialAccount([
                'provider' => $provider,
                'provider_id' => $data->id,
                'token' => $data->token,
                'avatar' => $data->avatar,
            ]));
        } else {
            // Update the users information, token and avatar can be updated.
            $user->providers()->update([
                'token' => $data->token,
                'avatar' => $data->avatar,
            ]);

            $user->avatar_type = $provider;
            $user->update();
        }

        // Return the user object
        return $user;
    }

    /**
     * @param $fullName
     *
     * @return array
     */
    protected function getNameParts($fullName) {
        $parts = array_values(array_filter(explode(' ', $fullName)));
        $size = count($parts);
        $result = [];

        if (empty($parts)) {
            $result['first_name'] = null;
            $result['last_name'] = null;
        }

        if (!empty($parts) && $size == 1) {
            $result['first_name'] = $parts[0];
            $result['last_name'] = null;
        }

        if (!empty($parts) && $size >= 2) {
            $result['first_name'] = $parts[0];
            $result['last_name'] = $parts[1];
        }

        return $result;
    }

    public static function getUserByID($id = '') {
        $user = User::find($id);
        return $user;
    }

    /**
     * @param array $data
     *
     * @return True
     * @throws \Exception
     * @throws \Throwable
     */
    public function userInviteEmail(array $data): Invite {
        return DB::transaction(function () use ($data) {
                    $iEmail = $data['invite_email'];
                    $iEmail = explode(',', $iEmail);
                    foreach ($iEmail as $email) {
                        $user = new Invite();

                        $user->user_id = $data['uid'];
                        $user->type = 'email';
                        $user->invite_email = $email;
                        $mail_user = array();
                        if ($user->save()) {
                            //Send confirmation email if requested and account approval is off
                            if (isset($email)) {
                                Mail::send('frontend.mail.invite.invite', $mail_user, function ($m) use ($user) {
                                    $m->from('info@connexuz.com', 'Invite to Connexuz Application');
                                    $m->to($user->invite_email)->subject('Connexuz Invitation!');
                                });
                            }
                        }
                    }
                    return $user;
                    throw new GeneralException(__('exceptions.backend.access.users.create_error'));
                });
    }

    /**
     * @param $id
     * @param string $image
     *
     * @return array
     */
    public function updateUserAvatar($id, $image) {
        $user = $this->getById($id);
        $user->avatar_type = "storage";
        $user->avatar_location = $image;
        return $user->save();
    }

    /**
     * @param $id
     * @param string $image
     *
     * @return array
     */
    public function updateUserCoverImage($id, $image) {
        $user = $this->getById($id);
        $user->cover_image = $image;
        return $user->save();
    }
    
    
//    public function get_user_friends($user_id){
//        
//    }

}
