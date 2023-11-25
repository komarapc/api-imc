<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\StatisticTeacherStudent as ModelsStatisticTeacherStudent;
use App\Models\User;
use App\Services\GenerateResponse;
use Illuminate\Http\Request;

class StatisticTeacherStudent extends Controller
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

            $queryPage = $request->query('page') ? (int) $request->query('page') : 1;
            $queryLimit = $request->query('limit') ? (int) $request->query('limit') : $this->generateResponse->limit;
            $statistic = ModelsStatisticTeacherStudent::query();
            $statistic->orderBy('created_at', 'desc');
            $totalData = $statistic->count();
            $totalPage = ceil($totalData / $queryLimit);
            $statistic->limit($queryLimit)->skip(($queryPage - 1) * $queryLimit);
            $statistic = $statistic->get();
            $nextPage = $queryPage < $totalPage ? $queryPage + 1 : null;
            $prevPage = $queryPage > 1 ? $queryPage - 1 : null;
            $currentPage = $queryPage;
            $data = [
                'statistics' => $statistic,
                'page' => [
                    'total_data' => $totalData,
                    'total_page' => $totalPage,
                    'next_page' => $nextPage,
                    'previouse_page' => $prevPage,
                    'current_page' => $currentPage,
                    'limit' => $queryLimit,
                ]
            ];
            return $this->generateResponse->response200($data);
        } catch (\Throwable $th) {
            return $this->generateResponse->response500('Internal Server Error', env("APP_DEBUG") ? $th->getMessage() : null);
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
            if (!request()->user() || !User::find(request()->user()->id))
                return $this->generateResponse->response401();
            $rules = [
                'tahun_ajaran_kode' => 'required|string|unique:statistic_teacher_students,tahun_ajaran_kode',
                'jumlah_murid_tk' => 'required|integer',
                'jumlah_murid_sd' => 'required|integer',
                'jumlah_murid_smp' => 'required|integer',
                'jumlah_murid_sma' => 'nullable|integer',
                'jumlah_guru_karyawan' => 'required|integer',
            ];
            $validator = validator($request->all(), $rules);
            if ($validator->fails())
                return $this->generateResponse->response400('Bad Request', $validator->errors());
            $statitic = new ModelsStatisticTeacherStudent();
            $statitic->tahun_ajaran_kode = $request->tahun_ajaran_kode;
            $statitic->jumlah_murid_tk = $request->jumlah_murid_tk;
            $statitic->jumlah_murid_sd = $request->jumlah_murid_sd;
            $statitic->jumlah_murid_smp = $request->jumlah_murid_smp;
            $statitic->jumlah_murid_sma = $request->jumlah_murid_sma;
            $statitic->jumlah_guru_karyawan = $request->jumlah_guru_karyawan;
            $statitic->save();
            return $this->generateResponse->response201($statitic, 'Data berhasil ditambahkan');
        } catch (\Throwable $th) {
            return $this->generateResponse->response500('Internal Server Error', env("APP_DEBUG") ? $th->getMessage() : null);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $statitic = ModelsStatisticTeacherStudent::find($id);
            if (!$statitic)
                return $this->generateResponse->response404();
            return $this->generateResponse->response200($statitic);
        } catch (\Throwable $th) {
            return $this->generateResponse->response500('Internal Server Error', env("APP_DEBUG") ? $th->getMessage() : null);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            if (!request()->user() || !User::find(request()->user()->id))
                return $this->generateResponse->response401();
            $rules = [
                'jumlah_murid_tk' => 'required|integer',
                'jumlah_murid_sd' => 'required|integer',
                'jumlah_murid_smp' => 'required|integer',
                'jumlah_murid_sma' => 'nullable|integer',
                'jumlah_guru_karyawan' => 'required|integer',
            ];
            $validator = validator($request->all(), $rules);
            if ($validator->fails())
                return $this->generateResponse->response400('Bad Request', $validator->errors());
            $statitic = ModelsStatisticTeacherStudent::find($id);
            if (!$statitic)
                return $this->generateResponse->response404();
            $statitic->jumlah_murid_tk = $request->jumlah_murid_tk;
            $statitic->jumlah_murid_sd = $request->jumlah_murid_sd;
            $statitic->jumlah_murid_smp = $request->jumlah_murid_smp;
            $statitic->jumlah_murid_sma = $request->jumlah_murid_sma;
            $statitic->jumlah_guru_karyawan = $request->jumlah_guru_karyawan;
            $statitic->save();
            return $this->generateResponse->response201($statitic, 'Data berhasil diubah');
        } catch (\Throwable $th) {
            return $this->generateResponse->response500('Internal Server Error', env("APP_DEBUG") ? $th->getMessage() : null);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            if (!request()->user() || !User::find(request()->user()->id))
                return $this->generateResponse->response401();
            $statitic = ModelsStatisticTeacherStudent::find($id);
            if (!$statitic)
                return $this->generateResponse->response404();
            $statitic->delete();
            return $this->generateResponse->response200(null, 'Data berhasil dihapus');
        } catch (\Throwable $th) {
            return $this->generateResponse->response500('Internal Server Error', env("APP_DEBUG") ? $th->getMessage() : null);
        }
    }
}
