<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use JWTAuth;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $shops = Shop::select('name','id','distance');
      $shop_sorted = $shops->orderBy('distance','asc')->get();
        return response()->json([
    			'shops' => $shop_sorted
    		],201);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request,[
  			'name' => 'required|unique:shops',
  			'distance' => 'required'
  		]);
      $shop = new Shop();
      $shop->name = $request->input('name');
      $shop->distance = $request->input('distance');
      $shop->save();
      return response()->json(['shop' => $shop],201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $this->validate($request,[
        'name' => 'required|unique:shops',
        'distance' => 'required'
      ]);
      $shop = Shop::find($id);
      if(!$shop){
        return response()->json(['message'=>"shop doesn't exist!" ],404);
      }
      $shop->name = $request->input('name');
      $shop->distance = $request->input('distance');
      $shop->save();
      return response()->json(['shop'=>$shop],200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $shop = Shop::find($id);
      if(!$shop){
        return response()->json(['message'=>"shop doesn't exist!" ],404);
      }
      $shop->delete();
      return response()->json(['massage' => "Shop deleted!"],200);
    }

    public function liked_shop($id)
    {
      $shop = Shop::find($id);
      $user = JWTAuth::parseToken()->toUser();
    }


}
