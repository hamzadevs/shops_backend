<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller{
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

}