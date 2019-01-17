<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    protected $response;

    /**
     * Create a new AuthController instance.
     * @param ApiResponse $response
     * @return void
     */
    public function __construct(ApiResponse $response)
    {
        $this->response = $response;
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $validator = Validator::make(request(['email', 'password']), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            $this->response->setData($validator->errors())->badRequest();
        }

        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return $this->response->unauthorized();
        }

        return $this->response
            ->setData(['user' => User::with('role')->find(Auth::id())])
            ->success();

        /*return $this->response
            ->setData(['user' => User::with('role')->find(Auth::id())])
            ->success();*/
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function user()
    {
        if (!Auth::check()) {
            return $this->response->unauthorized();
        } else {
            return $this->response
                ->setData(['user' => auth()->user()])
                ->success();
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            auth()->logout();
        } catch (JWTException $exception) {
            return $this->response->unauthorized();
        }

        return $this->response
            ->setMessage("Successfully logged out")
            ->success();
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        /*try {
            return $this->respondWithToken(auth()->refresh());
        }*/

        try {
            return $this->response->success();
        } catch (JWTException $exception) {
            return $this->response->unauthorized();
        }
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return $this->response
            ->setData(['access_token' => $token])
            ->success();
    }
}