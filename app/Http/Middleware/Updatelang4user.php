<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use App\User;
class Updatelang4user  {

    public function __construct(Application $app, Redirector $redirector, Request $request) {
        $this->app = $app;
        $this->redirector = $redirector;
        $this->request = $request;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Make sure current locale exists.
        $locale = $request->segment(1);//exit;
        if($locale !='api' && $locale !='apple-app-site-association' && $locale !='oauth'){
            if ($request->user()) {
                if ($request->user()->lang_perfix != $locale) {
                    User::where('id',$request->user()->id)->update(['lang_perfix'=>$locale]);
                }
            }
        }
        return $next($request);
    }

}