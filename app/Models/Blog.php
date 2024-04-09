<?php

namespace App\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Blog extends Model
{
    use HasFactory;
    protected int $pagerLimit = 2;

    protected $fillable = [
        'title',
        'text',
        'views',
        'author_id',
        'publish_date',
    ];

    /**
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'blog_id', 'id');
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getBlogById(int $id): mixed
    {

        return $this->with(['comments', 'author'])
            ->where('id', $id)
            ->first();
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getBlogs(): LengthAwarePaginator
    {
        return $this->with('author')
            ->orderBy('publish_date', 'desc')
            ->paginate($this->pagerLimit)
            ->appends(request()->query());
    }
}
