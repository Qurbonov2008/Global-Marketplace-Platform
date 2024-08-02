<?php

namespace App\Http\Controllers;

use App\Models\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $auth = Auth::where('email', request('email'))->first();
        if ($auth) {
            return response()->json(['message' => 'Bundy email bor']);
        }
        $user = Auth::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
        ]);
        return response()->json(['message' => "Muvaffaqiyatli qo'shildi"]);
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = Auth::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'Kechirasiz email topilmadi'], 404);
        }
        if (password_verify($credentials['password'], $user->password)) {
            $token = $user->createToken('auth-token')->plainTextToken;
            return response()->json([
                'message' => 'Foydalanuvchi topildi',
                'token' => $token
            ], 200);
        } else {
            return response()->json(["message" => "Parol notog'ri"], 404);
        }
    }
}
