<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class UserController extends Controller
{
    public function store(Request $request) {
         $input = $request->all();
         $input['password'] = Hash::make($request->password);

         User::create($input);
         
         return response()->json([
             'res' => true,
             'message' => 'Usuario creado correctamente'
         ], 200);
    }


    public function login(Request $request) {
        $user = User::whereEmail($request->email)->first();
        if(!is_null($user) && Hash::check($request->password, $user->password))
        {
            $token = $user->createToken('sistema');

            return response()->json([
                'res' => true,
                'token' => $token->accessToken,
                'message'=> 'Bienvenido al sistema'
            ], 200);
        } else {
            return response()->json([
                'res' => false,
                'message' => 'Cuenta o password incorrectos'
            ], 200);
        }
    }

    public function logout(Request $request){
        $request->user()->token()->revoke();
    
        return response()->json([
            'res' => true,
            'message' => 'Adios'
        ], 200);
    }

}
