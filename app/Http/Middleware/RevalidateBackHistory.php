<?php

namespace App\Http\Middleware;

use Closure;

class RevalidateBackHistory
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
        /* $response = $next($request);
         return $response->header('Cache-Control','nocache, no-store, max-age=0, must-revalidate')
                         ->header('Pragma','no-cache')
                         ->header('Expires','Fri, 01 Jan 1990 00:00:00 GMT');*/
        $response=$next($request);
       $headers = ["Pragma"=> "no-cache","Cache-Control"=>"no-store, no-cache, must-revalidate, max-age=0"];
       foreach ($headers as $key => $value)
       {$response->headers->set($key, $value); }
       return $response;
     }
}