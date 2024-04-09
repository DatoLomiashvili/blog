<?php

namespace App\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Blog;
use Exception;
use Illuminate\Foundation\Http\FormRequest;

class BlogListRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->can('view', Blog::class);
    }

    /**
     * @return string[]
     * @throws Exception
     */
    public function rules(): array
    {
        return [
            'page' => 'nullable|integer',
            'pager_limit' => 'required|integer',
            'order_direction' => 'in:asc,desc'
        ];
    }

}
