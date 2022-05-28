<?php
namespace App\Http\Traits;
trait RespondsWithHttpStatus
{
    protected function success($message, $data = [], $status = 200)
    {
        return response()->json([
            'status' => true,
            'data' => $data,
            'message' => $message,
        ], $status);
    }

    protected function created($message, $data = [], $status = 201)
    {
        return response()->json([
            'status' => true,
            'data' => $data,
            'message' => $message,
        ], $status);
    }

    protected function failure($message, $status = 422)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
        ], $status);
    }
}
