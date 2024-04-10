<?php

namespace Tests\Feature;

use App\Enums\Role;
use App\Models\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    public function test_blog_list_returns_200_status_with_filtered_data_when_unauthenticated(): void
    {
        $author = $this->createUser([], Role::editor);
        $blogList = Blog::factory(2)->setAuthorId($author)->create();
        $orderDirection = 'desc';
        $pagerLimit = 1;
        $blogList = $blogList->sortBy([
            ['publish_date', $orderDirection],
        ])->values();
        $response = $this->PostJson(self::API_URL . 'blogs', [
            'page' => 1,
            'pager_limit' => $pagerLimit,
            'order_direction' => $orderDirection
        ]);
        $json = $this->convertBlogListToJsonData($blogList->take($pagerLimit));
        $json['meta']['total'] = $blogList->count();
        $json['meta']['last_page'] = $blogList->chunk($pagerLimit)->count();
        $response->assertStatus(200);
        $response->assertJson($json);
    }

    public function test_blog_list_returns_200_status_with_filtered_data_when_authenticated(): void
    {
        $author = $this->createUser([],Role::editor);
        $blogList = Blog::factory(2)->setAuthorId($author)->create();
        $orderDirection = 'desc';
        $pagerLimit = 1;
        $blogList = $blogList->sortBy([
            ['publish_date', $orderDirection],
        ])->values();
        $response = $this->actingAs($author)->PostJson(self::API_URL . 'blogs', [
            'page' => 1,
            'pager_limit' => $pagerLimit,
            'order_direction' => $orderDirection
        ]);
        $json = $this->convertBlogListToJsonData($blogList->take($pagerLimit));
        $json['meta']['total'] = $blogList->count();
        $json['meta']['last_page'] = $blogList->chunk($pagerLimit)->count();
        $response->assertStatus(200);
        $response->assertJson($json);
    }

    public function test_get_blog_returns_200_status_with_data_when_authenticated(): void
    {
        $this->loginGetAccessToken();
        $author = $this->createUser([], Role::editor);
        $blog = Blog::factory()->setAuthorId($author)->create();
        $response = $this->actingAs($author)->getJson(self::API_URL . 'blogs/' . $blog->id);
        $json = $this->convertGetBlogResourceToJsonData($blog);
        $response->assertStatus(200);
        $response->assertJson($json);
    }


    public function convertBlogListToJsonData($blogList): array
    {
        $data = [];
        foreach ($blogList as $blog) {
            $data['data'][] = [
                'id' => $blog->id,
                'title' => $blog->title,
                'text' => $blog->text,
                'views' => $blog->views,
                'author' => [
                    'id' => $blog->author->id,
                    'name' => $blog->author->name
                ]
            ];
        }
        return $data;
    }

    public function convertGetBlogResourceToJsonData($blog): array
    {
        $data['data'] = [
            'id' => $blog->id,
            'title' => $blog->title,
            'text' => $blog->text,
            'author' => $blog->author->name,
            'comments' => $this->convertCommentsListToJsonData($blog->comments)
        ];
        return $data;
    }

    public function convertCommentsListToJsonData($comments): array
    {
        $data = [];
        foreach ($comments as $comment) {
            $data[] = [
                'id' => $comment->id,
                'text' => $comment->text,
                'user_id' => $comment->user->id,
                'blog_id' => $comment->blog->id,
            ];
        }

        return $data;
    }
}
