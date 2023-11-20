<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FasilitasGaleri;
use App\Models\GaleryFile;
use App\Models\User;
use App\Services\GenerateResponse;
use Hidehalo\Nanoid\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GaleryFilesController extends Controller
{
    protected $generateResponse;
    public function __construct(GenerateResponse $generateResponse)
    {
        $this->generateResponse = $generateResponse;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $queryGaleri = request()->query('galeri_id');
            $queryFileName = request()->query('file_name');
            $queryPage = request()->query('page') ? request()->query('page') : 1;
            $queryLimit = request()->query('limit') ? request()->query('limit') : $this->generateResponse->limit;
            $queryResult = GaleryFile::query();
            if ($queryGaleri) {
                $queryResult = $queryResult->where('galeri_id', 'like', '%' . $queryGaleri . '%');
            }
            if ($queryFileName) {
                $queryResult = $queryResult->where('file_name', 'like', '%' . $queryFileName . '%');
            }
            $totalData = $queryResult->count();
            $queryResult = $queryResult->offset(($queryPage - 1) * $queryLimit)->limit($queryLimit);
            $totalPage = ceil($totalData / $queryLimit);
            $current_page = $queryPage ? $queryPage : 1;
            $previouse_page = $current_page - 1 > 0 ? $current_page - 1 : 1;
            $next_page = $current_page + 1 <= $totalPage ? $current_page + 1 : $totalPage;
            $galeriFiles = $queryResult->orderBy('created_at', 'desc')->get();
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
                    'galeries' => $galeriFiles
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
            DB::beginTransaction();
            $rules = [
                'galeri_id' => 'required|string',
                'files' => 'required|array',
                'files.*.file_name' => 'required|string',
                'files.*.base64' => 'required|string',
            ];
            $validator = validator($request->all(), $rules);
            if ($validator->fails()) return response()->json([
                'statusCode' => 400,
                'statusMessage' => "BAD_REQUEST",
                'message' => 'Gagal menambahkan file galeri',
                'error' => env('APP_DEBUG') ? $validator->errors() : null,
                'success' => false,
            ], 400);
            if (!$request->user() || !User::find($request->user()->id))
                return $this->generateResponse->response401();

            $galeryFiles = [];
            foreach ($request['files'] as $file) {
                // check if file is base64
                if (!preg_match('/^data:image\/(\w+);base64,/', $file['base64'])) {
                    return response()->json([
                        'statusCode' => 400,
                        'statusMessage' => "BAD_REQUEST",
                        'message' => 'Gagal menambahkan file galeri',
                        'error' => 'File is not base64',
                        'success' => false,
                    ], 400);
                }
                // check if file is image with type jpg, jpeg, JPG, png, PNG
                if (!preg_match('/^data:image\/(jpg|jpeg|JPG|png|PNG);base64,/', $file['base64'])) {
                    return response()->json([
                        'statusCode' => 400,
                        'statusMessage' => "BAD_REQUEST",
                        'message' => 'Gagal menambahkan file galeri',
                        'error' => 'File is not image',
                        'success' => false,
                    ], 400);
                }
                // convert base64 to image by removing unnecessary string
                $file['base64'] = preg_replace('/^data:image\/\w+;base64,/', '', $file['base64']);
                $file['base64'] = str_replace(' ', '+', $file['base64']);
                $file['file_extension'] = $this->getBase64FileExtension($file['base64']);
                $file['base64'] = base64_decode($file['base64']);

                if ($file['base64'] === false) {
                    return response()->json([
                        'statusCode' => 400,
                        'statusMessage' => "BAD_REQUEST",
                        'message' => 'Failed store fasilitas galeri',
                        'error' => 'Failed to decode base64 data',
                        'success' => false,
                    ], 400);
                }

                // check maximum filesize is 500kb
                if (strlen($file['base64']) > 500000) {
                    return response()->json([
                        'statusCode' => 400,
                        'statusMessage' => "BAD_REQUEST",
                        'message' => 'Failed store fasilitas galeri',
                        'error' => 'File size is too large, maximum file size is 500kb',
                        'success' => false,
                    ], 400);
                }


                // generate file name
                $client = new Client();
                $file['file_name'] = $client->generateId(21) . '-' . time() . '.' . $file['file_extension'];
                // $file['base64'] = base64_decode($file['base64']);
                $path = public_path() . '/images/galeri/' . $file['file_name'];
                // create file url for response
                $file['file_url'] = url('/images/galeri/' . $file['file_name']);
                // save to database
                $fileGalery = new GaleryFile();
                $fileGalery->galeri_id = (string) $request->galeri_id;
                $fileGalery->file_name = $file['file_name'];
                $fileGalery->url = $file['file_url'];
                $fileGalery->save();
                // save image if success save to database
                if ($fileGalery->save()) {
                    file_put_contents($path, $file['base64']);
                }
                array_push($galeryFiles, $fileGalery);
            }
            DB::commit();
            return response()->json([
                'statusCode' => 201,
                'statusMessage' => "CREATED",
                'message' => 'Success store fasilitas galeri',
                'success' => true,
                'data' => [
                    'galeries' => $galeryFiles
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        try {
            $galeryFile = GaleryFile::find($id);
            if (!$galeryFile) return response()->json([
                'statusCode' => 404,
                'statusMessage' => "NOT_FOUND",
                'message' => 'Fasilitas galeri not found',
                'success' => false,
            ], 404);
            if (!$request->user() || !User::find($request->user()->id))
                return $this->generateResponse->response401();
            // delete file
            if (file_exists(public_path() . '/images/galeri/' . $galeryFile->file_name)) {
                unlink(public_path() . '/images/galeri/' . $galeryFile->file_name);
            }
            $galeryFile->delete();
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

    public function countTotalByGaleryId(string $galeri_id)
    {
        try {
            $galeryFiles = GaleryFile::where('galeri_id', $galeri_id)->count();
            return response()->json([
                'statusCode' => 200,
                'statusMessage' => "OK",
                'message' => 'Success get galeri files',
                'success' => true,
                'data' => [
                    'total' => $galeryFiles
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'statusCode' => 500,
                'statusMessage' => "INTERNAL_SERVER_ERROR",
                'message' => 'Failed get galeri files',
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
