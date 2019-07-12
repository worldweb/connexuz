<?php

namespace App\Repositories\Frontend\Network;

use App\Models\Auth\User;
use App\Models\Invite\Invite;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class NetworkRepository.
 */
class NetworkRepository extends BaseRepository {

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
//    public function getActivePaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc'): LengthAwarePaginator {
    //        return $this->model
    //                        ->orderBy($orderBy, $sort)
    //                        ->paginate($paged);
    //    }

    /**
     * @param int $uid
     *
     * @return mixed
     */
    public static function getAllAcceptedMyFriends($uid) {
//        DB::enableQueryLog();
        $getFriends = Invite::leftJoin('users', 'users.id', '=', 'user_invites.invite_user_id')
                ->where('user_id', $uid)
                ->where('type', "web")
                ->where('status', "1")
                ->get();
//        dd(DB::getQueryLog());
//        dd($getFriends);
        return $getFriends;
    }

    /**
     * @param int $uid
     *
     * @return mixed
     */
    public static function getAllMyAcceptedMyFriends($uid) {
//        DB::enableQueryLog();
        $getFriends = Invite::leftJoin('users', 'users.id', '=', 'user_invites.user_id')
                ->where('invite_user_id', $uid)
                ->where('type', "web")
                ->where('status', "1")
                ->get();
//        dd(DB::getQueryLog());
//        dd($getFriends);
        return $getFriends;
    }

    /**
     * @param int $uid
     *
     * @return mixed
     */
    public function getAllRequests($uid) {
//           DB::enableQueryLog();
        $getAllRequests = $this->model->select(['users.first_name', 'users.last_name', 'users.avatar_location', 'user_invites.id as uinvite_id', 'user_invites.invite_user_id as id', 'user_invites.status'])
                ->leftJoin('users', 'users.id', '=', 'user_invites.invite_user_id')->where('user_id', $uid)
                ->where('type', "web")
                ->where('status', "0")
                ->get();
//        dd(DB::getQueryLog());
//        dd($getAllRequests);
        return $getAllRequests;
    }

    /**
     * @param string $searchQuery
     * @param int    $paged
     * @param string $orderBy
     * @param string $sort
     * 
     * @return mixed
     */
    public function getAllPeoples($searchQuery, $paged = 25, $orderBy = 'created_at', $sort = 'desc') {
//        DB::enableQueryLog();
//        $getSearchedUsers = User::with('user_invite')->where("users.first_name", "like", $searchQuery)->orWhere("users.last_name", "like", $searchQuery)
//                ->orderBy($orderBy, $sort)
//                ->paginate($paged);
        $getSearchedUsersArray = array();
        $getSearchedUsers = User::select(["id", "first_name", "last_name", "avatar_location", "cover_image"])
                ->where("users.id", "!=", auth()->user()->id)
                ->where(function ($query) use ($searchQuery) {
                    foreach ($searchQuery as $key => $val) {
                        $query->where("users.first_name", "LIKE", "%$val%")
                        ->orWhere("users.last_name", "LIKE", "%$val%");
                    }
                })
                ->orderBy($orderBy, $sort)
                ->paginate($paged);

//        dd(DB::getQueryLog());
        $getSearchedUsersResults = $getSearchedUsers->toArray();
        $i = 0;
        $getSearchedUsersArray["current_page"] = $getSearchedUsersResults["current_page"];
        $getSearchedUsersArray["next_page_url"] = $getSearchedUsersResults["next_page_url"];
        if (!empty($getSearchedUsersResults["data"])) {
            foreach ($getSearchedUsersResults["data"] as $gsuk) {
                $getSearchedUsersArray["data"][$i]["id"] = $gsuk["id"];
                $getSearchedUsersArray["data"][$i]["first_name"] = $gsuk["first_name"];
                $getSearchedUsersArray["data"][$i]["last_name"] = $gsuk["last_name"];
                $getSearchedUsersArray["data"][$i]["full_name"] = $gsuk["full_name"];
                $getSearchedUsersArray["data"][$i]["avatar_location"] = $gsuk["avatar_location"];
                $getSearchedUsersArray["data"][$i]["cover_image"] = $gsuk["cover_image"];

                $getStatus = $this->model->where('user_id', '=', $gsuk["id"])
                                ->orWhere('invite_user_id', '=', $gsuk["id"])
                                ->where('type', '=', 'web')->get();
                if ($getStatus != null) {
                    $getSearchedUsersArray["data"][$i]["user_invite"] = $getStatus;
                } else {
                    $getSearchedUsersArray["data"][$i]["user_invite"] = array();
                }
                $i++;
            }
        }
        return $getSearchedUsersArray;
    }

    /**
     * @param string $action
     * @param int $user_id
     * @param int $loggedin_user_id
     *
     * @return mixed
     */
    public function friendOperations($data): Invite {

        return DB::transaction(function () use ($data) {
                    if ($data["action"] == "add_friend") {
                        $invite = parent::create([
                                    'user_id' => $data["user_id"],
                                    'invite_user_id' => $data["loggedin_user_id"],
                                    'status' => "0",
                                    'type' => "web",
                        ]);

                        if ($invite) {
                            return $invite;
                        }

                        throw new GeneralException(__('exceptions.frontend.auth.network.create_error'));
                    } else if ($data["action"] == "reject_friend") {
                        $invite = parent::updateById($data["uinvite_id"], array("status" => "2"));

                        if ($invite) {
                            return $invite;
                        }
                        throw new GeneralException(__('exceptions.frontend.auth.network.cancel_error'));
                    } else if ($data["action"] == "accept_friend") {
                        $invite = parent::updateById($data["uinvite_id"], array("status" => "1"));

                        if ($invite) {
                            return $invite;
                        }
                        throw new GeneralException(__('exceptions.frontend.auth.network.cancel_error'));
                    } else if ($data["action"] == "remove_friend" || $data["action"] == "cancel_friend") {
                        $invite = parent::getById($data["uinvite_id"]);
                        $isDelted = parent::deleteById($data["uinvite_id"]);

                        if ($isDelted) {
                            return $invite;
                        }
                        throw new GeneralException(__('exceptions.frontend.auth.network.cancel_error'));
                    }
                });
    }

}
