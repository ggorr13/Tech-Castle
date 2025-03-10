<?php

namespace App\Adapters;

use Illuminate\Http\JsonResponse;

class ResponseAdapter
{
    public static function success($data = null, string $message = '', int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $status);
    }

    public static function error(string $message, int $status = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'error' => $message
        ], $status);
    }
}
