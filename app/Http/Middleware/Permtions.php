<?php

namespace App\Http\Middleware;
use Illuminate\Routing\Route;

// use Closure;

class Permtions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Route $route)
    {
        echo 'getIndex';
        echo $route->getActionName();exit;
    }
}
