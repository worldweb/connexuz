<?php

namespace app\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;

use App\Models\Settings\Settings;

use Illuminate\Http\Request;

class SettingsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request) {
            
		$setting = Settings::all();
		// dd($setting);
		return view('backend.settings.settings')->with('settings',$setting)->with('request',$request);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$data = $request->all();
		
		foreach ($data as $key => $value) {
			
			Settings::where('setting_key', '=', $key)->update([ 'setting_value' => $value, 'updated_at' => date('Y-m-d H:i:s') ]);
		}
		
		return redirect()->route('admin.setting.index')->withFlashSuccess(__('alerts.backend.settings.updated'));
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
