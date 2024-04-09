<?php

namespace App\Models;

use App\Enums\OrderDirection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'text',
        'user_id',
        'blog_id',
    ];

    /**
     * @param int $blogId
     * @return mixed
     */
    public function getCommentsByBlogId(int $blogId): mixed
    {
        return $this->where('blog_id', $blogId)
            ->orderBy('created_at', OrderDirection::desc)
            ->get();
    }
}
