<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\GenericCode;
use Illuminate\Http\Request;

class GenericCodeController extends Controller
{
    public function index(Request $request)
    {
        /**
         * Query Params
         */
        $genericCodeId = $request->query('gc_id');
        $genericCodeName = $request->query('generic_code_name');
        $page = $request->query('page') ? $request->query('page') : 1;
        $limit = $request->query('limit') ? $request->query('limit') : 25;
        $sort = $request->query('sort');
        $sortDirection = $request->query('sort_direction');

        try {
            $queryResult = GenericCode::query();
            if ($genericCodeId) {
                $queryResult = $queryResult->where('generic_code_id', 'like', '%' . $genericCodeId . '%');
            }
            if ($genericCodeName) {
                $queryResult = $queryResult->where('generic_code_name', 'like', '%' . $genericCodeName . '%');
            }
            if ($sort) {
                $queryResult = $queryResult->orderBy($sort, $sortDirection ? $sortDirection : 'asc');
            }
            if ($page && $limit) {
                $queryResult = $queryResult->offset(($page - 1) * $limit)->limit($limit);
            }

            $totalData = $queryResult->count();
            $totalPage = ceil($totalData / $limit);
            $current_page = $page ? $page : 1;
            $previouse_page = $current_page - 1 > 0 ? $current_page - 1 : 1;
            $next_page = $current_page + 1 <= $totalPage ? $current_page + 1 : $totalPage;
            $genericCodes = $queryResult->get();
            return response()->json([
                'statusCode' => 200,
                'statusMessage' => "OK",
                'message' => 'Success get generic codes',
                'success' => true,
                'data' => [
                    'page' => [
                        'current_page'   => $current_page,
                        'previouse_page' => $previouse_page,
                        'next_page'      => $next_page,
                        'total_page'     => $totalPage,
                        'total_data'     => $totalData,
                    ],
                    'generic_code' => $genericCodes
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'statusCode' => 500,
                'statusMessage' => "INTERNAL_SERVER_ERROR",
                'message' => 'Failed get generic code',
                'error' => env('APP_DEBUG') ? $th->getMessage() : null,
                'success' => false,
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $genericCode = GenericCode::find($id);
            if (!$genericCode) {
                return response()->json([
                    'statusCode' => 404,
                    'statusMessage' => "NOT_FOUND",
                    'message' => 'Generic code not found',
                    'success' => false,
                ], 404);
            }
            return response()->json([
                'statusCode' => 200,
                'statusMessage' => "OK",
                'message' => 'Success get generic code',
                'success' => true,
                'data' => [
                    'generic_code' => $genericCode
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'statusCode' => 500,
                'statusMessage' => "INTERNAL_SERVER_ERROR",
                'message' => 'Failed get generic code',
                'error' => env('APP_DEBUG') ? $th->getMessage() : null,
                'success' => false,
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {

            $validator = validator($request->all(), [
                'generic_code_id' => 'required|unique:generic_codes,generic_code_id',
                'generic_code_name' => 'required',
            ]);

            if ($validator->fails()) return response()->json([
                'statusCode' => 400,
                'statusMessage' => "BAD_REQUEST",
                'message' => 'Failed create generic code',
                'error' => $validator->errors(),
                'success' => false,
            ], 400);

            $genericCode = new GenericCode();
            $genericCode->generic_code_id = (string) $request->generic_code_id;
            $genericCode->generic_code_name = $request->generic_code_name;
            $genericCode->save();
            return response()->json([
                'statusCode' => 201,
                'statusMessage' => "CREATED",
                'message' => 'Success create generic code',
                'success' => true,
                'data' => [
                    'generic_code' => $genericCode
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'statusCode' => 500,
                'statusMessage' => "INTERNAL_SERVER_ERROR",
                'message' => 'Failed create generic code',
                'error' => env('APP_DEBUG') ? $th->getMessage() : null,
                'success' => false,
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = validator($request->all(), [
                'generic_code_name' => 'required',
            ]);
            if ($validator->fails()) return response()->json([
                'statusCode' => 400,
                'statusMessage' => "BAD_REQUEST",
                'message' => 'Failed update generic code',
                'error' => $validator->errors(),
                'success' => false,
            ], 400);
            $genericCode = GenericCode::find($id);
            if (!$genericCode) {
                return response()->json([
                    'statusCode' => 404,
                    'statusMessage' => "NOT_FOUND",
                    'message' => 'Generic code not found',
                    'success' => false,
                ], 404);
            }
            $genericCode->generic_code_name = $request->generic_code_name;
            $genericCode->save();
            return response()->json([
                'statusCode' => 201,
                'statusMessage' => "CREATED",
                'message' => 'Success update generic code',
                'success' => true,
                'data' => [
                    'generic_code' => $genericCode
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'statusCode' => 500,
                'statusMessage' => "INTERNAL_SERVER_ERROR",
                'message' => 'Failed update generic code',
                'error' => env('APP_DEBUG') ? $th->getMessage() : null,
                'success' => false,
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $genericCode = GenericCode::find($id);
            if (!$genericCode) {
                return response()->json([
                    'statusCode' => 404,
                    'statusMessage' => "NOT_FOUND",
                    'message' => 'Generic code not found',
                    'success' => false,
                ], 404);
            }
            $genericCode->delete();
            return response()->json([
                'statusCode' => 201,
                'statusMessage' => "CREATED",
                'message' => 'Success delete generic code',
                'success' => true,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'statusCode' => 500,
                'statusMessage' => "INTERNAL_SERVER_ERROR",
                'message' => 'Failed delete generic code',
                'error' => env('APP_DEBUG') ? $th->getMessage() : null,
                'success' => false,
            ], 500);
        }
    }
}
