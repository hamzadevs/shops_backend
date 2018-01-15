<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use JWTAuth;
use Carbon\Carbon;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $user = JWTAuth::parseToken()->toUser();
      //$shops = Shop::select('name','id','distance');
      $excepted_ids = $user->shops()->wherePivot('like',true)->get()->pluck('id')->toArray();
      $excepted_ids += $user->shops()->wherePivot('dislike',true)->wherePivot('dislike_date','<',Carbon::now(-2)->toDateTimeString())->get()->pluck('id')->toArray();
      $shops_filtered = Shop::select('*')->orderBy('distance','ASC');
      $shop_sorted = $shops_filtered->get()->except($excepted_ids);
        return response()->json([
    			'shops' => $shop_sorted,
          'excepted_ids' => $excepted_ids
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

    public function like($id)
    {
      $shop = Shop::find($id);
      if(!$shop){
        return response()->json(['message'=>"shop doesn't exist!" ],404);
      }
      $user = JWTAuth::parseToken()->toUser();
      if($user->shops()->wherePivot('shop_id',$shop->id)->get()->isEmpty())
        $shop->users()->attach($user->id);
      else $user->shops()->updateExistingPivot($shop->id, array('like' => true,'dislike' => false,'dislike_date' => NULL));

      $shop->users()->syncWithoutDetaching($user->id);
      return response()->json(['massage' => "Shop liked!"],200);
    }

    public function dislike($id)
    {
      $shop = Shop::find($id);
      if(!$shop){
        return response()->json(['message'=>"shop doesn't exist!" ],404);
      }
      $user = JWTAuth::parseToken()->toUser();
      if($user->shops()->wherePivot('shop_id',$shop->id)->get()->isEmpty())
        return response()->json(['message'=>"Shop doesn't exist in preffered list!" ],404);
      $user->shops()->updateExistingPivot($shop->id, array('like' => false,'dislike' => true,'dislike_date' => date("Y-m-d H:i:s")));
      return response()->json(['massage' => "Shop dislike!"],200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPreffered()
    {
      $user = JWTAuth::parseToken()->toUser();
      $shops_preffered = $user->shops()->wherePivot('like',true)->get();
        return response()->json([
    			'shops' => $shops_preffered
    		],201);
    }




}
