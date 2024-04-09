<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\NotFoundException;
use App\Request\LoginRequest;
use App\Resources\LoginResource;
use App\Resources\WhoamiResource;
use App\Services\LoginService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends ApiController
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * @OA\Post(
     *      path="/api/auth/login",
     *      tags={"Authentification"},
     *      summary="Get a JWT access token via given credentials.",
     *      @OA\RequestBody(
     *          description="Login",
     *          required=true,
     *          @OA\JsonContent(
     *		        @OA\Property(property="email", type="string", format="text", example="lomiashvili.dato5@gmail.com"),
     *			    @OA\Property(property="password", type="string", format="text", example="12345678"),
     *            ),
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="success",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response="400",
     *          description="bad request",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response="422",
     *          description="validation",
     *          @OA\JsonContent()
     *      ),
     *  )
     *
     * Get a JWT access token via given credentials.
     *
     * @param LoginRequest $request
     * @param LoginService $loginService
     * @return LoginResource|JsonResponse
     */
    public function login(LoginRequest $request, LoginService $loginService): LoginResource|JsonResponse
    {
        try {
            $token = $loginService->login($request->get('email'), $request->get('password'));
            return new LoginResource($token);
        } catch (NotFoundException $exception) {
            return $this->notFound($exception);
        } catch (Exception $exception) {
            return $this->error($exception);
        }
    }

    /**
     * @OA\Post(
     *  path="/api/auth/refresh_token",
     *  tags={"Authentification"},
     *  summary="Get new JWT access token",
     *  security={{ "apiAuth": {} }},
     *  @OA\Response(
     *      response="200",
     *      description="success",
     *      @OA\JsonContent()
     *  ),
     *  @OA\Response(
     *      response="400",
     *      description="bad request",
     *      @OA\JsonContent()
     *  ),
     *  @OA\Response(
     *      response="422",
     *      description="validation",
     *      @OA\JsonContent()
     *  ),
     * )
     *
     * Get new JWT access token
     *
     * @param LoginService $loginService
     * @return LoginResource|JsonResponse
     */
    public function refreshToken(LoginService $loginService): LoginResource|JsonResponse
    {
        try {
            $token = $loginService->refreshToken();
            return new LoginResource($token);
        } catch (Exception $exception) {
            return $this->error($exception);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/whoami",
     *      tags={"Whoami"},
     *      security={{"apiAuth":{}}},
     *      summary="Get user details",
     *      description="This endpoint allows you to retrieve user details.",
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation Error",
     *          @OA\JsonContent()
     *      ),
     * )
     *
     * Get user details.
     *
     * @return WhoamiResource|JsonResponse
     */
    public function whoami(): WhoamiResource|JsonResponse
    {
        try {
            return new WhoamiResource(Auth::user());
        } catch (Exception $exception) {
            return $this->error($exception);
        }
    }
}
