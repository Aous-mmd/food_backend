<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Auth\Middleware\Authenticate;
use App\Models\User;
class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','isValidToken','check']]);
    }
    public function login(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'email' => ['required','email','max:255'],
            'password' => ['required','string','min:8','max:255']
        ]);
        if ($validator->fails()) {
            return  response()->json(['msg' => 'An error was occurred', 'errors' => $validator->errors()->first()], 400);
        }
        $token_validty = 24 * 30 * 60;
        auth('api')->setTTL($token_validty);
        if (!$token = auth('api')->attempt($validator->validated())) {
            return  response()->json(['msg' => 'An error was occurred', 'errors' => 'Wrong email or password'], 401);
        }
        $user=User::with('image')->whereEmail($req->get('email'))->first();
        return $this->respondWithToken($token,$user);
    }


    protected function guard()
    {
        return Auth::guard();
    }
    protected function respondWithToken($token,$user)
    {
        $image=$user->image;
        if($image)
        return response()->json(['msg' => 'Login Successfully', 'token' => $token,'name'=>$user->first_name,'image_url'=>$user->image['image_url']], 200);
        return response()->json(['msg' => 'Login Successfully', 'token' => $token,'name'=>$user->first_name,'image_url'=>null], 200);
    }
    public function isValidToken(Request $request)
    {
        if(auth('api')->check()==true){
            $user = JWTAuth::parseToken()->authenticate();
            return response()->json([ 'valid' => auth('api')->check(),'name'=>$user->first_name ,'image_url'=>$user->image['image_url']],200);
        }
        return response()->json([ 'valid' => auth('api')->check() ]);
    }

    public function check(){
        return response()->json(['msg'=>'connection successfully'],200);
    }
}
