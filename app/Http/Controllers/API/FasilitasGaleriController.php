<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FasilitasGaleri;
use App\Models\User;
use App\Services\Base64Services;
use App\Services\GenerateResponse;
use Hidehalo\Nanoid\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FasilitasGaleriController extends Controller
{
    protected $generateResponse;
    protected $base64Service;
    public function __construct(GenerateResponse $generateResponse, Base64Services $base64Service)
    {
        $this->generateResponse = $generateResponse;
        $this->base64Service = $base64Service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $queryFasilitasId = request()->query('fasilitas_id');
            $queryFileName = request()->query('file_name');
            $queryPage = request()->query('page') ? request()->query('page') : 1;
            $queryThumbnail = request()->query('thumbnail');
            $queryJenjang = request()->query('jenjang');
            $queryLimit = request()->query('limit') ? request()->query('limit') : $this->generateResponse->limit;
            $queryResult = FasilitasGaleri::query();
            if ($queryFasilitasId) {
                $queryResult = $queryResult->where('fasilitas_id', 'like', '%' . $queryFasilitasId . '%');
            }
            if ($queryFileName) {
                $queryResult = $queryResult->where('file_name', 'like', '%' . $queryFileName . '%');
            }
            if ($queryThumbnail) {
                $queryResult = $queryResult->where('is_thumbnail', $queryThumbnail);
            }
            if ($queryJenjang) {
                $queryResult = $queryResult->whereHas('fasilitas', function ($q) use ($queryJenjang) {
                    $q->where('generic_code_id', $queryJenjang);
                });
            }
            $totalData = $queryResult->count();
            $queryResult = $queryResult->offset(($queryPage - 1) * $queryLimit)->limit($queryLimit);
            $totalPage = ceil($totalData / $queryLimit);
            $current_page = $queryPage ? $queryPage : 1;
            $previouse_page = $current_page - 1 > 0 ? $current_page - 1 : 1;
            $next_page = $current_page + 1 <= $totalPage ? $current_page + 1 : $totalPage;
            $fasilitasGaleris = $queryResult->orderBy('created_at', 'desc')->get();
            return response()->json([
                'statusCode' => 200,
                'statusMessage' => "OK",
                'message' => 'Success get fasilitas galeri',
                'success' => true,
                'data' => [
                    'page' => [
                        'current_page'   => $current_page,
                        'previouse_page' => $previouse_page,
                        'next_page'      => $next_page,
                        'total_page'     => $totalPage,
                        'total_data'     => $totalData,
                    ],
                    'fasilitas_galeri' => $fasilitasGaleris
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'statusCode' => 500,
                'statusMessage' => "INTERNAL_SERVER_ERROR",
                'message' => 'Failed get fasilitas galeri',
                'error' => env('APP_DEBUG') ? $th->getMessage() : null,
                'success' => false,
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
        /**
         * Request
         * string fasilitas_id
         * Arrau Object {file_name, base64} files
         */
        try {
            if (!$request->user() || !User::find($request->user()->id))
                return $this->generateResponse->response401();
            DB::beginTransaction();
            $rules = [
                'fasilitas_id' => 'required|string',
                'files' => 'required|array',
                'files.*.file_name' => 'required|string',
                'files.*.base64' => 'required|string',
            ];
            $validator = validator($request->all(), $rules);
            if ($validator->fails()) return response()->json([
                'statusCode' => 400,
                'statusMessage' => "BAD_REQUEST",
                'message' => 'Failed store fasilitas galeri',
                'error' => env('APP_DEBUG') ? $validator->errors() : null,
                'success' => false,
            ], 400);

            $fasilitasGaleris = [];
            foreach ($request['files'] as $file) {
                $data = (object) $file;
                $imageBase64 = $data->base64;

                if (!$this->base64Service->validateBase64($imageBase64))
                    return $this->generateResponse->response400('Invalid Input', 'Invalid base64');

                $extension = $this->base64Service->fileExtension($imageBase64);
                if (!in_array($extension, $this->base64Service->allowed_image_extension))
                    return $this->generateResponse->response400('Invalid Input', 'Invalid image extension');

                $base64Size = $this->base64Service->base64Size($imageBase64);
                if ($base64Size > 500)
                    return $this->generateResponse->response400('Invalid Input', 'Image size must be less than 500kB');

                $image = $this->base64Service->uploadImage($this->base64Service->base64StringOnly($imageBase64), '/images/fasilitas-galeri/');

                $fasilitasGaleri = new FasilitasGaleri();
                $fasilitasGaleri->id = (new Client())->generateId(21);
                $fasilitasGaleri->fasilitas_id = $request['fasilitas_id'];
                $fasilitasGaleri->file_name = $image->file_name;
                $fasilitasGaleri->url = $image->file_url;

                $fasilitasGaleri->save();
                array_push($fasilitasGaleris, $fasilitasGaleri);
            }
            DB::commit();
            return response()->json([
                'statusCode' => 201,
                'statusMessage' => "CREATED",
                'message' => 'Success store fasilitas galeri',
                'success' => true,
                'data' => [
                    'fasilitas_galeri' => $fasilitasGaleris
                ]
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            // Delete the uploaded file if it was saved
            if (isset($path) && file_exists($path)) {
                unlink($path);
            }
            return response()->json([
                'statusCode' => 500,
                'statusMessage' => "INTERNAL_SERVER_ERROR",
                'message' => 'Failed store fasilitas galeri',
                'error' => env('APP_DEBUG') ? $th->getMessage() : null,
                'success' => false,
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $fasilitasGaleri = FasilitasGaleri::find($id);
            if (!$fasilitasGaleri) return response()->json([
                'statusCode' => 404,
                'statusMessage' => "NOT_FOUND",
                'message' => 'Fasilitas galeri not found',
                'success' => false,
            ], 404);
            $fasilitasGaleri->file_url = url('/images/fasilitas-galeri/' . $fasilitasGaleri->file_name);
            // check if file exist
            if (!file_exists(public_path() . '/images/fasilitas-galeri/' . $fasilitasGaleri->file_name)) {
                return response()->json([
                    'statusCode' => 404,
                    'statusMessage' => "NOT_FOUND",
                    'message' => 'Fasilitas galeri not found',
                    'success' => false,
                ], 404);
            }
            return response()->json([
                'statusCode' => 200,
                'statusMessage' => "OK",
                'message' => 'Success get fasilitas galeri',
                'success' => true,
                'data' => [
                    'fasilitas_galeri' => $fasilitasGaleri
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'statusCode' => 500,
                'statusMessage' => "INTERNAL_SERVER_ERROR",
                'message' => 'Failed get fasilitas galeri',
                'success' => false,
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
        //
    }

    public function setThumbnail(Request $request, string $id)
    {
        try {
            if (!request()->user() || !User::find(request()->user()->id))
                return $this->generateResponse->response401();
            $fasilitasGaleri = FasilitasGaleri::find($id);
            if (!$fasilitasGaleri) return $this->generateResponse->response404();
            $fasilitasGaleri->is_thumbnail = true;
            $fasilitasGaleri->save();
            return $this->generateResponse->response201($fasilitasGaleri, 'Success set thumbnail');
        } catch (\Throwable $th) {
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        try {
            if (!$request->user() || !User::find($request->user()->id))
                return $this->generateResponse->response401();
            $fasilitasGaleri = FasilitasGaleri::find($id);
            if (!$fasilitasGaleri) return response()->json([
                'statusCode' => 404,
                'statusMessage' => "NOT_FOUND",
                'message' => 'Fasilitas galeri not found',
                'success' => false,
            ], 404);
            // delete file
            if (file_exists(public_path() . '/images/fasilitas-galeri/' . $fasilitasGaleri->file_name)) {
                unlink(public_path() . '/images/fasilitas-galeri/' . $fasilitasGaleri->file_name);
            }
            $fasilitasGaleri->delete();
            return response()->json([
                'statusCode' => 201,
                'statusMessage' => "CREATED",
                'message' => 'Success delete fasilitas galeri',
                'success' => true,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'statusCode' => 500,
                'statusMessage' => "INTERNAL_SERVER_ERROR",
                'message' => 'Failed delete fasilitas galeri',
                'error' => env('APP_DEBUG') ? $th->getMessage() : null,
                'success' => false,
            ], 500);
        }
    }

    public function countTotalByFasilitasId(string $fasilitas_id)
    {
        try {
            $fasilitasGaleri = FasilitasGaleri::where('fasilitas_id', $fasilitas_id)->count();
            return response()->json([
                'statusCode' => 200,
                'statusMessage' => "OK",
                'message' => 'Success get fasilitas galeri',
                'success' => true,
                'data' => [
                    'total' => $fasilitasGaleri
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'statusCode' => 500,
                'statusMessage' => "INTERNAL_SERVER_ERROR",
                'message' => 'Failed get fasilitas galeri',
                'error' => env('APP_DEBUG') ? $th->getMessage() : null,
                'success' => false,
            ], 500);
        }
    }

    private function getBase64FileExtension($base64)
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_buffer($finfo, base64_decode($base64));
        finfo_close($finfo);

        $extension = '';

        switch ($mime) {
            case 'image/jpeg':
                $extension = 'jpg';
                break;
            case 'image/png':
                $extension = 'png';
                break;
                // Add more cases for other MIME types as needed

                // If the MIME type is not recognized, you might want to handle it accordingly
                // or set a default extension.
        }

        return $extension;
    }
}
