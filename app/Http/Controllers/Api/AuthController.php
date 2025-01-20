<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;

class AuthController extends Controller
{
    public function register(Request $request){
        $login=new User();
        $login->name=$request->name;
        $login->email=$request->email;
        $login->password=Hash::make($request->password);
        $login->save();
        return response()->json(['message'=>'User is register']);
    }

    public function login(Request $request){

        $user = User::where('email', $request->email)->first();
 
        if (! $user || ! Hash::check($request->password, $user->password)) {
            // throw ValidationException::withMessages([
            //     'email' => ['The provided credentials are incorrect.'],
            // ]);
            return response()->json(['message'=>'The give information is invalid']);
        }
        $token=$user->createToken("token")->plainTextToken;

        return response()->json(['token'=>$token]);
    }


    public function logout(Request $request){
        $user = $request->user();
        if (!$user) {
            return response()->json(["message" => "Unauthenticated."], 401);
        }
    
        $user->currentAccessToken()->delete();
    
        return response()->json(["message" => "Logged out successfully"]);
    }
}
