<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * 
     * Inicio de sesión de usuario
     * 
     * @param  Request  $request
     * @return JsonResponse
     * 
     * @throws ValidationException Si las credenciales no son válidas
     * @group Usuario
     * @unauthenticated
     * @responseField message Mensaje de estado de la operación
     * @responseField token Token de autenticación del usuario
     */
    public function login(Request $request): JsonResponse{
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


    /**
     * Crear un nuevo usuario
     * @param  Request  $request
     * @return JsonResponse
     * 
     */

    public function create(Request $request): JsonResponse{
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


    /**
     * Obtener todos los usuarios
     * @return JsonResponse
     */
    public function getUsers(): JsonResponse{
        $users = User::all();
        return response()->json(['users' => $users], 200);
    }

}
