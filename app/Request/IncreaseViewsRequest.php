<?php

namespace App\Request;

use App\Models\Blog;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class IncreaseViewsRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
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
