<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required|string|max:30',
            'email'=>'required|string|email|max:50',
            'password'=>'required|string|min:3'
        ]);


        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['data'=>$user, 'acces_token'=>$token, 'token_type' => 'Bearer']);
    }

    public function login(Request $request)
    {
        if(!Auth::attempt($request->only('email','password'))){
            return response()->json(['message'=>'Unauthorized user!', 401]);
        }

        $user = User::where('email',$request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['message'=>"Greetings ".$user->name.", welcome to the Command Post",
            'acceess_token' => $token, 
            'token_type' => 'Bearer']);
    }

    public function logout(Request $request)
    {

        //fix za gresku koju prijavljuje vscode/intelephense to je: 
        /** @var \App\Models\User $user **/
        $user=auth()->user();
        $user->tokens()->delete();

        return ['message' => "You have left the Command Post!"];

    }
}

