<?php

namespace App\Request;

use App\Models\Blog;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateBlogRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->can('create', Blog::class);
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
            'publish_date' => 'nullable|date_format:Y-m-d H:i:s',
        ];
    }

}
