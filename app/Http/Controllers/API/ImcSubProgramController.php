<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ImcSubProgram;
use App\Services\GenerateResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImcSubProgramController extends Controller
{
    protected $generateResponse;
    public function __construct(GenerateResponse $generateResponse)
    {
        $this->generateResponse = $generateResponse;
    }

    public function show(string $slug)
    {
        try {
            $subProgram = ImcSubProgram::where('slug', $slug)->first();
            if (!$subProgram)
                return $this->generateResponse->response404('Sub Program not found');

            return $this->generateResponse->response200($subProgram);
        } catch (\Throwable $th) {
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $validated = validator($request->all(), [
                'name' => 'required|string',
                'description' => 'required|string',
            ]);
            if ($validated->fails())
                return $this->generateResponse->response400('Bad Request', $validated->errors());
            $subProgram = ImcSubProgram::find($id);
            if (!$subProgram) return $this->generateResponse->response404('Sub Program not found');

            // check if slug is unique
            $slug = Str::slug($request->name);
            $checkSlug = ImcSubProgram::where('slug', $slug)->first();
            if ($checkSlug && $checkSlug->id != $id)
                return $this->generateResponse->response400('Bad Request', 'Sub Program name already exist');

            $subProgram->name = $request->name;
            $subProgram->slug = $slug;
            $subProgram->description = $request->description;
            $subProgram->save();
            return $this->generateResponse->response200($subProgram);
        } catch (\Throwable $th) {
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = validator($request->all(), [
                'program_id' => 'required|string',
                'name' => 'required|string',
                'description' => 'required|string',
            ]);
            if ($validator->fails())
                return $this->generateResponse->response400('Bad Request', $validator->errors());

            // check unique slug
            $slug = Str::slug($request->name);
            $checkSlug = ImcSubProgram::where('slug', $slug)->first();
            if ($checkSlug)
                return $this->generateResponse->response400('Bad Request', 'Sub Program name already exist');

            DB::beginTransaction();
            $subProgram = new ImcSubProgram();
            $subProgram->program_id = $request->program_id;
            $subProgram->name = $request->name;
            $subProgram->slug = $slug;
            $subProgram->description = $request->description;
            $subProgram->save();
            DB::commit();
            return $this->generateResponse->response201($subProgram, 'Success store sub program');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }

    public function destroy(string $id)
    {
        try {
            $subProgram = ImcSubProgram::find($id);
            if (!$subProgram) return $this->generateResponse->response404('Sub Program not found');
            DB::beginTransaction();
            $subProgram->delete();
            DB::commit();
            return $this->generateResponse->response200('Success delete sub program');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }
}
