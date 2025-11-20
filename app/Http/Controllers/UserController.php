<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Handle user login and token generation.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
        $email = $request->input('email');
        $password = $request->input('password');
        if(!Auth::attempt(['email' => $email, 'password' => $password])){
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        $user = Auth::user();
        $token = $user->createToken('api',['create-user','update-user','delete-user','view-user'], Carbon::now()->addHours(2))->plainTextToken;
        return response()->json([
            'message' => 'Login successful',
            'token' => $token
        ], 200);
    }


    public function create(Request $request){
        $name = $request->input('name');
        $email = $request->input('email');
        $password = Hash::make($request->input('password'));

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);

        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
    }

}
