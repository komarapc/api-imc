<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use App\Models\GenericCode;
use App\Models\User;
use App\Services\GenerateResponse;
use Illuminate\Http\Request;

class FasilitasController extends Controller
{
    protected $generateResponse;
    public function __construct(GenerateResponse $generateResponse)
    {
        $this->generateResponse = $generateResponse;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $queryJenjang = $request->query('jenjang');
            $queryFasilitas = $request->query('fasilitas');
            $limit = $request->query('limit') ? $request->query('limit') : $this->generateResponse->limit;
            $page = $request->query('page') ? $request->query('page') : 1;
            $offset = ($page - 1) * $limit;

            $fasilitas = Fasilitas::query();
            if ($queryJenjang) {
                $fasilitas->whereHas('jenjang', function ($jenjang) use ($queryJenjang) {
                    $jenjang->where('generic_code_name', 'like', "%{$queryJenjang}%");
                });
            }
            if ($queryFasilitas) {
                $fasilitas->where('name', 'like', "%{$queryFasilitas}%");
            }
            $fasilitas->with('jenjang');
            $fasilitas->orderBy('name', 'asc');

            // total data should be all data query without limit
            $totalData = $fasilitas->count();
            $totalPage = ceil($totalData / $limit);

            $fasilitas->limit($limit);
            $fasilitas->offset($offset);

            $fasilitas = $fasilitas->get();



            $current_page = $page ? $page : 1;
            $previouse_page = $current_page - 1 > 0 ? $current_page - 1 : 1;
            $next_page = $current_page + 1 <= $totalPage ? $current_page + 1 : $totalPage;

            return response()->json([
                'statusCode'      => 200,
                'statusMessage'   => "OK",
                'message'         => 'Success',
                'data'            => [
                    'fasilitas'   => $fasilitas,
                    'page'        => [
                        'current_page'  => (int) $page,
                        'next_page'     => $next_page,
                        'previous_page' => $previouse_page,
                        'total_page'    => $totalPage,
                        'total_data'    => $totalData,
                        'limit'       => (int) $limit,
                    ]
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
            if (!$request->user() || User::find($request->user()->id))
                return $this->generateResponse->response401('Unauthorized', 'You are unauthorized. Try to login first');
            $validator = validator($request->all(), [
                'name' => 'required',
                'description' => 'sometimes|nullable', //optional,
                'generic_code_id' => 'required',
            ]);

            if ($validator->fails()) return response()->json([
                'statusCode'    => 400,
                'statusMessage' => "BAD_REQUEST",
                'message'       => 'Data fasilitas gagal ditambahkan',
                'error'         => $validator->errors(),
                'success'       => false
            ], 400);

            /**
             * Do check if generic_code_id is exists
             */
            $genericCode = GenericCode::find($request->generic_code_id);
            if (!$genericCode) return response()->json([
                'statusCode'    => 404,
                'statusMessage' => "NOT_FOUND",
                'message'       => 'Data generic code tidak ditemukan',
                'success'       => false
            ], 404);

            $fasilitas = new Fasilitas();
            $fasilitas->name = $request->name;
            $fasilitas->description = $request->description;
            $fasilitas->generic_code_id = $request->generic_code_id;
            $jenjang = GenericCode::find($request->generic_code_id);
            $fasilitas->jenjang()->associate($jenjang);
            $fasilitas->save();

            return response()->json([
                'statusCode'    => 201,
                'statusMessage' => "CREATED",
                'message'       => 'Data fasilitas berhasil ditambahkan',
                'data'          => $fasilitas,
                'success'       => true
            ], 201);
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {

            $fasilitas = Fasilitas::find($id)->with('jenjang')->where('id', $id)->first();
            if (!$fasilitas) return response()->json([
                'statusCode'    => 404,
                'statusMessage' => "NOT_FOUND",
                'message'       => 'Data fasilitas tidak ditemukan',
                'success'       => false
            ], 404);

            return response()->json([
                'statusCode'    => 200,
                'statusMessage' => "OK",
                'message'       => 'Success',
                'data'          => $fasilitas,
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
            if (!$request->user() || User::find($request->user()->id))
                return $this->generateResponse->response401('Unauthorized', 'You are unauthorized. Try to login first');
            $validator = validator($request->all(), [
                'name' => 'required',
                'description' => 'required',
                'generic_code_id' => 'required',
            ]);
            if ($validator->fails()) return response()->json([
                'statusCode'    => 400,
                'statusMessage' => "BAD_REQUEST",
                'message'       => 'Data fasilitas gagal diubah',
                'error'         => $validator->errors(),
                'success'       => false
            ], 400);
            $fasilitas = Fasilitas::find($id);
            if (!$fasilitas) return response()->json([
                'statusCode'    => 404,
                'statusMessage' => "NOT_FOUND",
                'message'       => 'Data fasilitas tidak ditemukan',
                'success'       => false
            ], 404);

            /**
             * Do check if generic_code_id is exists
             */
            $genericCode = GenericCode::find($request->generic_code_id);
            if (!$genericCode) return response()->json([
                'statusCode'    => 404,
                'statusMessage' => "NOT_FOUND",
                'message'       => 'Data generic code tidak ditemukan',
                'success'       => false
            ], 404);

            $fasilitas->name = $request->name;
            $fasilitas->description = $request->description;
            $fasilitas->generic_code_id = $request->generic_code_id;
            $fasilitas->save();
            /**
             * 201 = Created
             */
            return response()->json([
                'statusCode'    => 201,
                'statusMessage' => "CREATED",
                'message'       => 'Data fasilitas berhasil diubah',
                'success'       => true,
                'data'          => $fasilitas,
            ], 201);
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        try {
            if (!$request->user() || User::find($request->user()->id))
                return $this->generateResponse->response401('Unauthorized', 'You are unauthorized. Try to login first');
            $fasilitas = Fasilitas::find($id);
            if (!$fasilitas) return response()->json([
                'statusCode'    => 404,
                'statusMessage' => "NOT_FOUND",
                'message'       => 'Data fasilitas tidak ditemukan',
                'success'       => false
            ], 404);
            $fasilitas->delete();
            /**
             * 201 = Created
             */
            return response()->json([
                'statusCode'    => 201,
                'statusMessage' => "CREATED",
                'message'       => 'Data fasilitas berhasil dihapus',
                'success'       => true,
                'data'          => $fasilitas,
            ], 201);
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

    public function statistic()
    {
        try {
            $fasilitas = Fasilitas::all();
            $totalFasilitas = $fasilitas->count();
            $totalFasilitasPerJenjang = $fasilitas->groupBy('generic_code_id')->map(function ($item) {
                return $item->count();
            });
            $totalFasilitasPerJenjang = $totalFasilitasPerJenjang->map(function ($item, $key) {
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
                    'total_fasilitas' => $totalFasilitas,
                    'total_fasilitas_per_jenjang' => $totalFasilitasPerJenjang
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
