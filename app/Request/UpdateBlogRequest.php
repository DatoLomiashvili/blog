<?php

namespace App\Request;

use App\Models\Blog;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateBlogRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(Blog $blog): bool
    {
        $blogId = $this->route()->parameter('id');
        $blog = $blog->getBlogById($blogId);
        return Auth::user()->can('update', $blog);
    }

    /**
     * @return string[]
     * @throws Exception
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'text' => 'required|string',
            'publish_date' => 'required|date_format:Y-m-d H:i:s',
        ];
    }

}
