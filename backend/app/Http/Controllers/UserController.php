<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\InsertRequest;
use App\Http\Requests\UpdateRequest;
use App\Http\Requests\DeleteRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\ExeUser;

class UserController extends Controller
{
    public function insert(InsertRequest $request)
    {
        try {
            $user = new ExeUser();
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->username = $request->username;
            $user->company = $request->company;
            $user->nationality = $request->nationality;
            $response =  $user->save();
            Log::info('[UserController::insert]' . ' Request: ' . $request . ' Status: ' . $response);
            return $response;
        } catch (\Exception $e) {
            $response = $e->getMessage();
            Log::error('[UserController::insert]' . ' Request: ' . $request . ' Status: ' . $response);
            return $response;
        }
    }

    public function update(UpdateRequest $request)
    {
        try {
            $user = ExeUser::where('email', $request->email)->first();
            if ($request->name) $user->name = $request->name;
            if ($request->phone) $user->phone = $request->phone;
            if ($request->newEmail) $user->email = $request->newEmail;
            if ($request->password) $user->password = Hash::make($request->password);
            if ($request->username) $user->username = $request->username;
            if ($request->company) $user->company = $request->company;
            if ($request->nationality) $user->nationality = $request->nationality;
            $response = $user->save();
            Log::info('[UserController::update]' . ' Request: ' . $request . ' Status: ' . $response);
            return $response;
        } catch (\Exception $e) {
            $response = $e->getMessage();
            Log::error('[UserController::update]' . ' Request: ' . $request . ' Status: ' . $response);
            return $response;
        }
    }

    public function delete(DeleteRequest $request)
    {
        try {
            $user = ExeUser::where('email', $request->email)->first();
            $response = $user->delete();
            Log::info('[UserController::delete]' . ' Request: ' . $request . ' Status: ' . $response);
            return $response;
        } catch (\Exception $e) {
            $response = $e->getMessage();
            Log::error('[UserController::delete]' . ' Request: ' . $request . ' Status: ' . $response);
            return $response;
        }
    }

    public function show()
    {
        try {
            $user = ExeUser::select(
                'name',
                'phone',
                'email',
                'password',
                'username',
                'company',
                'nationality'
            )->get();
            if ($user) {
                $response = $user;
                Log::info('[UserController::show]' . ' Status: ' . $response);
                return $response;
            } else {
                $response = abort(404);
                Log::error('[UserController::show]' . ' Status: ' . $response);
                return $response;
            }
        } catch (\Exception $e) {
            $response = $e->getMessage();
            Log::error('[UserController::show]' . ' Status: ' . $response);
            return $response;
        }
    }

    public function login()
    {
        try {
            $token = JWTAuth::getToken();
            $decoded = JWTAuth::getPayload($token)->toArray();
            $username = $decoded['username'] ?? null;
            $password = $decoded['password'] ?? null;
            if (!$username) {
                $response = response()->json([
                    'success'   => false,
                    'message'   => 'Validation errors',
                    'data'      => 'The username field is required.'
                ]);
                Log::error('[UserController::login]' . ' Status: ' . $response);
                throw new HttpResponseException($response);
            }
            if (!$password) {
                $response = response()->json([
                    'success'   => false,
                    'message'   => 'Validation errors',
                    'data'      => 'The password field is required.'
                ]);
                Log::error('[UserController::login]' . ' Status: ' . $response);
                throw new HttpResponseException($response);
            }
            if ($username && $password) {
                $validateUsername = ExeUser::where('username', $username)->first();
                if ($validateUsername) {
                    $users = ExeUser::where('username', $username)->get();
                    $vaildatePassword = 0;
                    foreach ($users as $user) {
                        if (Hash::check($password, $user->password)) {
                            $vaildatePassword = 1;
                            break;
                        }
                    }
                    if ($vaildatePassword) {
                        $response = response()->json([
                            'success'   => true,
                            'message'   => 'Logged In Successfully',
                        ]);
                        Log::info('[UserController::login]' . ' Status: ' . $response);
                        return $response;
                    } else {
                        $response = response()->json([
                            'success'   => false,
                            'message'   => 'Login errors',
                            'data'      => 'Incorrect Password.'
                        ]);
                        Log::error('[UserController::login]' . ' Status: ' . $response);
                        throw new HttpResponseException($response);
                    }
                } else {
                    $response = response()->json([
                        'success'   => false,
                        'message'   => 'Login errors',
                        'data'      => 'The username must be a valid username..'
                    ]);
                    Log::error('[UserController::login]' . ' Status: ' . $response);
                    throw new HttpResponseException($response);
                }
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            $response = response()->json(['token_expired'], 500);
            Log::error('[UserController::login]' . ' Status: ' . $response);
            return $response;
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            $response = response()->json(['token_invalid'], 500);
            Log::error('[UserController::login]' . ' Status: ' . $response);
            return $response;
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            $response = response()->json(['token_absent' => $e->getMessage()], 500);
            Log::error('[UserController::login]' . ' Status: ' . $response);
            return $response;
        }
    }
}
