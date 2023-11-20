<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Galery;
use App\Models\GenericCode;
use App\Models\User;
use App\Services\GenerateResponse;
use Illuminate\Http\Request;

class GaleryController extends Controller
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
            $queryName = request()->query('name');
            $queryLimit = request()->query('limit') ? request()->query('limit') : $this->generateResponse->limit;
            $queryPage = request()->query('page') ? request()->query('page') : 1;
            $jenjang = request()->query('jenjang');
            $offset = ($queryPage - 1) * $queryLimit;

            $galeries = Galery::query();
            if ($queryName) {
                $galeries->where('name', 'like', '%' . $queryName . '%');
            }
            if ($jenjang) {
                $galeries->whereHas('jenjang', function ($query) use ($jenjang) {
                    $query->where('generic_code_name', 'like', '%' . $jenjang . '%');
                });
            }
            $galeries->with('jenjang');
            $galeries->orderBy('name', 'asc');

            $totalData = $galeries->count();
            $totalPage = ceil($totalData / $queryLimit);
            $data = $galeries->offset($offset)->limit($queryLimit)->get();

            return response()->json([
                'statusCode' => 200,
                'statusMessge' => "OK",
                'message' => "Berhasil mengambil data",
                'data' => [
                    'page' => [
                        'current_page' => $queryPage,
                        'total_page' => $totalPage,
                        'total_data' => $totalData,
                        'limit' => $queryLimit,
                        'next_page' => $queryPage + 1 <= $totalPage ? $queryPage + 1 : null,
                        'previous_page' => $queryPage - 1 >= 1 ? $queryPage - 1 : null,
                    ],
                    'galeries' => $data
                ]
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'statusCode' => 500,
                'statusMessage' => "INTERNAL_SERVER_ERROR",
                'message' => 'Terjadi kesalahan pada server',
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
        try {
            if (!$request->user() || !User::find($request->user()->id))
                return $this->generateResponse->response401();
            $validator = validator($request->all(), [
                'name' => 'required',
                'description' => 'sometimes|nullable',
                'generic_code_id' => 'required|exists:generic_codes,generic_code_id',
            ]);
            if ($validator->fails()) return response()->json([
                'statusCode' => 400,
                'statusMessage' => 'BAD_REQUEST',
                'message' => 'Terjadi kesalahan pada validasi data',
                'error' => $validator->errors(),
                'success' => false,
            ], 400);
            $data = [
                'name' => $request->name,
                'description' => $request->description,
                'generic_code_id' => $request->generic_code_id,
            ];
            $galery = Galery::create($data);
            return response()->json([
                'statusCode' => 201,
                'statusMessage' => "CREATED",
                'message' => "Berhasil menambah data",
                'data' => $galery
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'statusCode' => 500,
                'statusMessage' => "INTERNAL_SERVER_ERROR",
                'message' => 'Terjadi kesalahan pada server',
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
            $galery = Galery::with('jenjang')->find($id);
            if (!$galery) {
                return response()->json([
                    'statusCode' => 404,
                    'statusMessage' => "NOT_FOUND",
                    'message' => 'Data tidak ditemukan',
                    'success' => false,
                ], 404);
            }
            return response()->json([
                'statusCode' => 200,
                'statusMessage' => "OK",
                'message' => "Berhasil mengambil data",
                'data' => $galery
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'statusCode' => 500,
                'statusMessage' => "INTERNAL_SERVER_ERROR",
                'message' => 'Terjadi kesalahan pada server',
                'error' => env('APP_DEBUG') ? $th->getMessage() : null,
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
        try {
            if (!$request->user() || !User::find($request->user()->id))
                return $this->generateResponse->response401();
            $galery = Galery::find($id);
            if (!$galery) {
                return response()->json([
                    'statusCode' => 404,
                    'statusMessage' => "NOT_FOUND",
                    'message' => 'Data tidak ditemukan',
                    'success' => false,
                ], 404);
            }

            $validator = validator($request->all(), [
                'name' => 'required',
                'description' => 'sometimes|nullable',
                'generic_code_id' => 'required|exists:generic_codes,generic_code_id',
            ]);
            if ($validator->fails()) return response()->json([
                'statusCode' => 400,
                'statusMessage' => 'BAD_REQUEST',
                'message' => 'Terjadi kesalahan pada validasi data',
                'error' => $validator->errors(),
                'success' => false,
            ], 400);
            $data = [
                'name' => $request->name,
                'description' => $request->description,
                'generic_code_id' => $request->generic_code_id,
            ];
            $galery->update($data);
            return response()->json([
                'statusCode' => 200,
                'statusMessage' => "OK",
                'message' => "Berhasil mengubah data",
                'data' => $galery
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'statusCode' => 500,
                'statusMessage' => "INTERNAL_SERVER_ERROR",
                'message' => 'Terjadi kesalahan pada server',
                'error' => env('APP_DEBUG') ? $th->getMessage() : null,
                'success' => false,
            ], 500);
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
            $galery = Galery::find($id);
            if (!$galery) {
                return response()->json([
                    'statusCode' => 404,
                    'statusMessage' => "NOT_FOUND",
                    'message' => 'Data tidak ditemukan',
                    'success' => false,
                ], 404);
            }
            $galery->delete();
            return response()->json([
                'statusCode' => 200,
                'statusMessage' => "OK",
                'message' => "Berhasil menghapus data",
                'success' => true,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'statusCode' => 500,
                'statusMessage' => "INTERNAL_SERVER_ERROR",
                'message' => 'Terjadi kesalahan pada server',
                'error' => env('APP_DEBUG') ? $th->getMessage() : null,
                'success' => false,
            ], 500);
        }
    }

    public function statistic()
    {
        try {
            $fasilitas = Galery::all();
            $totalGaleri = $fasilitas->count();
            $totalGaleriPerJenjang = $fasilitas->groupBy('generic_code_id')->map(function ($item) {
                return $item->count();
            });
            $totalGaleriPerJenjang = $totalGaleriPerJenjang->map(function ($item, $key) {
                $jenjang = GenericCode::find($key);
                return [
                    'jenjang' => $jenjang->generic_code_name,
                    'total' => $item
                ];
            });
            return response()->json([
                'statusCode'    => 200,
                'statusMessage' => "OK",
                'message'       => 'Success',
                'data'          => [
                    'total_galeri' => $totalGaleri,
                    'total_galeri_per_jenjang' => $totalGaleriPerJenjang
                ],
                'success'       => true
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'statusCode'    => 500,
                'statusMessage' => "INTERNAL_SERVER_ERROR",
                'message'       => 'Terjadi kesalahan pada server',
                'error'         => env('APP_DEBUG') ? $th->getMessage() : null,
                'success'       => false
            ], 500);
        }
    }
}
