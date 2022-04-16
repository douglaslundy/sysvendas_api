<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function unauthorized()
    {
        return response()->json([
            'error' => 'Não autorizado'
        ], 401);
    }

    public function login(Request $request)
    {
        $request->validate([
            'cpf' => 'required|digits:11',
            'password' => 'required'
        ]);

        $user = User::where('cpf', $request->cpf)->first();

        //valida e checa usuario e password

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => 'Usuario ou senha Inválidos'
            ], 401);
        }
        $token = $user->createToken('token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    // public function validateToken(){
    //     $array = ['error' => ''];

    //     $user = auth()->user();
    //     $array['user'] = $user;

    //     return $array;
    // }

    public function logout()
    {

        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logout efetuado com sucesso '
        ];
    }
}
