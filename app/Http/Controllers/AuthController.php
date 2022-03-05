<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(AuthRegisterRequest $request)
    {


        $request['password'] = Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        $user =  User::create($request->toArray());
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $data["user"] = $user;
        return response(["ok" => true, "message" => "You have successfully registered", "data" => $data, "token" => $token], 200);
    }
    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'Invalid Credentials'], 401);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        $user = auth()->user();
        $data["user"] = $user;

        return response()->json(['data' => $data, 'token' => $accessToken,   "ok" => true], 200);
    }
    public function checkPin($id, Request $request)
    {
        $pinData =    $request->validate([
            'pin' => 'required'
        ]);
        $user =  User::where(["id" => $id])->first();
        if (!$user) {
            return response()->json([
                "message" => "Invalid Pin"
            ], 400);
        }

        if (!Hash::check($pinData["pin"], $user->pin)) {
            return response()->json([
                "message" => "Invalid Pin"
            ], 400);
        }

        return response()->json([
            "message" => "Pin Matched"
        ], 400);
    }

    public function getUserWithRestaurent(Request $request) {
        // @@@@@@@@@@ should connect with restaurent
        $user = auth()->user();
        return response()->json($user,200);


    }
}
