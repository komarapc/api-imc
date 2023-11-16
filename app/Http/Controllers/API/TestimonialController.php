<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Services\Base64Services;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    protected $base64Services;
    public function __construct(Base64Services $base64Services)
    {
        $this->base64Services = $base64Services;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $queryName = request()->query('name');
            $queryEmail = request()->query('email');
            $queryPhoneNumber = request()->query('phone_number');
            $queryPage = request()->query('page') ? request()->query('page') : 1;
            $queryLimit = request()->query('limit') ? request()->query('limit') : 10;

            $queryResult = Testimonial::query();
            if ($queryName) {
                $queryResult->where('full_name', 'like', '%' . $queryName . '%');
            }
            if ($queryEmail) {
                $queryResult->where('email', 'like', '%' . $queryEmail . '%');
            }
            if ($queryPhoneNumber) {
                $queryResult->where('phone_number', 'like', '%' . $queryPhoneNumber . '%');
            }
            $queryResult->orderBy('created_at', 'desc');

            $totalData = $queryResult->count();
            $queryResult->limit($queryLimit)->offset(($queryPage - 1) * $queryLimit);
            $totalPage = ceil($totalData / $queryLimit);
            $current_page = $queryPage;
            $previos_page = $queryPage > 1 ? $queryPage - 1 : null;
            $next_page = $queryPage < $totalPage ? $queryPage + 1 : null;
            $testimonials = $queryResult->get();

            return response()->json([
                'statusCode' => 200,
                'statusMessage' => 'OK',
                'message' => 'Berhasil memuat data testimoni.',
                'data' => [
                    'page' => [
                        'current_page' => $current_page,
                        'previos_page' => $previos_page,
                        'next_page' => $next_page,
                        'total_page' => $totalPage,
                        'total_data' => $totalData,
                        'limit' => $queryLimit,
                    ],
                    'testimonials' => $testimonials
                ],
                'success' => true
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'statusCode' => 500,
                'statusMessage' => 'INTERNAL_SERVER_ERROR',
                'message' => 'Terjadi kesalahan pada server.',
                'error' => env('APP_DEBUG') ? $th->getMessage() : null,
                'success' => false
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validateRequest = $this->validateRequest($request);
            if ($validateRequest) return $validateRequest;



            if ($request->image) {
                // check if image is base64
                $validateImage = $this->validateImage($request->image);
                if ($validateImage) return $validateImage;

                $imageBase64 = preg_replace('/^data:image\/(\w+);base64,/', '', $request->image);
                $imageBase64 = str_replace(' ', '+', $imageBase64);
                $uploadPath = '/images/testimoni/';
                $image = $this->base64Services->uploadImage($imageBase64, $uploadPath);
            }
            $testimonials = new Testimonial();
            $testimonials->full_name = $request->full_name;
            $testimonials->content = $request->content;
            $testimonials->email = $request->email;
            $testimonials->phone_number = $request->phone_number;
            $testimonials->image = $image->file_name ?? null;
            $testimonials->image_url = $image->file_url ?? null;
            $testimonials->save();

            // return response 201
            return response()->json([
                'statusCode' => 201,
                'statusMessage' => 'CREATED',
                'message' => 'Berhasil menambahkan testimoni.',
                'data' => [
                    'testimoni' => $testimonials
                ],
                'success' => true
            ], 201);
        } catch (\Throwable $th) {
            // unlink upload image
            if (isset($image)) unlink($image->file_path);
            return response()->json([
                'statusCode' => 500,
                'statusMessage' => 'INTERNAL_SERVER_ERROR',
                'message' => 'Terjadi kesalahan pada server.',
                'error' => env('APP_DEBUG') ? $th->getMessage() : null,
                'success' => false
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $testimonials = Testimonial::find($id);
            if (!$testimonials) return response()->json([
                'statusCode' => 404,
                'statusMessage' => 'NOT_FOUND',
                'message' => 'Testimoni tidak ditemukan.',
                'error' => null,
                'success' => false
            ], 404);

            return response()->json([
                'statusCode' => 200,
                'statusMessage' => 'OK',
                'message' => 'Berhasil memuat data testimoni.',
                'data' => [
                    'testimoni' => $testimonials
                ],
                'success' => true
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'statusCode' => 500,
                'statusMessage' => 'INTERNAL_SERVER_ERROR',
                'message' => 'Terjadi kesalahan pada server.',
                'error' => env('APP_DEBUG') ? $th->getMessage() : null,
                'success' => false
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $testimonials = Testimonial::find($id);
            if (!$testimonials) return response()->json([
                'statusCode' => 404,
                'statusMessage' => 'NOT_FOUND',
                'message' => 'Testimoni tidak ditemukan.',
                'error' => null,
                'success' => false
            ], 404);

            $previoesTestimonials = clone $testimonials;

            $validateRequest = $this->validateRequest($request);
            if ($validateRequest) return $validateRequest;

            // check if image is base64
            if ($request->image) {
                $validateImage = $this->validateImage($request->image);
                if ($validateImage) return $validateImage;
            }

            if ($request->image) {
                $imageBase64 = preg_replace('/^data:image\/(\w+);base64,/', '', $request->image);
                $imageBase64 = str_replace(' ', '+', $imageBase64);
                $uploadPath = '/images/testimoni/';
                $image = $this->base64Services->uploadImage($imageBase64, $uploadPath);
                $testimonials->image = $image->file_name;
                $testimonials->image_url = $image->file_url;
            }
            $testimonials->full_name = $request->full_name;
            $testimonials->content = $request->content;
            $testimonials->email = $request->email;
            $testimonials->phone_number = $request->phone_number;
            $testimonials->save();

            if ($testimonials->save()) {
                // unlink previous image
                if ($request->image) {
                    $this->base64Services->deleteFileContent($previoesTestimonials->file_path);
                }
            }

            // return response 200
            return response()->json([
                'statusCode' => 200,
                'statusMessage' => 'OK',
                'message' => 'Berhasil mengubah testimoni.',
                'data' => [
                    'testimoni' => $testimonials
                ],
                'success' => true
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'statusCode' => 500,
                'statusMessage' => 'INTERNAL_SERVER_ERROR',
                'message' => 'Terjadi kesalahan pada server.',
                'error' => env('APP_DEBUG') ? $th->getMessage() : null,
                'success' => false
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $testimonials = Testimonial::find($id);
            if (!$testimonials) return response()->json([
                'statusCode' => 404,
                'statusMessage' => 'NOT_FOUND',
                'message' => 'Testimoni tidak ditemukan.',
                'error' => null,
                'success' => false
            ], 404);

            $testimonials->delete();

            // return response 200
            return response()->json([
                'statusCode' => 200,
                'statusMessage' => 'OK',
                'message' => 'Berhasil menghapus testimoni.',
                'success' => true
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'statusCode' => 500,
                'statusMessage' => 'INTERNAL_SERVER_ERROR',
                'message' => 'Terjadi kesalahan pada server.',
                'error' => env('APP_DEBUG') ? $th->getMessage() : null,
                'success' => false
            ], 500);
        }
    }

    public function deleteImageTestimonial(string $id)
    {
        try {
            $testimonials = Testimonial::find($id);

            if (!$testimonials) return response()->json([
                'statusCode' => 404,
                'statusMessage' => 'NOT_FOUND',
                'message' => 'Testimoni tidak ditemukan.',
                'error' => null,
                'success' => false
            ], 404);

            $file_name = $testimonials->image;
            $testimonials->image = null;
            $testimonials->image_url = null;
            $testimonials->save();

            if ($testimonials->save() && $file_name) {
                // unlink previous image
                $file_path = public_path('images/testimoni/' . $file_name);
                $this->base64Services->deleteFileContent($file_path);
            }

            // return response 200
            return response()->json([
                'statusCode' => 200,
                'statusMessage' => 'OK',
                'message' => 'Berhasil menghapus gambar testimoni.',
                'success' => true
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'statusCode' => 500,
                'statusMessage' => 'INTERNAL_SERVER_ERROR',
                'message' => 'Terjadi kesalahan pada server.',
                'error' => env('APP_DEBUG') ? $th->getMessage() : null,
                'success' => false
            ], 500);
        }
    }

    public function statistic()
    {
    }

    private function validateRequest(Request $request)
    {
        $rules = [
            'full_name' => 'required|string',
            'content' => 'required|string',
            'email' => 'nullable|email',
            'phone_number' => 'nullable|string',
            'image' => 'nullable|string', // base64
        ];
        $validator = validator($request->all(), $rules);
        if ($validator->fails()) return response()->json([
            'statusCode' => 400,
            'statusMessage' => 'BAD_REQUEST',
            'message' => 'Terjadi kesalahan pada validasi data.',
            'error' => $validator->errors(),
            'success' => false
        ], 400);
    }

    private function validateImage($image)
    {
        if (!preg_match('/^data:image\/(\w+);base64,/', $image)) return response()->json([
            'statusCode' => 400,
            'statusMessage' => 'BAD_REQUEST',
            'message' => 'Terjadi kesalahan pada validasi data.',
            'error' => [
                'image' => 'Image harus berupa base64.'
            ],
            'success' => false
        ], 400);
        // check if file is image with type jpg, jpeg, JPG, png, PNG
        if (!preg_match('/^data:image\/(jpg|jpeg|JPG|png|PNG);base64,/', $image))
            return response()->json([
                'statusCode' => 400,
                'statusMessage' => 'BAD_REQUEST',
                'message' => 'Terjadi kesalahan pada validasi data.',
                'error' => [
                    'image' => 'Image harus berupa file dengan tipe jpg, jpeg, JPG, png, PNG.'
                ],
                'success' => false
            ], 400);
        // check if file is image with max size 500kb
        if (strlen($image) > 512000) return response()->json([
            'statusCode' => 400,
            'statusMessage' => 'BAD_REQUEST',
            'message' => 'Terjadi kesalahan pada validasi data.',
            'error' => [
                'image' => 'Image harus berukuran maksimal 500kb.'
            ],
            'success' => false
        ], 400);
    }
}
