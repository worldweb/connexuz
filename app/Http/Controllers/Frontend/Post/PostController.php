<?php

namespace App\Http\Controllers\Frontend\Post;

use App\Http\Controllers\Controller;
use App\Models\Post\Post;
use App\Repositories\Backend\Post\PostRepository;
use App\Repositories\Frontend\Auth\UserRepository;
use Illuminate\Http\Request;

/**
 * Class HomeController.
 */
class PostController extends Controller {

    /**
     * @var UserRepository
     */
    protected $userRepository, $postRepository;

    /**
     * InteractionController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository, PostRepository $postRepository) {
        $this->userRepository = $userRepository;
        $this->postRepository = $postRepository;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index(Request $request) {
        
        // Check subscription
        if (auth()->user()->is_subscribed == 0) {
            return redirect()->route('frontend.user.settings')->withFlashError('Your subscription has been expire.');
        }
    }

    public function postCommnet(Request $request) {
        try {
            if (\Auth::check()) {
                $userData = auth()->user();
                $data = $request->all();
                
                $data['uid'] = $userData->id;
                $data['userData'] = $userData;

                $this->postRepository->createComment($data);

                return redirect()->route('frontend.index')->withFlashSuccess('Comment added Successfully.');
            }
        } catch (Exception $ex) {
            dd($ex);
            Log::error($ex->getMessage());
            //return view('errors.404');
        }
    }

    public function createPost(Request $request) {

        $flag = 1;
        $image = $request->file('post_image');
        if(!empty($image)){
            $img_file = $image[0]->getRealPath();
            $file_size = filesize($img_file);
            $file_size = $this->formatSizeUnits($file_size);

            $explode_file_size = explode(" ", $file_size);
            if (trim($explode_file_size[1]) == 'MB') {
                if (trim($explode_file_size[0]) > 100) {
                    return redirect()->route('frontend.index')->withFlashError('File size lessthan 100 MB require.');
                    $flag = 0;
                }
            }
        }

        if ($flag) {
            try {
                if (\Auth::check()) {
                    $userData = auth()->user();
                    $data = $request->all();
                    $data['uid'] = $userData->id;
                    $data['ip_address'] = get_client_ip();
                    $data['userData'] = $userData;

                    $this->postRepository->createPost($data);
                    
                    return redirect()->route('frontend.index')->withFlashSuccess('Post added Successfully.');
                }
            } catch (Exception $ex) {
                dd($ex);
                Log::error($ex->getMessage());
                //return view('errors.404');
            }
        }
    }

    public function addPostLike(Request $request) {
        try {
            if (\Auth::check()) {
                $userData = auth()->user();
                $data = $request->all();
                $data['uid'] = $userData->id;
                $data['ip_address'] = get_client_ip();

                $output = $this->postRepository->addEditPostLikes($data);

                if ($output) {
                    return response()->json(['success' => true]);
                } else {
                    return response()->json(['success' => false]);
                }
            }
        } catch (Exception $ex) {
            dd($ex);
            Log::error($ex->getMessage());
            //return view('errors.404');
        }
    }

    public function addCommentLike(Request $request) {
        try {
            if (\Auth::check()) {
                $userData = auth()->user();
                $data = $request->all();
                $data['uid'] = $userData->id;
                $data['ip_address'] = get_client_ip();

                $output = $this->postRepository->addEditCommentLikes($data);

                if ($output) {
                    return response()->json(['success' => true]);
                } else {
                    return response()->json(['success' => false]);
                }
            }
        } catch (Exception $ex) {
            dd($ex);
            Log::error($ex->getMessage());
            //return view('errors.404');
        }
    }

    public function popupData(Request $request) {
        try {
            $data = $request->all();
            $myPosts = Post::with('user', 'post_images', 'post_comments', 'post_likes')->where('id', $data['id'])->first();

            if ($myPosts) {
                $postsDetailHtml = view('frontend.popup.view-post', ['myPost' => $myPosts])->render();
            }
            return ['postsDetailHtml' => $postsDetailHtml];
        } catch (Exception $ex) {
            
        }
    }

    function formatSizeUnits($bytes) {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

}
