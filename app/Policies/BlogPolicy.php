<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class BlogPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return match ($user->role) {
            Role::editor => true,
            default => false,
        };
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Blog $blog): bool
    {
        return match ($user->role) {
            Role::editor => $blog->author->id === $user->id,
            default => false,
        };
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Blog $blog): bool
    {
        return match ($user->role) {
            Role::admin => true,
            Role::editor => $blog->author->id === $user->id,
            default => false,
        };
    }
}
