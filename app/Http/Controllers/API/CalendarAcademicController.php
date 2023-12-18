<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CalendarAcademic;
use App\Services\Base64Services;
use App\Services\GenerateResponse;
use Illuminate\Http\Request;
use Hidehalo\Nanoid\Client;
use Illuminate\Support\Facades\DB;

class CalendarAcademicController extends Controller
{
    protected $generateResponse;
    protected $base64Service;
    public function __construct(GenerateResponse $generateResponse, Base64Services $base64Service)
    {
        $this->generateResponse = $generateResponse;
        $this->base64Service = $base64Service;
    }

    public function index()
    {
        try {
            $queryCategory = request()->query('generic_code');
            if (!$queryCategory) return $this->generateResponse->response400('Bad Request', 'Generic code is required');
            $calendarAcademic = CalendarAcademic::where('generic_code', $queryCategory)->get();
            return $this->generateResponse->response200($calendarAcademic);
        } catch (\Throwable $th) {
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = validator($request->all(), [
                'generic_code' => 'required',
                'files' => 'required|array',
                'files.*.base64' => 'required|string',
            ]);
            if ($validated->fails())
                return response()->json([
                    'statusCode' => 400,
                    'statusMessage' => "BAD_REQUEST",
                    'message' => 'Failed store fasilitas galeri',
                    'error' => env('APP_DEBUG') ? $validated->errors() : null,
                    'success' => false,
                ], 400);

            $data_calendar = collect([]);
            DB::beginTransaction();
            foreach ($request['files'] as $file) {
                $data = (object)$file;
                $imageBase64 = $data->base64;
                if (!$this->base64Service->validateBase64($imageBase64))
                    return $this->generateResponse->response400('Invalid Input', 'Invalid base64');

                $extension = $this->base64Service->fileExtension($imageBase64);
                if (!in_array($extension, $this->base64Service->allowed_image_extension))
                    return $this->generateResponse->response400('Invalid Input', 'Invalid image extension');

                $base64Size = $this->base64Service->base64Size($imageBase64);
                if ($base64Size > 500)
                    return $this->generateResponse->response400('Invalid Input', 'Image size must be less than 500kB');

                $image = $this->base64Service->uploadImage($this->base64Service->base64StringOnly($imageBase64), '/images/calendar-academic/');

                $calendar_academic = new CalendarAcademic();
                $calendar_academic->id = (new Client())->generateId();
                $calendar_academic->generic_code = $request->generic_code;
                $calendar_academic->file_name = $image->file_name;
                $calendar_academic->image_url = $image->file_url;

                $calendar_academic->save();
                $data_calendar->push($calendar_academic);
            }
            DB::commit();
            return $this->generateResponse->response201($data_calendar, 'Success store calendar academic');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }

    public function destroy(string $id)
    {
        try {
            $calendarAcademic = CalendarAcademic::find($id);
            if (!$calendarAcademic) return $this->generateResponse->response404('Calendar Academic not found');
            $calendarAcademic->delete();
            return $this->generateResponse->response200('Success delete calendar academic');
        } catch (\Throwable $th) {
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }
}
