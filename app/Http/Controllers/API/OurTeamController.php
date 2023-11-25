<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\OurTeam;
use App\Services\Base64Services;
use App\Services\GenerateResponse;
use Illuminate\Http\Request;

class OurTeamController extends Controller
{
    protected $generateResponse;
    protected $base64Services;
    public function __construct(GenerateResponse $generateResponse, Base64Services $base64Services)
    {
        $this->generateResponse = $generateResponse;
        $this->base64Services = $base64Services;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $queryName = $request->query('name');
            $queryPage = $request->query('page') ? (int) $request->query('page') : 1;
            $queryLimit = $request->query('limit') ? (int) $request->query('limit') : $this->generateResponse->limit;
            $queryResult = OurTeam::query();
            if ($queryName) $queryResult = $queryResult->where('name', 'like', '%' . $queryName . '%');
            $totalData = $queryResult->count();
            $totalPage = ceil($totalData / $queryLimit);
            $queryResult = $queryResult->orderBy('created_at', 'desc')->offset(($queryPage - 1) * $queryLimit)->limit($queryLimit)->get();
            $nextPage = $queryPage + 1 > $totalPage ? null : $queryPage + 1;
            $previousePage = $queryPage - 1 < 1 ? null : $queryPage - 1;
            $data = [
                'page' => [
                    'total_data' => $totalData,
                    'total_page' => $totalPage,
                    'next_page' => $nextPage,
                    'previouse_page' => $previousePage,
                    'current_page' => $queryPage,
                ],
                'our_team' => $queryResult
            ];
            return $this->generateResponse->response200($data, 'Success');
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
            $rules = [
                'name' => 'required|string',
                'quote' => 'required|string',
                'profile_picture' => 'required|string',
            ];
            $validator = validator($request->all(), $rules);
            if ($validator->fails()) return $this->generateResponse->response400('Bad Request', $validator->errors());

            // validate profile picture base64

            $image = $this->uploadProfilePicture($request->profile_picture);
            if (!$image) return $this->generateResponse->response500('Internal Server Error', 'Failed to upload image');

            $ourTeam = new OurTeam();
            $ourTeam->name = $request->name;
            $ourTeam->quote = $request->quote;
            $ourTeam->profile_picture = $image->file_name;
            $ourTeam->profile_picture_url = $image->file_url;
            $ourTeam->save();

            return $this->generateResponse->response201($ourTeam, 'Data has been created');
        } catch (\Throwable $th) {
            if (isset($image))
                $this->base64Services->deleteFileContent($image->file_path);
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $ourTeam = OurTeam::find($id);
            if (!$ourTeam) return $this->generateResponse->response404();
            return $this->generateResponse->response200($ourTeam, 'Success');
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
            $rules = [
                'name' => 'required|string',
                'quote' => 'required|string',
                'profile_picture' => 'nullable|string',
            ];
            $validator = validator($request->all(), $rules);
            if ($validator->fails()) return $this->generateResponse->response400('Bad Request', $validator->errors());

            $ourTeam = OurTeam::find($id);
            if (!$ourTeam) return $this->generateResponse->response404();

            if ($request->profile_picture) {
                $image = $this->uploadProfilePicture($request->profile_picture);
                if (!$image) return $this->generateResponse->response500('Internal Server Error', 'Failed to upload image');
                $ourTeam->profile_picture = $image->file_name;
                $ourTeam->profile_picture_url = $image->file_url;
            }
            $ourTeam->name = $request->name;
            $ourTeam->quote = $request->quote;
            $ourTeam->save();

            return $this->generateResponse->response201($ourTeam, 'Data has been updated');
        } catch (\Throwable $th) {
            if (isset($image))
                $this->base64Services->deleteFileContent($image->file_path);
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $ourTeam = OurTeam::find($id);
            if (!$ourTeam) return $this->generateResponse->response404();
            $ourTeam->delete();
            return $this->generateResponse->response201(null, 'Data has been deleted');
        } catch (\Throwable $th) {
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }

    private function uploadProfilePicture(string $profilePictureBase64)
    {
        $imageBase64 = $profilePictureBase64;
        if (!$this->base64Services->validateBase64($imageBase64))
            return $this->generateResponse->response400('Bad Request', 'Invalid image base64 string');

        $extension = $this->base64Services->fileExtension($imageBase64);
        if (!in_array($extension, ['jpg', 'jpeg', 'png']))
            return $this->generateResponse->response400('Bad Request', 'Image should be jpg, jpeg, or png');

        $base64Size = $this->base64Services->base64Size($imageBase64);
        if ($base64Size > 500)
            return $this->generateResponse->response400('Bad Request', 'Image size must be less than 500kB');

        $image = $this->base64Services->uploadImage($this->base64Services->base64StringOnly($imageBase64), '/images/our-team/');
        return $image;
    }

    public function deleteImageOurTeam(string $id)
    {
        try {
            $ourTeam = OurTeam::find($id);
            if (!$ourTeam) return $this->generateResponse->response404();
            $this->base64Services->deleteFileContent(public_path('images/our-team/' . $ourTeam->profile_picture));
            $ourTeam->profile_picture = null;
            $ourTeam->profile_picture_url = null;
            $ourTeam->save();
            return $this->generateResponse->response201($ourTeam, 'Image has been deleted');
        } catch (\Throwable $th) {
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }
}
