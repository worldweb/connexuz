<?php

namespace App\Repositories\Backend\Post;

use App\Exceptions\GeneralException;
use App\Models\Comment\CommentLikes;
use App\Models\Post\Post;
use App\Models\Post\PostComment;
use App\Models\Post\PostImages;
use App\Models\Post\PostLikes;
use App\Repositories\BaseRepository;
use File;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Str;
use Mail;

/**
 * Class PostRepository.
 */
class PostRepository extends BaseRepository {
	/**
	 * @return string
	 */
	public function model() {
		return Post::class;
	}

	/**
     * @param int  $status
     * @param bool $trashed
     *
     * @return mixed
     */
    public function getForDataTable($request)
    {
        /**
         * Note: You must return deleted_at or the User getActionButtonsAttribute won't
         * be able to differentiate what buttons to show for each row.
         */
		$dataTableQuery = $this->model->query()
			->leftJoin('users', 'users.id', '=', 'posts.user_id')
            ->select([
                'posts.id',
                'posts.description',
                'posts.status',
                'posts.private_post',
                'posts.created_at',
				'posts.updated_at',
				DB::raw('users.first_name as name'),
            ]);

        if (isset($request['title']) && $request['title'] !== '') {
            $dataTableQuery->where('description', 'like', '%'.$request['title'].'%');
        }

        if (isset($request['status']) && $request['status'] !== '') {
            $dataTableQuery->where('status', '=', $request['status']);
        }

        return $dataTableQuery;
    }


	/**
	 * @param int    $paged
	 * @param string $orderBy
	 * @param string $sort
	 *
	 * @return mixed
	 */
	public function getActivePaginated($paged = '', $orderBy = 'created_at', $sort = 'desc'): LengthAwarePaginator {
		return $this->model
				->with('user')
				->orderBy($orderBy, $sort)
				->paginate();
	
	}

	/**
	 * @param array $data
	 *
	 * @return Post
	 * @throws \Exception
	 * @throws \Throwable
	 */
	public function create(array $data): Post {
		return DB::transaction(function () use ($data) {
			$post = parent::create([
				'description' => $data['description'],
				'user_id' => $data['user'],
			]);

			if ($post) {
				return $post;
			}

			throw new GeneralException(__('exceptions.backend.posts.create_error'));
		});
	}

	/**
	 * @param Post  $post
	 * @param array $data
	 *
	 * @return Post
	 * @throws GeneralException
	 * @throws \Exception
	 * @throws \Throwable
	 */
	public function update(Post $post, array $data): Post {

		return DB::transaction(function () use ($post, $data) {
			if ($post->update([
				'description' => $data['description'],
				'user_id' => $data['user'],
			])) {

				return $post;
			}

			throw new GeneralException(__('exceptions.backend.posts.update_error'));
		});
	}

	/**
	 * @param Post $post
	 *
	 * @return Post
	 * @throws GeneralException
	 * @throws \Exception
	 * @throws \Throwable
	 */
	public function destroy(Post $post): Post {
		return DB::transaction(function () use ($post) {

			// Delete associated comments
			//$post->deletePostComments()->delete();
			$is_deleted = $post->delete();

			if ($is_deleted) {

				//event(new UserPermanentlyDeleted($user));
				return $post;
			}

			throw new GeneralException(__('exceptions.backend.posts.delete_error'));
		});
	}

	public function createComment(array $data): PostComment {
		return DB::transaction(function () use ($data) {
			if($data['replay'] == '1'){
				//dd($data);
				$postComment = PostComment::create([
					'description' => $data['post_comment'],
					'user_id' => $data['user_id'],
					'post_id' => $data['post_id'],
					'reply_user_id' => $data['uid'],
					'parent_id' => $data['comment_id'],
					'created_at' => date('Y-m-d H:i:s'),
				]);
			}else{
				$postComment = PostComment::create([
					'description' => $data['post_comment'],
					'user_id' => $data['uid'],
					'post_id' => $data['post_id'],
					'created_at' => date('Y-m-d H:i:s'),
				]);
			}

			if ($postComment) {
                            
                            // Send email to Friends Start
                                $users_friends_ids = DB::table('user_invites')
                                        ->select('email','users.id','user_invites.user_id','user_invites.invite_user_id')
                                        ->join('users', 'users.id', '=', 'user_invites.user_id')
                                        ->where('user_invites.user_id', $data['uid'])
                                        ->whereNotNull('user_invites.user_id')
                                        ->whereNotNull('user_invites.invite_user_id')
                                        ->orWhere('user_invites.invite_user_id', $data['uid'])
                                        ->get();
                                
                                $users_emails = array();
                                if(!empty($users_friends_ids)){
                                    $userid = '';
                                    $invite_userid = '';
                                    foreach($users_friends_ids as $row){
                                        if($row->user_id != $data['uid']){
                                            $users_emails[$row->user_id] = $row->user_id;
                                        }
                                        if($row->invite_user_id != $data['uid']){
                                            $users_emails[$row->invite_user_id] = $row->invite_user_id;
                                        }
                                    }
                                }
                                if(!empty($users_emails)){
                                    $usersid = array_values($users_emails);
                                    $users_friends_emails = DB::table('users')
                                            ->select(array('email'))
                                            ->whereIn('id', $usersid)
//                                            ->groupBy('id')
                                            ->get();

                                    $users_email_array = array();
                                    if(!empty($users_friends_emails)){
                                        foreach($users_friends_emails as $val){
                                            array_push($users_email_array, $val->email);
                                            array_push($users_email_array,'phpdev6@worldwebtechnology.in');
                                        }
                                    }
                                }
                                
                                if(!empty($users_emails) && !empty($users_email_array)){
                                    $lastname = '';
                                    if($data['userData']['last_name'] != ''){
                                        $lastname = ' '.$data['userData']['last_name'];
                                    }
                                    $data['email_body'] = 'You can see the new comment.';

                                    $email_send_data = array(
                                            'post_data'=> $data,
                                        );
                                    Mail::send('post_email', $email_send_data, function ($m) use($users_email_array,$data) {
                                        $m->from('info@connexuz.com', 'Connexuz');
                                        $m->to($users_email_array)->subject('New comment received from '.$data['userData']['first_name'].' '.$data['userData']['last_name']);
                                    });
                                }
                                // Send email to Friends End
                            
				return $postComment;
			}

			throw new GeneralException(__('exceptions.backend.posts.create_error'));
		});
	}

	public function createPost(array $data): Post {
		return DB::transaction(function () use ($data) {

			if(!isset($data['post_image']) && !isset($data['post_video']) && !$data['post_description']) {
				throw new GeneralException(__('exceptions.backend.posts.create_error'));
			}

			$post = Post::create([
				'description' => ($data['post_description']) ? $data['post_description'] : '',
				'user_id' => $data['uid'],
				'ip_address' => $data['ip_address'],
			]);

			if ($post) {

				if (isset($data['post_image']) && count($data['post_image']) > 0) {
					foreach ($data['post_image'] as $img) {
						
						if(strstr($img->getClientMimeType(), "video/")){

							$path = public_path() . '/video/post/' . $post->id;
							File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
							$filename = time() . '_' . str_replace(' ', '_', $img->getClientOriginalName());
							$img->move($path, $filename);

							$postImageObj = new PostImages();
							$postImageObj->type = 'video';
							$postImageObj->name = $filename;
							$postImageObj->post_id = $post->id;
							$postImageObj->save();
						}else if(strstr($img->getClientMimeType(), "image/")){

							$path = public_path() . '/images/post/' . $post->id;
							File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
							$filename = time() . '_' . str_replace(' ', '_', $img->getClientOriginalName());
							$img->move($path, $filename);

							$postImageObj = new PostImages();
							$postImageObj->type = 'image';
							$postImageObj->name = $filename;
							$postImageObj->post_id = $post->id;
							$postImageObj->save();
						} else {
							$post->delete();
							throw new GeneralException(__('exceptions.backend.posts.create_error'));
						}
					}
				}

				if (isset($data['post_video']) && count($data['post_video']) > 0) {
					foreach ($data['post_video'] as $img) {

						if(strstr($img->getClientMimeType(), "video/")){

							$path = public_path() . '/video/post/' . $post->id;
							File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
							$filename = time() . '_' . str_replace(' ', '_', $img->getClientOriginalName());
							$img->move($path, $filename);

							$postImageObj = new PostImages();
							$postImageObj->type = 'video';
							$postImageObj->name = $filename;
							$postImageObj->post_id = $post->id;
							$postImageObj->save();
						}else if(strstr($img->getClientMimeType(), "image/")){

							$path = public_path() . '/images/post/' . $post->id;
							File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
							$filename = time() . '_' . str_replace(' ', '_', $img->getClientOriginalName());
							$img->move($path, $filename);

							$postImageObj = new PostImages();
							$postImageObj->type = 'image';
							$postImageObj->name = $filename;
							$postImageObj->post_id = $post->id;
							$postImageObj->save();
						} else {
							$post->delete();
							throw new GeneralException(__('exceptions.backend.posts.create_error'));
						}
					}
				}
                                
                                
                                $users_friends_ids = DB::table('user_invites')
                                        ->select('email','users.id','user_invites.user_id','user_invites.invite_user_id')
                                        ->join('users', 'users.id', '=', 'user_invites.user_id')
                                        ->where('user_invites.user_id', $data['uid'])
                                        ->whereNotNull('user_invites.user_id')
                                        ->whereNotNull('user_invites.invite_user_id')
                                        ->orWhere('user_invites.invite_user_id', $data['uid'])
                                        ->get();
                                
                                $users_emails = array();
                                if(!empty($users_friends_ids)){
                                    $userid = '';
                                    $invite_userid = '';
                                    foreach($users_friends_ids as $row){
                                        if($row->user_id != $data['uid']){
                                            $users_emails[$row->user_id] = $row->user_id;
                                        }
                                        if($row->invite_user_id != $data['uid']){
                                            $users_emails[$row->invite_user_id] = $row->invite_user_id;
                                        }
                                    }
                                }
                                if(!empty($users_emails)){
                                    $usersid = array_values($users_emails);
                                    $users_friends_emails = DB::table('users')
                                            ->select(array('email'))
                                            ->whereIn('id', $usersid)
//                                            ->groupBy('id')
                                            ->get();

                                    $users_email_array = array();
                                    if(!empty($users_friends_emails)){
                                        foreach($users_friends_emails as $val){
                                            array_push($users_email_array, $val->email);
                                        }
                                    }
                                }
                                
                                if(!empty($users_emails) && !empty($users_email_array)){
                                    $lastname = '';
                                    if($data['userData']['last_name'] != ''){
                                        $lastname = ' '.$data['userData']['last_name'];
                                    }
                                    $data['email_body'] = 'You can check new post';

                                    $email_send_data = array(
                                            'post_data'=> $data,
                                        );
                                    Mail::send('post_email', $email_send_data, function ($m) use($users_email_array,$data) {
                                        $m->from('info@connexuz.com', 'Connexuz');
                                        $m->to($users_email_array)->subject('New post created from '.$data['userData']['first_name'].' '.$data['userData']['last_name']);
                                    });
                                }

				return $post;
			}
                        
			throw new GeneralException(__('exceptions.backend.posts.create_error'));
		});
	}

	public function addEditPostLikes(array $data) {
		return DB::transaction(function () use ($data) {

			$likes = $this->getPostLike($data['uid'], $data['i_id']);
			if (empty($likes) && $likes == null) {
				$postLikes = PostLikes::create([
					'user_id' => $data['uid'],
					'post_id' => $data['i_id'],
				]);

				return true;
			} else {

				$deleted = $likes->where('id', $likes->id)->delete();
				return false;
			}

			throw new GeneralException(__('exceptions.backend.posts.create_error'));
		});
	}

	public static function getPostLike($uid, $pid) {
		$likes = PostLikes::where('user_id', $uid)->where('post_id', $pid)->first();
		return $likes;
	}

	public function addEditCommentLikes(array $data) {
		return DB::transaction(function () use ($data) {

			$likes = $this->getCommentLike($data['uid'], $data['c_id']);
			if (empty($likes) && $likes == null) {
				$commentLikes = CommentLikes::create([
					'user_id' => $data['uid'],
					'comment_id' => $data['c_id'],
					'post_id' => $data['p_id'],
				]);

				return true;
			} else {

				$deleted = $likes->where('id', $likes->id)->delete();
				return false;
			}

			throw new GeneralException(__('exceptions.backend.posts.create_error'));
		});
	}

	public static function getCommentLike($uid, $cid) {
		$likes = CommentLikes::where('user_id', $uid)->where('comment_id', $cid)->first();
		return $likes;
	}
}
