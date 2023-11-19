<?php

namespace App\Services;

class GenerateResponse
{
  public $limit = 12;
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

  public function response400($message = 'Bad Request', $error = null)
  {
    return response()->json([
      'statusCode' => 400,
      'statusMessage' => 'BAD_REQUEST',
      'message' => $message,
      'error' => $error,
      'success' => false,
    ], 400);
  }

  public function response404($message = 'Not Found', $error = null)
  {
    return response()->json([
      'statusCode' => 404,
      'statusMessage' => 'NOT_FOUND',
      'message' => $message,
      'error' => $error,
      'success' => false,
    ], 404);
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
