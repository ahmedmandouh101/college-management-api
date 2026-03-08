<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsStudent
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->role !== 'student') {
            return response()->json([
                'message' => 'Unauthorized - Students only'
            ], 403);
        }

        return $next($request);
    }
}
