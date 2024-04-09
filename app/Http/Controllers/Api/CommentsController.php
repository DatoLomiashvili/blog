<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\NotFoundException;
use App\Models\Blog;
use App\Models\Comment;
use App\Request\BlogListRequest;
use App\Request\CreateBlogRequest;
use App\Request\CreateCommentRequest;
use App\Request\DeleteBlogRequest;
use App\Request\DeleteCommentRequest;
use App\Request\GetBlogRequest;
use App\Request\UpdateBlogRequest;
use App\Resources\BlogCollection;
use App\Resources\BlogResource;
use App\Supports\ResponseSupport;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class CommentsController extends ApiController
{
    use ResponseSupport;
    use ValidatesRequests;
    use AuthorizesRequests;


    /**
     * @OA\Post(
     *      path="/api/comments/create",
     *      tags={"Comments"},
     *      summary="update blog",
     *      security={{"apiAuth":{}}},
     *     @OA\RequestBody(
     *          required=true,
     *          description="",
     *          @OA\JsonContent(
     *              @OA\Property(property="blog_id", type="int", format="text", example="1"),
     *              @OA\Property(property="text", type="int", format="text", example="comment text"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response="201",
     *          description="created",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response="400",
     *          description="bad request",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response="422",
     *          description="validation",
     *          @OA\JsonContent()
     *      ),
     *  )
     * @param CreateCommentRequest $request
     * @return JsonResponse
     */
    public function createComment(CreateCommentRequest $request): JsonResponse
    {
        try {
            Comment::create([
                'text' => $request->validated('text'),
                'user_id' => Auth::user()['id'],
                'blog_id' => $request->validated('blog_id'),
            ]);
            return $this->success('Comment created');
        } catch (Exception $exception) {
            return $this->error($exception);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/comments/delete/{id}",
     *      tags={"Comments"},
     *      summary="delete comment",
     *      security={{"apiAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="id",
     *          example="",
     *          required=true,
     *      ),
     *      @OA\Response(
     *          response="201",
     *          description="created",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response="400",
     *          description="bad request",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response="422",
     *          description="validation",
     *          @OA\JsonContent()
     *      ),
     *  )
     * @param int $id
     * @param DeleteCommentRequest $request
     * @param Comment $comment
     * @return BlogResource|JsonResponse
     */
    public function deleteComment(int $id, DeleteCommentRequest $request, Comment $comment): BlogResource|JsonResponse
    {
        try {
            $comment = $comment->getCommentById(id: $id);
            $comment->delete();
            return $this->success('Comment deleted');
        } catch (Exception $exception) {
            return $this->error($exception);
        }
    }
}
