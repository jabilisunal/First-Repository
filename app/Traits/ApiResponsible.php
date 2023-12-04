<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponsible
{
    /**
     * @param int $code
     * @param array|null $data
     * @param string|null $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse(int $code = 200, $data = [], ?string $message = null): JsonResponse
    {
        $response = [
            'status' => true,
            'data' => $data,
        ];

        if ($code) {
            $response['code'] = $code;
        }

        if ($message) {
            $response['message'] = $message;
        }

        return response()->json(
            $response,
            $code
        );
    }

    /**
     * @param $code
     * @param string|null $message
     * @param array|null $errors
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse($code, ?string $message = null, ?array $errors = []): JsonResponse
    {
        if (strlen($code) === 1) {
            $code = 500;
        }

        $response = [
            'status' => false
        ];

        if ($code) {
            $response['code'] = $code;
        }

        if ($message) {
            $response['message'] = $message;
        }

        if ($errors) {
            $response['errors'] = $errors;
        }

        return response()->json(
            $response,
            $code
        );
    }

    /**
     * @param string|null $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function forbiddenResponse(?string $message = 'Əməliyyata icazə yoxdur'): JsonResponse
    {
        $response = [
            'status' => false,
            'code' => Response::HTTP_FORBIDDEN
        ];

        if ($message) {
            $response['message'] = $message;
        }

        return response()->json(
            $response,
            Response::HTTP_FORBIDDEN
        );
    }
}
