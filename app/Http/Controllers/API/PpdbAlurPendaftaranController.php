<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PpdbAlurPendaftaran;
use App\Models\User;
use App\Services\Base64Services;
use App\Services\GenerateResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PpdbAlurPendaftaranController extends Controller
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
            $ppdbAlurPendaftaran = PpdbAlurPendaftaran::orderBy('created_at', 'asc')->get();
            return $this->generateResponse->response200($ppdbAlurPendaftaran);
        } catch (\Throwable $th) {
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
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
            if (!request()->user() || !User::find(request()->user()->id)) return $this->generateResponse->response401();
            $rules = [
                'step_name' => 'required|string',
                'step_description' => 'required|string',
                'step_image' => 'required|string',
                'link' => 'nullable|string',
                'notes' => 'nullable|string',
            ];
            $validator = validator($request->all(), $rules);
            if ($validator->fails()) return $this->generateResponse->response400('Invalid Input', $validator->errors());
            if (!$this->base64Service->validateBase64($request->step_image)) return $this->generateResponse->response400('Invalid Input', 'Invalid image base64 string');
            $base64Size = $this->base64Service->base64Size($request->step_image);
            if ($base64Size > 500) return $this->generateResponse->response400('Invalid Input', 'Image size must be less than 500kB');
            $fileExtension = $this->base64Service->fileExtension($request->step_image);
            if (!in_array($fileExtension, ['jpg', 'jpeg', 'png'])) return $this->generateResponse->response400('Invalid Input', $fileExtension);
            $image = $this->base64Service->uploadImage($this->base64Service->base64StringOnly($request->step_image), '/images/ppdb/alur-pendaftaran/');
            $data = [
                'step_name' => $request->step_name,
                'step_description' => $request->step_description,
                'step_image' => $image->file_name,
                'step_image_url' => $image->file_url,
                'link' => $request->link,
                'notes' => $request->notes,
            ];
            $ppdbAlurPendaftaran = PpdbAlurPendaftaran::create($data);
            return $this->generateResponse->response200($ppdbAlurPendaftaran, 'Berhasil ditambahkan');
        } catch (\Throwable $th) {
            if (isset($image)) $this->base64Service->deleteFileContent($image->file_path);
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        try {
            //code...
        } catch (\Throwable $th) {
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
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
            DB::beginTransaction();
            if (!request()->user() || !User::find(request()->user()->id)) return $this->generateResponse->response401();
            $ppdbAlurPendaftaran = PpdbAlurPendaftaran::find($id);
            $copyAlurPendaftaran = $ppdbAlurPendaftaran;
            if (!$ppdbAlurPendaftaran) return $this->generateResponse->response404();
            $rules = [
                'step_name' => 'required|string',
                'step_description' => 'required|string',
                'step_image' => 'nullable|string',
                'link' => 'nullable|string',
                'notes' => 'nullable|string',
            ];
            $validator = validator($request->all(), $rules);
            if ($validator->fails()) return $this->generateResponse->response400('Invalid Input', $validator->errors());
            if ($request->step_image) {
                if (!$this->base64Service->validateBase64($request->step_image)) return $this->generateResponse->response400('Invalid Input', 'Invalid image base64 string');
                $base64Size = $this->base64Service->base64Size($request->step_image);
                if ($base64Size > 500) return $this->generateResponse->response400('Invalid Input', 'Image size must be less than 500kB');
                $fileExtension = $this->base64Service->fileExtension($request->step_image);
                if (!in_array($fileExtension, ['jpg', 'jpeg', 'png'])) return $this->generateResponse->response400('Invalid Input', $fileExtension);
                $image = $this->base64Service->uploadImage($this->base64Service->base64StringOnly($request->step_image), '/images/ppdb/alur-pendaftaran/');
                $data = [
                    'step_name' => $request->step_name,
                    'step_description' => $request->step_description,
                    'step_image' => $image->file_name,
                    'step_image_url' => $image->file_url,
                    'link' => $request->link,
                    'notes' => $request->notes,
                ];
                $this->base64Service->deleteFileContent($ppdbAlurPendaftaran->step_image_path);
            } else {
                $data = [
                    'step_name' => $request->step_name,
                    'step_description' => $request->step_description,
                    'link' => $request->link,
                    'notes' => $request->notes,
                ];
            }
            $ppdbAlurPendaftaran->update($data);
            DB::commit();
            return $this->generateResponse->response200($ppdbAlurPendaftaran, 'Berhasil diperbarui');
        } catch (\Throwable $th) {
            DB::rollBack();
            if (isset($image)) $this->base64Service->deleteFileContent($image->file_path);
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        try {
            if (!request()->user() || !User::find(request()->user()->id)) return $this->generateResponse->response401();
            $ppdbAlurPendaftaran = PpdbAlurPendaftaran::find($id);
            $ppdbAlurPendaftaran->delete();
            return $this->generateResponse->response200(null, 'Berhasil dihapus');
        } catch (\Throwable $th) {
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }
}
