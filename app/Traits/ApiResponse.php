<?php

namespace App\Traits;

trait ApiResponse
{
    public function success($data, $statusCode = 200)
    {
        return response()->json($data, $statusCode);
    }

    public function successMessage($message, $data = [], $statusCode = 200)
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    public function error($message, $statusCode = '404', $errors = [])
    {
        $response = [
            'success' => false,
            'message' => $message,
            'status' => $statusCode,
        ];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }
        return response()->json($response, $statusCode);
    }
}
