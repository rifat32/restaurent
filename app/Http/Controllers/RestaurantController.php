<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RestaurantController extends Controller
{
    public function storeRestaurent($ownerId , Request $request) {
        $validator = Validator::make($request->all(), [
            'Name' => 'required|unique:restaurants,Name',
            'Address' => 'required|string',
            'PostCode' => 'required',
        ]);


        $validatedData = $validator->validated();
        $validatedData["OwnerID"] = $ownerId;
        $validatedData["Status"] = "Inactive";

        $validatedData["Key_ID"] = Str::random(10);
        $validatedData["expiry_date"] = Date('y:m:d', strtotime('+15 days'));


        $restaurant =  Restaurant::create($validatedData);


        return response( $restaurant, 200);
    }


    public function uploadRestaurentImage($restaurentId, Request $request) {

        $request->validate([

            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);



        $imageName = time().'.'.$request->logo->extension();



        $request->logo->move(public_path('img/restaurant'), $imageName);

        $imageName = "img/restaurant/" . $imageName;

        $data["restaurent"] =    tap(Restaurant::where(["id" => $restaurentId]))->update([
            "Logo" => $imageName
        ])
        // ->with("somthing")

        ->first();


        if(!$data["restaurent"]){
            return response()->json(["message" =>"No User Found"], 404);
        }

      $data["message"] = "restaurant image updates successfully" ;
        return response()->json($data, 200);


    }

    public function UpdateResturantDetails($restaurentId,Request $request) {

        $data["restaurant"] =    tap(Restaurant::where(["id" => $restaurentId]))->update($request->only(
            "Name",
            "Layout",
            "Address",
             "PostCode",
        ))
        // ->with("somthing")

        ->first();


        if(!$data["restaurant"]){
            return response()->json(["message" =>"No Restaurant Found"], 404);
        }


      $data["message"] = "Restaurant updates successfully" ;
        return response()->json($data, 200);

    }

    public function UpdateResturantDetailsByAdmin($restaurentId,Request $request) {


        $data["restaurant"] =    tap(Restaurant::where(["id" => $restaurentId]))->update($request->only(
            "Name",
            "Layout",
            "Address",
            "PostCode",
            "expiry_date"
        ))
        // ->with("somthing")

        ->first();


        if(!$data["restaurant"]){
            return response()->json(["message" =>"No Restaurant Found"], 404);
        }


      $data["message"] = "Restaurant updates successfully" ;
        return response()->json($data, 200);
    }

    public function getrestaurantById($restaurantId){
        $data["restaurant"] =   Restaurant::with("owner")->where(["id" => $restaurantId])->first();
        $data["ok"] = true;

        if(!$data["restaurant"]) {
  return response([ "message" => "No Restaurant Found"], 404);
        }
        return response($data, 200);

    }
    public function getAllRestaurants(){
        $data["restaurant"] =   Restaurant::with("owner")->get();
        $data["ok"] = true;
//         if(!$data["restaurant"]) {
//   return response([ "message" => "No Restaurant Found"], 404);
//         }
        return response($data, 200);

    }
    public function getrestaurantTableByRestaurantId($restaurantId){
        $data["restaurant"] =   Restaurant::with("owner","table")->where(["id" => $restaurantId])->first();
        $data["ok"] = true;

        if(!$data["restaurant"]) {
  return response([ "message" => "No Restaurant Found"], 404);
        }
        return response($data, 200);

    }



}
