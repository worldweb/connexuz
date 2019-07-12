<?php

namespace App\Http\Controllers\Backend\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Auth\User\ManageUserRequest;
use App\Repositories\Backend\Post\PostRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class TableController.
 */
class TableController extends Controller
{
    /**
     * @var PostRepository
     */
    protected $post;

    /**
     * TableController constructor.
     *
     * @param \App\Http\Controllers\Backend\Post\PostRepository $Post
     */
    public function __construct(PostRepository $post)
    {
        $this->post = $post;
    }

    /**
     * @param ManageUserRequest $request
     *
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        $requestData = $request->only('title', 'status');
        $datatables = Datatables::of($this->post->getForDataTable($requestData)->withoutGlobalScopes())
                        ->escapeColumns(['id','private_post'])
                        ->addColumn('created_at', function ($post) {
                            return $post->created_at->diffForHumans();
                        })
                        ->addColumn('status', function ($post) {
                            return $post->status_button;
                        })
                        ->addColumn('name', function ($post) {
                            return $post->name;
                        })
                        ->addColumn('description', function ($post) {
                            return truncate($post->description,30);
                        })
                        ->addColumn('actions', function ($post) {
                            return $post->action_buttons;
                        })
                        ->addIndexColumn();

        return $datatables->make(true);
    }
}
