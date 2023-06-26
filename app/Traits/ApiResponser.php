<?php

namespace App\Traits;

trait ApiResponser
{
  public function successResponse($data, $code = 200)
  {
    return response()->json([
      'message' => 'success',
      'data' => $data
    ], $code);
  }

  public function errorResponse($message, $code = 422, $errors = [])
  {
    return response()->json([
      'message' => $message,
      'errors' => $errors
    ], $code);
  }
}
