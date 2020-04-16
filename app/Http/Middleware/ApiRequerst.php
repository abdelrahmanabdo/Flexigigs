<?php

namespace App\Http\Middleware;

use Closure;
// use Illuminate\Support\Facades\Auth;

class ApiRequerst
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
        $request['is_api'] = false;
        $firstpram = explode("/", $request->path());
        if ($firstpram[0] && $firstpram[0]=="api") {
            $request['is_api'] = true;
        }
        return $next($request);
    }
}
