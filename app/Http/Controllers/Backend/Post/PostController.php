<?php

namespace App\Http\Controllers\Backend\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Post\StorePostRequest;
use App\Models\Auth\User;
use App\Models\Post\Post;
use App\Repositories\Backend\Post\PostRepository;
use Illuminate\Http\Request;

class PostController extends Controller {
	/**
	 * @var PostRepository
	 */
	protected $postRepository;

	/**
	 * PostController constructor.
	 *
	 * @param PostRepository $postRepository
	 */
	public function __construct(PostRepository $postRepository) {
		$this->postRepository = $postRepository;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request) {
		return view('backend.post.index')
			->withPosts($this->postRepository
					->with('user', 'post_images', 'post_comments', 'post_likes')
					->orderBy('updated_at', 'desc')
					->paginate());
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		try {

			return view('backend.post.create')
				->withPost(new Post())
				->withUser(User::where('active', '1')->pluck('first_name', 'id'));
		} catch (\Exception $ex) {

		}

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StorePostRequest $request) {

		$this->postRepository->create($request->only(
			'user',
			'description'
		));

		return redirect()->route('admin.post.index')->withFlashSuccess(__('alerts.backend.posts.created'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show(Post $post) {
		return view('backend.post.show')
			->withPost($post)
			->withUsers(User::where('active', '1')->pluck('first_name', 'id'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Post $post) {
		return view('backend.post.edit')
			->withPost($post)
			->withUser(User::where('active', '1')->pluck('first_name', 'id'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(StorePostRequest $request, Post $post) {
		$this->postRepository->update($post, $request->only(
			'user',
			'description'
		));

		return redirect()->route('admin.post.index')->withFlashSuccess(__('alerts.backend.posts.updated'));

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request, Post $post) {
		$this->postRepository->destroy($post);

		//event(new UserDeleted($user));

		return redirect()->route('admin.post.index')->withFlashSuccess(__('alerts.backend.posts.deleted'));
	}
}
