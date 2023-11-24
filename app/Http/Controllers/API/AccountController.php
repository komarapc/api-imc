<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\GenerateResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    protected $generateResponse;
    public function __construct(GenerateResponse $generateResponse)
    {
        $this->generateResponse = $generateResponse;
    }

    public function updatePassword(Request $request, string $id)
    {
        try {
            if (!$request->user() || $request->user()->id != $id) {
                return $this->generateResponse->response401("Unauthorized");
            }
            $rules = [
                'old_password' => 'required',
                'new_password' => 'required|min:8',
                'confirm_password' => 'required|same:new_password'
            ];
            $validator = validator($request->all(), $rules);
            if ($validator->fails())
                return $this->generateResponse->response400("Invalid input", $validator->errors());
            $user = User::find($id);
            if (!$user)
                return $this->generateResponse->response404("User Not Found");
            if (!Hash::check($request->old_password, $user->password))
                return $this->generateResponse->response400("Bad Request", "Old Password Not Match");
            $user->password = Hash::make($request->new_password);
            $user->save();
            return $this->generateResponse->response201($user, "Password Updated");
        } catch (\Throwable $th) {
            return $this->generateResponse->response500("Internal Server Error", env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }

    public function updateProfile(Request $request, string $id)
    {
        try {
            if (!request()->user() || request()->user()->id != $id) {
                return $this->generateResponse->response401("Unauthorized");
            }
            $rules = [
                'name' => 'required',
                'email' => 'required|email',
            ];
            $validator = validator($request->all(), $rules);
            if ($validator->fails())
                return $this->generateResponse->response400("Bad Request", $validator->errors());
            // check if email already exist and not the same with current user
            $user = User::where('email', $request->email)->where('id', '!=', $id)->first();
            if ($user)
                return $this->generateResponse->response400("Bad Request", "Email Already Exist");
            $user = User::find($id);
            if (!$user)
                return $this->generateResponse->response404("User Not Found");
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
            return $this->generateResponse->response201($user, "Profile Updated");
        } catch (\Throwable $th) {
            return $this->generateResponse->response500("Internal Server Error", env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }
}
