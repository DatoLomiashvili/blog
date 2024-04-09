<?php

namespace App\Request;

use App\Models\Blog;
use App\Models\Comment;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateCommentRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->can('create', Comment::class);
    }

    /**
     * @return string[]
     * @throws Exception
     */
    public function rules(): array
    {
        return [
            'text' => 'required|string',
            'blog_id' => 'required|exists:blogs,id'
        ];
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'blog_id.exists' => 'The selected blog does not exist.',
        ];
    }
}
