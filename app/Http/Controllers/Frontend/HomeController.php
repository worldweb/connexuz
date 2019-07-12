<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post\Post;
use App\Repositories\Backend\Post\PostRepository;
use App\Repositories\Frontend\Auth\UserRepository;
use DB;
use Illuminate\Http\Request;
use App\Models\Comment\CommentLikes;

/**
 * Class HomeController.
 */
class HomeController extends Controller {

    /**
     * @var UserRepository
     */
    protected $userRepository, $postRepository;
    protected $pagelimit;

    /**
     * InteractionController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository, PostRepository $postRepository) {
        $this->userRepository = $userRepository;
        $this->postRepository = $postRepository;
        $this->pagelimit = 5;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index(Request $request) {
        // Check subscription
        if(auth()->user()->is_subscribed == 0){
            return redirect()->route('frontend.user.settings')->withFlashError('Your subscription has been expire.');
        }
        
        try {

            if (\Auth::check()) {
                $userData = auth()->user();

                return view('frontend.interaction.index')
                                ->withPagelimit($this->pagelimit)
                                ->withRequest($request);
            } else {
                return redirect()->route('frontend.auth.login');
            }
        } catch (Exception $ex) {
            dd($ex);
            Log::error($ex->getMessage());
            //return view('errors.404');
        }
    }
    
    function ajax_friendposts(Request $request){
        if (\Auth::check()) {
                $userData = auth()->user();
                
                if($request->get('frnsearchdata') != ''){
                        $friendPosts = Post::with('user', 'post_images', 'post_comments', 'post_likes')
                        ->where('user_id', '!=', $userData->id)
                        ->whereIn('user_id', function ($query) use ($userData,$request) {
                            $query->select(DB::raw('user_id'))
                            ->from('user_invites')
                            ->join('users', 'users.id', '=', 'user_invites.user_id')
                            ->where('user_invites.invite_user_id', $userData->id)->where('status', DB::raw("CONVERT(1, CHAR)"))
                            ->where(function ($query) use ($request) {
                            $query->where('first_name', 'like', '%'.trim($request->get('frnsearchdata')).'%')
                                  ->orWhere('last_name', 'like', '%'.trim($request->get('frnsearchdata')).'%');
                            });
                        })
                        ->OrwhereIn('user_id', function ($query) use ($userData,$request) {
                            $query->select(DB::raw('invite_user_id'))
                            ->from('user_invites')
                            ->join('users', 'users.id', '=', 'user_invites.invite_user_id')
                            ->where('user_invites.user_id', $userData->id)->where('status', DB::raw("CONVERT(1, CHAR)"))
                            ->where(function ($query) use ($request) {
                            $query->where('first_name', 'like', '%'.trim($request->get('frnsearchdata')).'%')
                                  ->orWhere('last_name', 'like', '%'.trim($request->get('frnsearchdata')).'%');
                            });
                        })
                        ->orderby('created_at', 'desc')->skip(trim($request->get('pageNumber')))->take($this->pagelimit)->get(); 
                    }else{
                         $friendPosts = Post::with('user', 'post_images', 'post_comments', 'post_likes')
                        ->where('user_id', '!=', $userData->id)
                        ->whereIn('user_id', function ($query) use ($userData) {
                            $query->select(DB::raw('user_id'))
                            ->from('user_invites')
                            ->where('user_invites.invite_user_id', $userData->id)->where('status', DB::raw("CONVERT(1, CHAR)"));
                        })
                        ->OrwhereIn('user_id', function ($query) use ($userData) {
                            $query->select(DB::raw('invite_user_id'))
                            ->from('user_invites')
                            ->where('user_invites.user_id', $userData->id)->where('status', DB::raw("CONVERT(1, CHAR)"));
                        })
                        ->orderby('created_at', 'desc')->skip(trim($request->get('pageNumber')))->take($this->pagelimit)->get();
                    }
                    
                $comment_list = CommentLikes::where('user_id', '=', $userData->id)
                                    ->OrwhereIn('user_id', function ($query) use ($userData) {
                                        $query->select(DB::raw('user_id'))
                                        ->from('user_invites')
                                        ->where('user_invites.invite_user_id', $userData->id)->where('status', DB::raw("CONVERT(1, CHAR)"));
                                    })
                                    ->OrwhereIn('user_id', function ($query) use ($userData) {
                                        $query->select(DB::raw('invite_user_id'))
                                        ->from('user_invites')
                                        ->where('user_invites.user_id', $userData->id)->where('status', DB::raw("CONVERT(1, CHAR)"));
                                    })->get();
                
                $returnHTML = view('frontend.interaction.ajax_friendposts')
                                ->withFriendPostData($friendPosts)
//                                ->withRequest($request)
                                ->withCommentlist($comment_list)
                                ->render();
                return response()->json(array('success' => true,'total_data'=>count($friendPosts), 'html'=>$returnHTML));
                
            } else {
                return redirect()->route('frontend.auth.login');
            }
    }
    
    function ajax_myposts(Request $request){
        try {
            
            if (\Auth::check()) {
                $userData = auth()->user();

                $myPosts = Post::with('user', 'post_images', 'post_comments', 'post_likes')->where('user_id', $userData->id);
                if ($request->get('posts_search_header') != '') {
                    $myPosts->where('description', 'like', '%' . trim($request->get('posts_search_header')) . '%');
                }
                $myPosts->orderby('created_at', 'desc')->skip(trim($request->get('pageNumber')))->take($this->pagelimit);
                $my_posts = $myPosts->get();
                
                $comment_list = CommentLikes::where('user_id', '=', $userData->id)
                                    ->OrwhereIn('user_id', function ($query) use ($userData) {
                                        $query->select(DB::raw('user_id'))
                                        ->from('user_invites')
                                        ->where('user_invites.invite_user_id', $userData->id)->where('status', DB::raw("CONVERT(1, CHAR)"));
                                    })
                                    ->OrwhereIn('user_id', function ($query) use ($userData) {
                                        $query->select(DB::raw('invite_user_id'))
                                        ->from('user_invites')
                                        ->where('user_invites.user_id', $userData->id)->where('status', DB::raw("CONVERT(1, CHAR)"));
                                    })->get();
                                    
                $returnview = view('frontend.interaction.ajax_myposts')
                                ->withMyPostData($my_posts)
                                ->withCommentlist($comment_list);
                $returnHTML = $returnview->render();
                
                //dd($friendPosts);
//                $returnHTML = view('frontend.interaction.ajax_myposts')
//                                ->withMyPostData($my_posts)
////                                ->withRequest($request)
//                                ->withCommentlist($comment_list)
//                                ->render();
                return response()->json(array('success' => true,'total_data'=>count($my_posts), 'html'=>$returnHTML));
                
            } else {
                return redirect()->route('frontend.auth.login');
            }
        } catch (Exception $ex) {
            dd($ex);
            Log::error($ex->getMessage());
            //return view('errors.404');
        }
    }

}
