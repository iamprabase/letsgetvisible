<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class ApiController extends Controller
{

    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validate->fails()) {
            return response([
                'message' => $validate->errors(),
            ], 422);
        }

        $attemptLogin = Auth::attempt($request->only('email', 'password'));

        if ($attemptLogin) {
            $token = Auth::user()->createToken('visible')->plainTextToken;
            return response()->json([
                'name' => Auth::user()->name,
                'token' => $token,
            ]);
        }

        return response()->json([
            "message" => "Username or Password mismatch.",
        ], 401);
    }

    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validate->fails()) {
            return response([
                'message' => $validate->errors(),
            ], 422);
        }

        $user = User::create($request->all());

        if ($user) {
            $token = $user->createToken('visible')->plainTextToken;
            return response()->json([
                'name' => $user->name,
                'token' => $token,
            ]);
        }

        return response()->json([
            "message" => "Registration Failed.",
        ], 400);
    }

    public function logout(Request $request)
    {
        Auth::user()->currentAccessToken()->delete();

        return response()->json([
            "message" => "User Logged Out.",
        ]);
    }

}
