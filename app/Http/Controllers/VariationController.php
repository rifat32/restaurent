<?php

namespace App\Http\Controllers;

use App\Models\VariationType;
use Illuminate\Http\Request;

class VariationController extends Controller
{
    public function storeVariationType(Request $request){


        $variation_type =  VariationType::create($request->toArray());


        return response( $variation_type, 200);
    }
    public function storeMultipleVariationType($restaurantId, Request $request){
       $variation_types = $request->VarationType;
       $variation_types_array = [];
       foreach($variation_types as $variation_type) {
        $variation_type["resturant_id"] = $restaurantId;
      $createdVariationType =  VariationType::create($variation_type);
      array_push($variation_types_array,$createdVariationType);
       }




        return response( $variation_types_array, 201);
    }
    public function updateMultipleVariationType( Request $request){


        $variation_types = $request->VarationType;
        $variation_types_array = [];

        foreach($variation_types as $variation_type) {
       $createdVariationType =    tap(VariationType::where(["id" => $variation_type["varation_type_id"]]))->update(
           collect($variation_type)->only(['name','description'])->all()
    )
    // ->with("somthing")
    ->first();

       array_push($variation_types_array,$createdVariationType);
        }




         return response( $variation_types_array, 200);
     }
     public function updateVariationType( Request $request){

       $createdVariationType =    tap(VariationType::where(["id" => $request->Vid]))->update(
       $request->only(
'name',
'description'
       )
    )
    // ->with("somthing")

    ->first();


         return response( $createdVariationType, 200);
     }

}
