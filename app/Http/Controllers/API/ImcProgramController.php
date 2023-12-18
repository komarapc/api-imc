<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ImcProgram;
use App\Services\GenerateResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImcProgramController extends Controller
{
    protected $generateResponse;
    public function __construct(GenerateResponse $generateResponse)
    {
        $this->generateResponse = $generateResponse;
    }

    public function index()
    {
        try {
            $queryName = request()->query('name');
            $programs = ImcProgram::when($queryName, function ($query, $queryName) {
                return $query->where('name', 'like', "%{$queryName}%");
            })->get();
            return $this->generateResponse->response200($programs);
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

            $program = ImcProgram::find($id);
            if (!$program) return $this->generateResponse->response404('Program not found');

            // check if slug is unique
            $slug = Str::slug($request->name);
            $checkSlug = ImcProgram::where('slug', $slug)->first();
            if ($checkSlug && $checkSlug->id != $id)
                return $this->generateResponse->response400('Bad Request', 'Program name already exist');


            DB::beginTransaction();
            $program->name = $request->name;
            $program->slug = $slug;
            $program->description = $request->description;
            $program->save();
            DB::commit();

            return $this->generateResponse->response200($program);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }


    public function show(string $slug)
    {
        try {
            $program = ImcProgram::where('slug', $slug)->with('subPrograms')->first();
            // $program = $program->with('subPrograms');
            if (!$program) return $this->generateResponse->response404('Program not found');
            return $this->generateResponse->response200($program);
        } catch (\Throwable $th) {
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }
}
