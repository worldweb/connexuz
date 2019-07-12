<?php

namespace App\Repositories\Backend\Comment;

use App\Exceptions\GeneralException;
use App\Models\Comment\Comment;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

/**
 * Class CommentRepository.
 */
class CommentRepository extends BaseRepository {

    /**
     * @return string
     */
    public function model() {
        return Comment::class;
    }

    public function getForDataTable() {
        /**
         * Note: You must return deleted_at or the User getActionButtonsAttribute won't
         * be able to differentiate what buttons to show for each row.
         */
        $dataTableQuery = $this->model->query()
                ->leftJoin('users', 'users.id', '=', 'post_comments.user_id')
                ->leftJoin('posts', 'posts.id', '=', 'post_comments.post_id')
                ->select([
            'posts.description',
            'post_comments.description',
            'post_comments.updated_at',
            DB::raw('users.first_name as name'),
        ]);

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
                        ->orderBy($orderBy, $sort)
                        ->paginate($paged);
    }

    /**
     * @param array $data
     *
     * @return Comment
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data): Comment {
        
    }

    /**
     * @param Comment  $comment
     * @param array $data
     *
     * @return Comment
     * @throws GeneralException
     * @throws \Exception
     * @throws \Throwable
     */
    public function update(Comment $comment, array $data): Comment {
        
    }

    /**
     * @param Comment $comment
     *
     * @return Comment
     * @throws GeneralException
     * @throws \Exception
     * @throws \Throwable
     */
    public function destroy(Comment $comment): Comment {
        return DB::transaction(function () use ($comment) {

                    // Delete associated comments
                    //$comment->deletecommentComments()->delete();
                    $is_deleted = $comment->delete();

                    if ($is_deleted) {

                        //event(new UserPermanentlyDeleted($user));
                        return $comment;
                    }

                    throw new GeneralException(__('exceptions.backend.comments.delete_error'));
                });
    }

}
