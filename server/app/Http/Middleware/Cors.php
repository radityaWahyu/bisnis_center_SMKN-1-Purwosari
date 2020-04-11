<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //set ip or domain can access for this API
        $allowOrigins = [
            'http://localhost:3000',
            'http://localhost:8000'
        ];

        $requestOrigin = $request->headers->get('origin');

        if(in_array($requestOrigin, $allowOrigins)){
            return $next($request)
                ->header('Access-Control-Allow-Origin', $requestOrigin)
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE')
                ->header('Access-Control-Allow-Credentials', 'true')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        }

        return $next($request);
    }
}
