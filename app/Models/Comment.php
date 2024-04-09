<?php

namespace App\Models;

use App\Enums\OrderDirection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function blog(): BelongsTo
    {
        return $this->belongsTo(User::class, 'blog_id', 'id');
    }

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

    /**
     * @param int $id
     * @return mixed
     */
    public function getCommentById(int $id): mixed
    {
        return $this->where('id', $id)
            ->first();
    }
}
