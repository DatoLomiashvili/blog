<?php

namespace App\Supports;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ResponseSupport
{
    /**
     * @param Exception $e
     * @param $code
     * @return JsonResponse
     */
    protected function unauthorized(Exception $e, $code = null): JsonResponse
    {
        return response()->json(['message' => $e->getMessage()], $code ?? Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @param Exception $e
     * @param $code
     * @return JsonResponse
     */
    protected function forbidden(Exception $e, $code = null): JsonResponse
    {
        return response()->json(['message' => $e->getMessage()], $code ?? Response::HTTP_FORBIDDEN);
    }

    /**
     * @param Exception $e
     * @param $code
     * @return JsonResponse
     */
    protected function error(Exception $e, $code = null): JsonResponse
    {
        return response()->json(['message' => $e->getMessage()], $code ?? Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param Exception $e
     * @param $code
     * @return JsonResponse
     */
    protected function notFound(Exception $e, $code = null): JsonResponse
    {
        $message = !empty($e->getMessage()) ? $e->getMessage() : 'not found';
        return response()->json(['message' => $message], $code ?? Response::HTTP_NOT_FOUND);
    }

    /**
     * @param Exception $e
     * @param $code
     * @return JsonResponse
     */
    protected function validation(Exception $e, $code = null): JsonResponse
    {
        return response()->json(['message' => $e->getMessage()], $code ?? Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @param string $message
     * @return JsonResponse
     */
    protected function success(string $message = 'success'): JsonResponse
    {
        return response()->json(['message' => $message], Response::HTTP_OK);
    }

    /**
     * @param array $data
     * @return JsonResponse
     */
    protected function created(array $data): JsonResponse
    {
        return response()->json($data, Response::HTTP_CREATED);
    }
}
