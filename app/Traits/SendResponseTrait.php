<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use function PHPUnit\Framework\isNull;

trait SendResponseTrait
{
    public function success($message, $data = null, $status = 200): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => !is_null($data) ? $data : [],
        ], $status);
    }

    public function error($message = 'something went wrong, try again later', $error = null, $status = 400): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'error' => !is_null($error) ? $error : []
        ], $status);
    }
}
