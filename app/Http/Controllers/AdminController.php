<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function register(Request $request){
        
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $admin = Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        $token = $admin->createToken('auth_token')->plainText;
        return response()->json([
            'status' => 201,
            'message' => "$admin->name berhasil register",
            'data' => $admin,
            'token' => $token,
            'token_type' => 'Bearer'
        ], 201);

    }

    public function login(Request $request){

        $data = $request->validator([
            'email' => 'required|string|email',
            'password' => 'required|string|min:8'
        ]);

        $admin = Admin::where('email', $data['email'])->firstOrFail();
        if(!$admin || !Hash::check($data['password'], $admin->password)){
            return response()->json([
                'status' => 401,
                'message' => "$admin->name gagal login, mohon cek kembali data",
                'token' => 'null',
                'token_type' => 'null'
            ], 401);
        } else {
            $token = $admin->createToken('auth_token')->plainTextToken;
            return response()->json([
                'status' => 200, 
                'message' => "$admin->name berhasil login",
                'token' => $token,
                'token_type' => 'Bearer',
            ], 200);
        }

    }

    public function logout(){
        auth('sanctum')->user()->tokens()->delete();
        return response()->json([
            'status' => 200,
            'message' => 'berhasil logout',
            'token' => 'null',
            'token_type' => 'null'
        ]);
    }

}
