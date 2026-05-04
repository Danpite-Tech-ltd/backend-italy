<?php

namespace App\Trait;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    public function success($message, $data = [], $status = true, $statusCode = 200): JsonResponse{
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    public function error($message, $status = false, $statusCode = 500){
        return response()->json([
            'status' => $status,
            'message' => $message
        ], $statusCode);
    }
}
