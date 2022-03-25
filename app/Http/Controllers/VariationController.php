<?php

namespace App\Http\Controllers;

use App\Models\DishVariation;
use App\Models\Variation;
use App\Models\VariationType;
use Illuminate\Http\Request;

class VariationController extends Controller
{
    public function storeVariationType(Request $request)
    {


        $variation_type =  VariationType::create($request->toArray());


        return response($variation_type, 200);
    }
    public function storeMultipleVariationType($restaurantId, Request $request)
    {
        $variation_types = $request->VarationType;
        $variation_types_array = [];
        foreach ($variation_types as $variation_type) {
            $variation_type["restaurant_id"] = $restaurantId;
            $createdVariationType =  VariationType::create($variation_type);
            array_push($variation_types_array, $createdVariationType);
        }

        return response($variation_types_array, 201);
    }
    public function updateMultipleVariationType(Request $request)
    {


        $variation_types = $request->VarationType;
        $variation_types_array = [];

        foreach ($variation_types as $variation_type) {
            $createdVariationType =    tap(VariationType::where(["id" => $variation_type["varation_type_id"]]))->update(
                collect($variation_type)->only(['name', 'description'])->all()
            )
                // ->with("somthing")
                ->first();

            array_push($variation_types_array, $createdVariationType);
        }




        return response($variation_types_array, 200);
    }
    public function updateVariationType(Request $request)
    {

        $createdVariationType =    tap(VariationType::where(["id" => $request->VTypeId]))->update(
            $request->only(
                'name',
                'description'
            )
        )
            // ->with("somthing")

            ->first();


        return response($createdVariationType, 200);
    }
    public function storeVariation(Request $request)
    {

        $variation =  Variation::create($request->toArray());

        return response($variation, 200);
    }
    public function storeMultipleVariation(Request $request)
    {

        $variations = [];

        foreach($request->varation as $v){
            $variation =  Variation::create($v);
            array_push($variations, $variation);
        }
        return response($variations, 200);
    }
    public function updateVariation(Request $request)
    {
        $updatedVariation =    tap(Variation::where(["id" => $request->Vid]))->update(
            $request->only(
                'name',
                'description'
            )
        )
            // ->with("somthing")

            ->first();
        return response($updatedVariation, 200);
    }
    public function  storeDishVariation(Request $request)
    {

        $dishVariation =  DishVariation::create($request->toArray());

        return response($dishVariation, 200);
    }

    public function storeMultipleDishVariation($dishId, Request $request)
    {
        $variations = $request->varation;
        $variation_array = [];
        foreach ($variations as $variation) {
            $variation["dish_id"] = $dishId;
            $createdVariationType =  DishVariation::create($variation);
            array_push($variation_array, $createdVariationType);
        }

        return response($variation_array, 201);
    }
    public function getAllDishVariation($dishId, Request $request)
    {
        $dishVariations = DishVariation::with("variation_type","variation_type.variation")->where([
            "dish_id" => $dishId
        ])
        ->get();


        return response($dishVariations, 201);
    }


    public function updateDishVariation(Request $request)
    {
        $updatedDishVariation =    tap(DishVariation::where(["id" => $request->dish_id]))->update(
            $request->only(
                'no_of_varation_allowed',
                'type_id'
            )
        )
            // ->with("somthing")

            ->first();
        return response($updatedDishVariation, 200);
    }

    public function getAllVariationWithDish($restaurantId,$dishId, Request $request)
    {
        $dishAndVariations = VariationType::with("variation","dish_variation")->where([
            "restaurant_id" => $restaurantId
        ])
        ->get();


        return response($dishAndVariations, 201);
    }
    public function getAllVariationByType_Id($typeId, Request $request)
    {
        $dishAndVariations = Variation::with("variation_type","variation_type.dish_variation")->where([
            "type_id" => $typeId
        ])
        ->get();

        return response($dishAndVariations, 201);
    }
    public function deleteDishVariation($typeId, $dishId, Request $request)
    {
         DishVariation::where([
            "type_id" => $typeId,
            'dish_id' => $dishId
            ,
        ])
        ->delete();



        return response(["message" => "ok"], 201);
    }

}
