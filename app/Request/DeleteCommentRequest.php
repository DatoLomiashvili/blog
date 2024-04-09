<?php

namespace App\Request;

use App\Models\Blog;
use App\Models\Comment;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DeleteCommentRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(Comment $comment): bool
    {
        $commentId = $this->route()->parameter('id');
        $comment = $comment->getCommentById($commentId);
        return Auth::user()->can('delete', $comment);
    }

    /**
     * @return string[]
     * @throws Exception
     */
    public function rules(): array
    {
        return [];
    }

}
