<?php

namespace App\Models;

use App\Enums\OrderDirection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Blog extends Model
{
    use HasFactory;

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
        return $this->hasMany(Comment::class, 'blog_id', 'id')
            ->orderBy('created_at', OrderDirection::desc);
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
     * @param string $orderDirection
     * @param int|null $pagerLimit
     * @return LengthAwarePaginator
     */
    public function getList(
        string $orderDirection = OrderDirection::desc,
        ?int $pagerLimit = 2,
    ): LengthAwarePaginator
    {
        return $this->with('author')
            ->orderBy('publish_date', $orderDirection)
            ->paginate($pagerLimit)
            ->appends(request()->query());
    }
}
