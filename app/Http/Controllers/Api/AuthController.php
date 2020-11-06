<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest as UsuarioRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Tymon\JWTAuth\Facades\JWTAuth;

use App\User;

class AuthController extends Controller
{
    public function login (Request $request){
        
        $credenciales = $request->only([
            'email', 'password'
        ]);

        if( ! $token = Auth::guard('api')->attempt($credenciales) ){
            return response()->json([
                'error' => 'No autorizado', 
                'status' => 401,
                'response' => 'Acceso denegado. Verifica tus datos de ingreso.'
            ], 401);
        }
        
        $user = User::whereEmail($request->email)->first();
        
        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => [Auth::guard('api')->user()],
        ], 200);
    }//login

    public function registro(Request $request){
        $response = array('response' => '', 'success' => false);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8',],
        ]);

        if($validator->fails()){
            $response['response'] = $validator->messages();
        }
        else{
            $passwordEnc = Hash::make($request->password);

            $user = new User;

            try{
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = $passwordEnc;
    
                $user->save();
    
                return $this->login($request);
            }
            catch(Exception $e){
                return response()->json([
                    "success" => false,
                    'message' => ''.$e,
                ]);
            }
        }

        return response()->json($response);
    }//Registro

    public function logout(Request $request){
        try{
            JWTAuth::invalidate(JWTAuth::parseToken($request->token));

            return response()->json([
                'success' => true,
                'message' => 'Ha cerrado sesión.',
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => ''.$e,
            ]);
        }
    }

}
