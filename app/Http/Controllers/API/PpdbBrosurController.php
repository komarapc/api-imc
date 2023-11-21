<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PpdbBrosur;
use App\Models\User;
use App\Services\Base64Services;
use App\Services\GenerateResponse;
use Hidehalo\Nanoid\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PpdbBrosurController extends Controller
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
            $brosurs = PpdbBrosur::orderBy('created_at', 'asc')->get();
            return $this->generateResponse->response200($brosurs);
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
            // return response()->json($request->all());
            DB::beginTransaction();
            if (!request()->user() || !User::find(request()->user()->id)) return $this->generateResponse->response401();
            $rules = [
                'images' => 'required|array',
                'images.*' => 'required|string', // Custom rule for base64-encoded images
            ];
            $validator = validator($request->all(), $rules);
            // return response()->json($request->images);
            if (!$validator->fails()) return $this->generateResponse->response400('Invalid Input', $validator->errors());
            $brosurs = [];
            $image_path = [];
            $client = new Client();
            foreach ($request->images as  $request_image) {
                $data = (object) $request_image;
                $imageBase64 = $data->image;
                if (!$this->base64Service->validateBase64($imageBase64)) return $this->generateResponse->response400('Invalid Input', 'Invalid image base64 string');
                $extension = $this->base64Service->fileExtension($imageBase64);
                if (!in_array($extension, ['jpg', 'jpeg', 'png'])) return $this->generateResponse->response400('Invalid Input', 'Invalid image extension');
                $base64Size = $this->base64Service->base64Size($imageBase64);
                if ($base64Size > 500) return $this->generateResponse->response400('Invalid Input', 'Image size must be less than 500kB');
                $image = $this->base64Service->uploadImage($this->base64Service->base64StringOnly($imageBase64), '/images/ppdb/brosur/');
                if (!$image) return $this->generateResponse->response500('Internal Server Error', 'Failed to upload image');
                // push to array
                array_push($brosurs, [
                    'id' => $client->generateId(21),
                    'image' => $image->file_name,
                    'image_url' => $image->file_url,
                ]);
                array_push($image_path, $image->file_path);
            }
            $create_brosur = PpdbBrosur::insert($brosurs);
            DB::commit();
            return $this->generateResponse->response200($brosurs);
        } catch (\Throwable $th) {
            DB::rollBack();
            if (count($image_path) > 0) {
                foreach ($image_path as $path) {
                    $this->base64Service->deleteFileContent($path);
                }
            }
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
