<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponseTrait;
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return $this->errorResponse(null, 'Unauthorized', 401);
        }

        return $this->successResponse($this->respondWithToken($token), 'Login successful');
    }

    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);

            $token = auth()->login($user);

            return $this->successResponse($this->respondWithToken($token), 'User registered successfully');
        } catch (\Exception $e) {
            return $this->errorResponse(null, 'حدث خطأ أثناء التسجيل: ' . $e->getMessage(), 500);
        }
    }

    public function me()
    {
        return $this->successResponse(auth()->user(), 'User data retrieved successfully');
    }

    public function logout()
    {
        auth()->logout();

        return $this->successResponse(null, 'Successfully logged out');
    }

    public function refresh()
    {
        return $this->successResponse($this->respondWithToken(auth()->refresh()), 'Token refreshed successfully');
    }

    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }
}
