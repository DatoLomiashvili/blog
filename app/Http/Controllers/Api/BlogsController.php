<?php

namespace App\Http\Controllers\Api;

use App\Models\Blog;
use App\Request\BlogListRequest;
use App\Request\CreateBlogRequest;
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

class BlogsController extends ApiController
{
    use ResponseSupport;
    use ValidatesRequests;
    use AuthorizesRequests;

    /**
     * @OA\Post(
     *     path="/api/blogs",
     *     tags={"Blogs"},
     *     summary="view blogs",
     *     security={{"apiAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="<b>Sort Directions</b>: asc, desc",
     *         @OA\JsonContent(
     *             @OA\Property(property="page", type="int", format="text", example="1"),
     *             @OA\Property(property="pager_limit", type="int", format="text", example="12"),
     *             @OA\Property(property="order_direction", type="string", format="text", example="desc"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="created",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="bad request",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="validation",
     *         @OA\JsonContent()
     *     ),
     * )
     * @param BlogListRequest $request
     * @param Blog $blog
     * @return AnonymousResourceCollection|JsonResponse
     */
    public function getList(
        BlogListRequest $request,
        Blog $blog
    ): AnonymousResourceCollection|JsonResponse
    {
        try {
            $list = $blog->getList(
                orderDirection: $request->validated('order_direction'),
                pagerLimit: $request->validated('pager_limit')
            );
            return (BlogCollection::collection($list));
        } catch (Exception $exception) {
            return $this->notFound($exception);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/blogs/{id}",
     *      tags={"Blogs"},
     *      summary="get blog",
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
     * @param GetBlogRequest $request
     * @param Blog $blog
     * @return BlogResource|JsonResponse
     */
    public function getBlog(int $id, GetBlogRequest $request, Blog $blog): BlogResource|JsonResponse
    {
        try {
            $blog = $blog->getBlogById(id: $id);
            return (new BlogResource($blog));
        } catch (Exception $exception) {
            return $this->error($exception);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/blogs/update/{id}",
     *      tags={"Blogs"},
     *      summary="update blog",
     *      security={{"apiAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="id",
     *          example="",
     *          required=true,
     *      ),
     *     @OA\RequestBody(
     *          required=true,
     *          description="<b>Sort Directions</b>: asc, desc",
     *          @OA\JsonContent(
     *              @OA\Property(property="title", type="string", format="text", example="New Title"),
     *              @OA\Property(property="text", type="int", format="text", example=""),
     *              @OA\Property(property="publish_date", type="string", format="text", example="2024-07-20 18:00:00"),
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
     * @param int $id
     * @param UpdateBlogRequest $request
     * @param Blog $blog
     * @return BlogResource|JsonResponse
     */
    public function updateBlog(int $id, UpdateBlogRequest $request, Blog $blog): BlogResource|JsonResponse
    {
        try {
            $blog = $blog->getBlogById(id: $id);
            $blog->update([
               'title' => $request->validated('title'),
               'text' => $request->validated('text'),
               'publish_date' => $request->validated('publish_date') ?: Date::now(),
            ]);
            return $this->success('Blog Updated');
        } catch (Exception $exception) {
            return $this->error($exception);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/blogs/create",
     *      tags={"Blogs"},
     *      summary="update blog",
     *      security={{"apiAuth":{}}},
     *     @OA\RequestBody(
     *          required=true,
     *          description="<b>Order Directions</b>: asc, desc",
     *          @OA\JsonContent(
     *              @OA\Property(property="title", type="string", format="text", example="New Title"),
     *              @OA\Property(property="text", type="int", format="text", example=""),
     *              @OA\Property(property="publish_date", type="string", format="text", example="2024-07-20 18:00:00"),
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
     * @param CreateBlogRequest $request
     * @param Blog $blog
     * @return BlogResource|JsonResponse
     */
    public function createBlog(CreateBlogRequest $request, Blog $blog): BlogResource|JsonResponse
    {
        try {
            $blog->create([
                'title' => $request->validated('title'),
                'text' => $request->validated('text'),
                'publish_date' => $request->validated('publish_date') ?: Date::now(),
                'author_id' => Auth::user()['id'],
            ]);
            return $this->success('Blog created');
        } catch (Exception $exception) {
            return $this->error($exception);
        }
    }
}
