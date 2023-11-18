<?php

namespace App\Services;

class GenerateResponse
{

  /**
   * @param $data
   * @param string $message
   * @return \Illuminate\Http\JsonResponse
   */
  public function response200($data = null, $message = 'OK')
  {
    return response()->json([
      'statusCode' => 200,
      'statusMessage' => 'OK',
      'message' => $message,
      'data' => $data,
      'success' => true,
    ], 200);
  }

  /**
   * @param $data
   * @param string $message
   * @return \Illuminate\Http\JsonResponse
   */
  public function response201($data = null, $message = 'CREATED')
  {
    return response()->json([
      'statusCode' => 201,
      'statusMessage' => 'CREATED',
      'message' => $message,
      'data' => $data,
      'success' => true,
    ], 201);
  }

  public function response500($message = 'Internal Server Error', $error = null)
  {
    return response()->json([
      'statusCode' => 500,
      'statusMessage' => 'INTERNAL_SERVER_ERROR',
      'message' => $message,
      'error' => $error,
      'success' => false,
    ], 500);
  }
}
