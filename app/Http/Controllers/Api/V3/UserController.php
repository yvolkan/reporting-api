<?php

namespace App\Http\Controllers\Api\V3;

use App\Enums\HttpStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthenticateRequest;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;

class UserController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(AuthenticateRequest $request) 
    {
        $credentials = request(['email', 'password']);
        $token = null;
        $status = HttpStatusEnum::STATUS_OK;
        try {
            if (! $token = auth()->attempt($credentials)) {
                $message = 'Login credentials are invalid.';
                return response()->failed($message);
            }
        } catch (JWTException $e) {
            $status = HttpStatusEnum::STATUS_FAIL;
        }

        return $this->respondWithToken($token, $status);
    }

    /**
     * Get the token array structure.
     *
     * @param string|null $token
     * @param string $status
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token = null, $status)
    {
        return response()->json([
            'access_token' => $token,
            'status' => $status,
        ]);
    }
}
