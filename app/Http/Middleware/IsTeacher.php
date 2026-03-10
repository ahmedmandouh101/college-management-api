<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsTeacher
{
    public function handle(Request $request, Closure $next)
    {

        dd([
            'user' => $request->user(),
            'token' => $request->bearerToken(),
            'headers' => $request->headers->all()
        ]);
        if (!$request->user() || $request->user()->role !== 'teacher') {
            return response()->json([
                'message' => 'Unauthorized - Teachers only'
            ], 403);
        }

        return $next($request);
    }
}
