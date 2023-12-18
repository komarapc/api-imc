<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ImcSubProgramGalery;
use App\Services\Base64Services;
use App\Services\GenerateResponse;
use Hidehalo\Nanoid\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImcSubProgramGaleryController extends Controller
{
    protected $generateResponse;
    protected $base64Service;
    public function __construct(GenerateResponse $generateResponse, Base64Services $base64Service)
    {
        $this->generateResponse = $generateResponse;
        $this->base64Service = $base64Service;
    }


    public function show(string $sub_program_id)
    {
        try {
            $queryPage = request()->query('page') ? request()->query('page') : 1;
            $queryLimit = request()->query('limit') ? request()->query('limit') : $this->generateResponse->limit;

            $queryResult = ImcSubProgramGalery::query();
            $queryResult = $queryResult->where('sub_program_id', $sub_program_id);

            $total_data = $queryResult->count();
            $queryResult = $queryResult->offset(($queryPage - 1) * $queryLimit)->limit($queryLimit);
            $totalPage = ceil($total_data / $queryLimit);
            $current_page = $queryPage ? $queryPage : 1;
            $previouse_page = $current_page - 1 > 0 ? $current_page - 1 : 1;
            $next_page = $current_page + 1 <= $totalPage ? $current_page + 1 : $totalPage;

            $queryResult = $queryResult->orderBy('created_at', 'desc')->get();

            $data_page = [
                'total_data' => $total_data,
                'total_page' => $totalPage,
                'current_page' => $current_page,
                'previouse_page' => $previouse_page,
                'next_page' => $next_page,
            ];
            $result = [
                'page' => $data_page,
                'data' => $queryResult,
            ];
            return $this->generateResponse->response200($result);
        } catch (\Throwable $th) {
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = validator($request->all(), [
                'sub_program_id' => 'required|string',
                'files' => 'required|array',
                'files.*.base64' => 'required|string',
            ]);
            if ($validator->fails())
                return $this->generateResponse->response400('Bad Request', $validator->errors());

            $data_imc_sub_program_galery = collect([]);
            DB::beginTransaction();
            foreach ($request['files'] as $file) {
                $data = (object)$file;
                $imageBase64 = $data->base64;
                if (!$this->base64Service->validateBase64($imageBase64))
                    return $this->generateResponse->response400('Invalid Input', 'Invalid base64');

                $extension = $this->base64Service->fileExtension($imageBase64);
                if (!in_array($extension, $this->base64Service->allowed_image_extension))
                    return $this->generateResponse->response400('Invalid Input', 'Allowed image extension: jpg, jpeg, png');

                $base64Size = $this->base64Service->base64Size($imageBase64);
                if ($base64Size > 500)
                    return $this->generateResponse->response400('Invalid Input', 'Image size must be less than 500kB');

                $image = $this->base64Service->uploadImage($this->base64Service->base64StringOnly($imageBase64), '/images/program-imc/');

                $imc_sub_program_galery = new ImcSubProgramGalery();
                $imc_sub_program_galery->id = (new Client())->generateId();
                $imc_sub_program_galery->sub_program_id = $request->sub_program_id;
                $imc_sub_program_galery->file_name = $image->file_name;
                $imc_sub_program_galery->image_url = $image->file_url;
                $imc_sub_program_galery->save();
                $data_imc_sub_program_galery->push($imc_sub_program_galery);
            }
            DB::commit();
            return $this->generateResponse->response201($data_imc_sub_program_galery, 'Success store sub program galery');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }

    public function destroy(string $id)
    {
        try {
            $imc_sub_program_galery = ImcSubProgramGalery::find($id);
            if (!$imc_sub_program_galery) return $this->generateResponse->response404('Sub Program Galery not found');
            DB::beginTransaction();
            $imc_sub_program_galery->delete();
            DB::commit();

            return $this->generateResponse->response201(null, 'Success delete sub program galery');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }
}
