<?php

namespace App\Traits;

trait ResponseAPI
{
    public function success($message, $data = null, $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public function error($message, $code = 404)
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ], $code);
    }
}
