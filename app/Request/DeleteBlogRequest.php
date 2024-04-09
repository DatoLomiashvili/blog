<?php

namespace App\Request;

use App\Models\Blog;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DeleteBlogRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(Blog $blog): bool
    {
        $blogId = $this->route()->parameter('id');
        $blog = $blog->getBlogById($blogId);
        return Auth::user()->can('delete', $blog);
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
