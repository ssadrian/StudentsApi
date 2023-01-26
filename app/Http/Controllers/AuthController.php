<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
     * @return Application|ResponseFactory|JsonResponse|Response Code 201 when the user was registered/created correctly
     */
    public function register(Request $request)
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

        DB::beginTransaction();
        try {
            $user->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }

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
