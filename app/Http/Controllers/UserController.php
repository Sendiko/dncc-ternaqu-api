<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request){
        
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'profileUrl' => $request->profileUrl
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'status' => 201,
            'message' => "$user->name berhasil register",
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer'
        ], 201);

    }

    public function login(Request $request){

        $data = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:8'
        ]);

        $user = User::where('email', $data['email'])->firstOrFail();
        if(!$user || !Hash::check($data['password'], $user->password)){
            return response()->json([
                'status' => 401,
                'message' => "$user->name gagal login, mohon cek kembali data",
                'token' => 'null',
                'token_type' => 'null'
            ], 401);
        } else {
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'status' => 200, 
                'message' => "$user->name berhasil login",
                'token' => $token,
                'user' => $user,
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

    public function upgradeToPremium($id){
        $user = User::find($id);

        $user->update([
            "premium" => "1"
        ]);

        return response()->json([
            'status' => 200,
            'message' => "Selamat datang di premium, $user->name!!",
            'info' => $user
        ], 200);

    }

}
