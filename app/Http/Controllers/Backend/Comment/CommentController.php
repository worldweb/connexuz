<?php

namespace App\Http\Controllers\Backend\Comment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Comment\StoreCommentRequest;
use App\Models\Comment\Comment;
use App\Repositories\Backend\Comment\CommentRepository;
use Illuminate\Http\Request;

class CommentController extends Controller {
	/**
	 * @var CommentRepository
	 */
	protected $commentRepository;

	/**
	 * CommentController constructor.
	 *
	 * @param CommentRepository $commentRepository
	 */
	public function __construct(CommentRepository $commentRepository) {
		$this->commentRepository = $commentRepository;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request) {
		return view('backend.comment.index')
			->withComments($this->commentRepository
					->with('users', 'posts', 'reply_user')
					->orderBy('created_at', 'desc')
					->paginate());
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreCommentRequest $request) {

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Comment $comment) {

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Comment $comment) {

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request, Comment $comment) {
            $this->commentRepository->destroy($comment);
            return redirect()->route('admin.comment.index')->withFlashSuccess(__('alerts.backend.comments.deleted'));
	}
}
