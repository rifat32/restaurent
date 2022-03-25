<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function storeMenu($restaurantId,Request $request)
    {
$body = $request->toArray();
$body["restaurant_id"] = $restaurantId;

        $menu =  Menu::create($body);


        return response($menu, 200);
    }

    public function updateMenu($MenuId,Request $request)
    {

        $menu =    tap(Menu::where(["id" => $MenuId]))->update(
            $request->only(
                'name',
                'description',
                'restaurant_id'
            )
        )
            // ->with("somthing")

            ->first();


        return response($menu, 200);
    }


    public function getMenuById($menuId, Request $request)
    {
        $menu = Menu::where([
            "id" => $menuId
        ])
        ->first();


        return response($menu, 201);
    }
    public function getMenuByRestaurantId($restaurantId, Request $request)
    {
        $menu = Menu::where([
            "restaurant_id" => $restaurantId
        ])
        ->get();


        return response($menu, 201);
    }
    public function storeMultipleMenu($restaurantId, Request $request)
    {
        $menus = $request->menu;
        $menus_array = [];
        foreach ($menus as $menu) {
            $menu["restaurant_id"] = $restaurantId;
            $createdMenu =  Menu::create($menu);
            array_push($menus_array, $createdMenu);
        }

        return response($menus_array, 201);
    }


    public function updateMultipleMenu(Request $request)
    {


        $menus = $request->menu;
        $menus_array = [];

        foreach ($menus as $menu) {
            $updatedMenu =    tap(Menu::where(["id" => $menu["id"]]))->update(
                collect($menu)->only(['name', 'description'])->all()
            )
                // ->with("somthing")
                ->first();

            array_push($menus_array, $updatedMenu);
        }




        return response($menus, 200);
    }
    public function updateMenu2(Request $request)
    {

        $menu =    tap(Menu::where(["id" => $request->id]))->update(
            $request->only(
                'name',
                'description'
            )
        )
            // ->with("somthing")

            ->first();


        return response($menu, 200);
    }


    public function deleteMenu($menuId, Request $request)
    {
         Menu::where([
            "id" => $menuId,
        ])
        ->delete();



        return response(["message" => "ok"], 200);
    }
}
