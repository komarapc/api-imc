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

  public function response401($message = 'Unauthorized', $error = null)
  {
    return response()->json([
      'statusCode' => 401,
      'statusMessage' => 'UNAUTHORIZED',
      'message' => $message,
      'error' => $error,
      'success' => false,
    ], 401);
  }

  public function response403($message = 'Forbidden', $error = null)
  {
    return response()->json([
      'statusCode' => 403,
      'statusMessage' => 'FORBIDDEN',
      'message' => $message,
      'error' => $error,
      'success' => false,
    ], 403);
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
