<?php

namespace App\Http\Middleware;

use App\Enums\HttpStatusEnum;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiTokenHandle
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = JWTAuth::getToken();
        try {
            $user = JWTAuth::authenticate($token);
        } catch (TokenExpiredException $e) {
            return response()->json([
                'status' => HttpStatusEnum::STATUS_FAIL,
                'message' => 'Token has expired',
            ], 500);
        } catch (TokenInvalidException $e) {
            return response()->json([
                'status' => HttpStatusEnum::STATUS_FAIL,
                'message' => 'Token Invalid',
            ], 500);
        } catch (JWTException $e) {
            return response()->json([
                'status' => HttpStatusEnum::STATUS_FAIL,
                'message' => $e->getMessage(),
            ], 500);
        }

        return $next($request);
    }
}
