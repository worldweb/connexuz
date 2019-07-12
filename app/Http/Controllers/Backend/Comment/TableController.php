<?php

namespace App\Http\Controllers\Backend\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Auth\User\ManageUserRequest;
use App\Repositories\Backend\Comment\CommentRepository;
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
    public function __construct(CommentRepository $comment)
    {
        $this->comment = $comment;
    }

    /**
     * @param ManageUserRequest $request
     *
     * @return mixed
     */
//    public function __invoke(Request $request)
            public function datatablefunction(Request $request)
    {
        $requestData = $request->only('title', 'status');
        $datatables = Datatables::of($this->comment->getForDataTablfdsfe()->withoutGlobalScopes())
                        ->escapeColumns(['id','private_post'])
                        ->addColumn('created_at', function ($comment) {
                            return $comment->created_at->diffForHumans();
                        })
                        ->addColumn('status', function ($comment) {
                            return $comment->status_button;
                        })
                        ->addColumn('name', function ($comment) {
                            return $comment->name;
                        })
                        ->addColumn('description', function ($comment) {
                            return truncate($comment->description,30);
                        })
                        ->addColumn('actions', function ($comment) {
                            return $comment->action_buttons;
                        })
                        ->addIndexColumn();

        return $datatables->make(true);
    }
}
