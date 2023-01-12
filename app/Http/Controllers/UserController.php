<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return auth('sanctum')->user(); // return user data
    }

    /**
     * Add new user for access application.
     *
     * @param  \App\Http\Requests\RegisterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request)
    {
        $data = $request->validated(); // validate data from request
        $data['password'] = Hash::make($data['password']); // hash password

        $user = User::create($data); // create new data in users table

        $token = $user->createToken('auth_token'); // create token for user

        return response()->json([
            'status' => 201,
            'message' => $user->name . " berhasil register",
            'user' => $user,
            'token' => $token->plainTextToken,
            'token_type' => 'Bearer'
        ], 201); // return data with status code 201
    }

    /**
     * Validate user before access applicaiton.
     *
     * @param  \App\Http\Requests\LoginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $data = $request->validated(); // validate data from request

        $user = User::where('email', $data['email'])->first(); // find user by email

        if (!$user) { // if user not found
            return response()->json([
                'status' => 401,
                'message' => 'akun tidak ditemukan, mohon cek kembali',
                'token' => 'null',
                'token_type' => 'null'
            ], 401); // return data with status code 401
        }

        if (!Hash::check($data['password'], $user->password)) { // if password not match
            return response()->json([
                'status' => 401,
                'message' => $user->name . ' gagal login, mohon cek kembali',
                'token' => 'null',
                'token_type' => 'null'
            ], 401); // return data with status code 401
        }

        $token = $user->createToken('auth_token'); // create token for user

        return response()->json([
            'status' => 200,
            'message' => $user->name . ' berhasil login',
            'user' => $user,
            'token' => $token->plainTextToken,
            'token_type' => 'Bearer',
        ], 200); // return data with status code 200
    }

    /**
     * Remove access from authenticated user.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        $user = auth('sanctum')->user(); // get user data
        $user->tokens()->delete(); // delete user token

        return response()->json([
            'status' => 200,
            'message' => $user->name . ' berhasil logout',
            'token' => 'null',
            'token_type' => 'null'
        ]); // return data with status code 200
    }
}
