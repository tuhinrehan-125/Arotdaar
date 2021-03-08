<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ApiAuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['login', 'register']]);
    }


    /**
     * User Login
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email'    => 'required|email',
                'password' => 'required|string|min:6',
            ]
        );
        if(Auth::attempt($request->only('email','password'))){
            return response()->json(Auth::user(),200);
        }
        throw ValidationException::withMessages([
            'email'=>['Incorrect credentials']
        ]);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        //return response()->json(auth()->user());

        return new UserResource((auth()->user()));
    }


    /**
     * User Register
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function register(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name'     => 'required|string|between:2,100',
                'email'    => 'required|email|unique:users',
                'busniess_name' => 'required',
                'password' => 'required|min:6',
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $user= new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->phone_no=$request->phone_no;
        $user->password=bcrypt($request->password);
        $user->save();

        $setting = new Setting();
        $setting->user_id=  $user->id;
        $setting->arot_name= $request->busniess_name;
        $setting->user_id= $user->id;
        $setting->save();

        return response()->json(['message' => 'User created successfully', 'user' => $user]);
    }

    /**
     * User Logout
     * @return \Illuminate\Http\JsonResponse
     */

    public function logout()
    {
        Auth::guard('web')->logout();
        return response()->json(['message' => 'User logged out successfully']);
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */

    protected function respondWithToken($token)
    {
        return response()->json(
            [
                'access_token' => $token,
                'token_type'     => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60,
                'user' => auth()->user()
            ]
        );
    }


    public function refresh(Request  $request)
    {
        $this->auth->setRequest($request);
        $arr = $this->auth->getToken();
        $arr = $this->auth->refresh();
        $this->auth->setToken($arr);
        return response()->json([
            'success' => true,
            'data' => $request->user(),
            'refresh_token' => $arr
        ], 200);
    }
}
