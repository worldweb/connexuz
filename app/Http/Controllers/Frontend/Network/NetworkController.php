<?php

namespace App\Http\Controllers\Frontend\Network;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Network\NetworkRepository;
use Illuminate\Http\Request;


/**
 * Class NetworkController.
 */
class NetworkController extends Controller {

	/**
	 * @var $networkRepository
	 */
	protected $networkRepository;

	/**
	 * PostController constructor.
	 *
	 * @param PostRepository $postRepository
	 */
	public function __construct(NetworkRepository $networkRepository) {
		$this->networkRepository = $networkRepository;
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(Request $request) {
            
            // Check subscription
            if(auth()->user()->is_subscribed == 0){
                return redirect()->route('frontend.user.settings')->withFlashError('Your subscription has been expire.');
            }
            
		return view('frontend.network.network')
			->withMyFriends($this->networkRepository->getAllAcceptedMyFriends(auth()->user()->id))
			->withMyAcceptedFriends($this->networkRepository->getAllMyAcceptedMyFriends(auth()->user()->id))
			->withMyRequests($this->networkRepository->getAllRequests(auth()->user()->id))
			->withUserId(auth()->user()->id)->withRequest($request);
	}

	public function searchFriend(Request $request) {
		$searchFriendResults = $this->networkRepository->getAllPeoples($request->only('searchQuery'), 5, "users.id", "desc");

		return response()->json(['success' => 'done', "data" => $searchFriendResults]);
	}

	public function addFriend(Request $request) {
		$data = $request->only('action', 'user_id', 'uinvite_id');
		$data['loggedin_user_id'] = auth()->user()->id;
		$requestOperation = $this->networkRepository->friendOperations($data);
		return response()->json(['success' => 'done', "data" => $requestOperation]);
	}

}
