<?php

namespace App\Traits;

trait ApiResponseTrait
{
    public function successResponse($data = null, $message = null, $code = 200)
    {
        return response()->json([
          'status' => true,
          'data' => $data,
          'message' => $message,
        ], $code);
    }

    public function errorResponse($data = null, $message = null, $code = 404)
    {
        return response()->json([
          'status' => false,
          'data' => $data,
          'message' => $message,
        ], $code);
    }
}