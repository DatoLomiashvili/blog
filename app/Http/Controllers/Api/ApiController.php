<?php

namespace App\Http\Controllers\Api;

use App\Supports\ResponseSupport;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


/**
 * @OA\Info(
 *    title="Swagger with Laravel",
 *    version="1.0.0",
 * )
 * @OA\SecurityScheme(
 *     type="http",
 *     securityScheme="bearerAuth",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
class ApiController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    use ResponseSupport;

    public function __construct()
    {
        auth()->setDefaultDriver('api');
    }
}
