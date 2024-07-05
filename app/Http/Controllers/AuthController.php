<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('login', 'password');

        $validator = Validator::make($credentials, [
            'login' => 'required|string',
            'password' => 'required',
        ]);


        if($validator->fails()) {
            return response()->json([
                'isSuccess' => false,
                'errors' => $validator
            ]);
        }

        // Попытка аутентификации
        if (Auth::attempt($credentials)) {
           $user = Auth::user();
           $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'isSuccess' => true,
                'token' => $token,
                'user' => $user
            ]);
        }

        return response()->json([
           'isSuccess' => false,
           'errors' => 'The provided credentials do not match our records.'
        ]);
    }

    public function register(Request $request)
    {
        // Валидация данных
        $validator = Validator::make($request->all(),[
            'login' => 'required|string|unique:users',
            'password' => 'required|min:6',
        ]);

        if($validator->fails()) {
            return response()->json([
                'isSuccess' => false,
                'errors' => $validator
            ]);
        }

        // Создание нового пользователя
        $user = new User();
        $user->login = $request->login;
        $user->password = Hash::make($request->password);
        $user->rating = 0;
        $user->assignRole('user');
        $user->save();

        return response()->json([
            'isSuccess' => true,
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json([
            'isSuccess' => true
        ]);
    }
}
