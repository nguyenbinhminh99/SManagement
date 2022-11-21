<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if($user !== null && $user->hasRole('admin'))
        {
            return $next($request);
        }
        if($user !== null && $user->hasRole('user'))
        {
            $route = $request->route()->getName();
            if($route == 'userDelete')
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized',
                ], Response::HTTP_UNAUTHORIZED);
            }
            if($route == 'studentDelete')
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized',
                ], Response::HTTP_UNAUTHORIZED);
            }
            if($route == 'changeStatus')
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized',
                ], Response::HTTP_UNAUTHORIZED);
            }
        }
        return response()->json([
            'status' => false,
            'message' => 'Unauthorized',
        ], Response::HTTP_UNAUTHORIZED);
    }
}
