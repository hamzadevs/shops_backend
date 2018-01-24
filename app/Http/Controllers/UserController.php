<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Tymon\JWTAuth\Exceptions\JWTException;

use JWTAuth;

class UserController extends Controller{
	/**
	 * [signup description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function signup(Request $request)
	{
		$this->validate($request,[
			'email' => 'required|email|unique:users',
			'password' => 'required'
		]);

		$user = new User([
			'email' => $request->input('email'),
			'password' => bcrypt($request->input('password'))
		]);

		$user->save();

		return response()->json([
			'message' => 'Successfully created user!'
		],201);
	}

	public function signin(Request $request)
	{
		$this->validate($request,[
			'email' => 'required|email',
			'password' => 'required'
		]);

		$credientials = $request->only('email','password');
		try {
			if (!$token = JWTAuth::attempt($credientials)) {
				return response()->json([
					'error' => 'Invalid Credientials!'
				],401);
			}
		} catch (JWTException $e) {
			return response()->json([
					'error' => 'Could not create Token!'
				],500);
		}
		return response()->json([
					'token' => $token
				],200);
	}
	/**
		* Log out
		* Invalidate the token, so user cannot use it anymore
		* They have to relogin to get a new token
		*
		* @param Request $request
		*/
	 public function logout(Request $request) {
			 $this->validate($request, ['token' => 'required']);
			 try {
					 JWTAuth::invalidate($request->input('token'));
					 return response()->json(['res' => true],200);
			 } catch (JWTException $e) {
					 // something went wrong whilst attempting to encode the token
					 return response()->json(['res' => false, 'message' => 'Failed to logout, please try again.'], 500);
			 }
	 }

}
