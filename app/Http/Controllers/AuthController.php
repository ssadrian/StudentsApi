<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Controller in charge with the authentication
 */
class AuthController extends Controller
{
    /**
     * Register/create a new user for the api
     *
     * @param Request $request The incoming request to the endpoint
     * @return Response Code 201 when the user was registered/created correctly
     */
    public function register(Request $request): Response
    {
        $data = $request->validate([
            'name' => 'required|string|unique:users',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8'
        ]);

        $user = new User([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
        $user->save();

        // Created
        return response(status: 201);
    }

    /**
     * Authenticate an existing user by name and password
     *
     * @param Request $request The incoming request to the endpoint
     * @return JsonResponse The token of the new user
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'name' => 'required|string',
            'password' => 'required|string'
        ]);

        if (Auth::attempt($credentials)) {
            return response()->json($request->user()->createToken('token')->plainTextToken);
        }

        return response()->json([
            'msg' => 'Invalid username or password'
        ]);
    }
}
