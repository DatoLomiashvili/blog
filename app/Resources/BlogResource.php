<?php

namespace App\Resources;

use App\Enums\PageTypeEnum;
use App\Models\Comment;
use Domains\Articles\Queries\ArticleQuery;
use Domains\Articles\Resources\V1\ArticlesCollection;
use Exception;
use Illuminate\Http\Resources\Json\JsonResource;
use function Domains\Articles\Resources\V1\getImageObject;

class BlogResource extends JsonResource
{

    /**
     * @param $request
     * @return array
     * @throws Exception
     */
    public function toArray($request): array
    {
        $comment = new Comment();
        $comments = $comment->getCommentsByBlogId($this->id);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'text' => $this->text,
            'author' => $this->user ? $this->user->name : null,
            'comments' => $comments ?: null,
        ];
    }

}
