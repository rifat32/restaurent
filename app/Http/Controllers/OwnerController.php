<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OwnerController extends Controller
{
    public function createUser(Request $request) {

        $validator = Validator::make($request->all(), [
            'email' => 'email|required|unique:users,email',
            'password' => 'required|string|min:6',
            'first_Name' => 'required',
            'phone' => 'nullable',
            'last_Name' => 'nullable'
        ]);

        $validatedData = $validator->validated();

        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['remember_token'] = Str::random(10);
        $user =  User::create($validatedData);
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $data["user"] = $user;
        return response(["ok" => true, "message" => "You have successfully registered", "data" => $data, "token" => $token], 200);

    }
    public function createUser2(Request $request) {

        $validator = Validator::make($request->all(), [
            'email' => 'email|required|unique:users,email',
            'password' => 'required|string|min:6',
            'first_Name' => 'required',
            'phone' => 'nullable',
        ]);

        $validatedData = $validator->validated();

        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['remember_token'] = Str::random(10);
        $user =  User::create($validatedData);
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $data["user"] = $user;
        return response(["ok" => true, "message" => "You have successfully registered", "data" => $data, "token" => $token], 200);

    }
    public function createGuestUser(Request $request) {

        $validator = Validator::make($request->all(), [
            'email' => 'email|required|unique:users,email',
            'first_Name' => 'required',
            'phone' => 'nullable',
            'type' => 'nullable',
        ]);

        $validatedData = $validator->validated();
// password is not need
        // $validatedData['password'] = Hash::make($request['password']);

        $validatedData['remember_token'] = Str::random(10);
        $user =  User::create($validatedData);
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $data["user"] = $user;
        return response(["ok" => true, "message" => "You have successfully registered", "data" => $data, "token" => $token], 200);

    }
    public function createStaffUser($restaurantId,Request $request) {

        $validator = Validator::make($request->all(), [
            'email' => 'email|required|unique:users,email',
            'first_Name' => 'required',
            'phone' => 'nullable',
            'type' => 'nullable',
            'password' => 'string|nullable',
        ]);

        $validatedData = $validator->validated();

  if(array_key_exists('password',$validatedData)) {
    $validatedData['password'] = Hash::make($validatedData['password']);
  }

        $validatedData['remember_token'] = Str::random(10);
        $user =  User::create($validatedData);
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $data["user"] = $user;



        // @@@@@@@@@@@@@@@@@@@@@@@@

        // insert into res_link (user_id,restaurantid)





        return response(["ok" => true, "message" => "Staff Added Successfully", "data" => $data, "token" => $token], 200);

    }


}
