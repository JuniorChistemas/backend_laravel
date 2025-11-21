<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * 
     * Inicio de sesión de usuario
     * 
     * @param  LoginRequest  $request
     * @return JsonResponse
     * 
     * 
     * @throws ValidationException Si las credenciales no son válidas
     * @group Usuario
     * @unauthenticated
     *
     * @responseField token Token de autenticación del usuario
     */
    public function login(LoginRequest $request): JsonResponse{
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
     * Obtener información del usuario autenticado
     * @param  Request  $request
     * @return JsonResponse
     * 
     * @group Usuario
     * @authenticated
     * 
     * @responseField user Información del usuario autenticado
     */


    public function getUserOnly(Request $request): JsonResponse{
        $user = $request->user();
        return response()->json(['user' => $user], 200);
    }


    /**
     * Crear un nuevo usuario
     * @param  UserRequest  $request
     * @return JsonResponse
     * 
     * @group Usuario
     * @authenticated
     * 
     * @responseField message Mensaje de estado de la operación
     * 
     */

    public function create(UserRequest $request): JsonResponse{
        $name = $request->input('name');
        $email = $request->input('email');
        $password = bcrypt($request->input('password'));

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
     * 
     * @group Usuario
     * @authenticated
     */
    public function getUsers(): JsonResponse{
        $users = User::paginate(10);
        return response()->json(['users' => $users], 200);
    }

    /**
     * Cerrar sesión de usuario
     * 
     * @param  Request  $request
     * 
     * @responseField message Mensaje de estado de la operación
     * 
     * @group Usuario
     * @authenticated
     * 
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse{
        $user = $request->user();
        $user->tokens()->delete();
        return response()->json(['message' => 'Logout successful'], 200);
    }
}
