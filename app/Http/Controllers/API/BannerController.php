<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\User;
use App\Services\GenerateResponse;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class BannerController extends Controller
{
    protected $generateResponse;
    public function __construct(GenerateResponse $generateResponse)
    {
        $this->generateResponse = $generateResponse;
    }
    public function index()
    {
        try {
            $banners = Banner::get();
            return response()->json([
                'statusCode' => 200,
                'statusMessage' => "OK",
                'message' => 'Success get banners',
                'success' => true,
                'data' => $banners
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'statusCode' => 500,
                'statusMessage' => "Internal Server Error",
                'message' => 'Failed get banners',
                'success' => false,
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            if (!$request->user() || User::find($request->user()->id))
                return $this->generateResponse->response401('Unauthorized', 'You are unauthorized. Try to login first');
            $validator = validator($request->all(), [
                'title' => 'required',
                'description' => 'required',
                'video_url' => 'required|url'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'statusCode' => 400,
                    'statusMessage' => 'BAD_REQUEST',
                    'message' => $validator->errors(),
                    'success' => false,
                ], 400);
            }
            $banner = Banner::find($id);
            if (!$banner) {
                return response()->json([
                    'statusCode' => 404,
                    'statusMessage' => 'NOT_FOUND',
                    'message' => 'Banner not found',
                    'success' => false,
                ], 404);
            }
            $banner->update($request->all());
            return response()->json([
                'statusCode' => 201,
                'statusMessage' => "CREATED",
                'message' => 'Success update banner',
                'success' => true,
                'data' => $banner
            ], 201);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
