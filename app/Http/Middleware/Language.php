<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use App\User;
class Language  {

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
            if ( ! in_array($locale, $this->app->config->get('app.locales'))) {
                $segments = $request->segments();
                $LocalLang=$this->app->config->get('app.fallback_locale');
                array_unshift($segments,$LocalLang);
                return  redirect(implode('/', $segments));
            }

            $this->app->setLocale($locale);
        }
        $response=$next($request);
        $headers = ["Pragma"=> "no-cache","Cache-Control"=>"no-store, no-cache, must-revalidate, max-age=0",'Expires'=>'0'];
        foreach ($headers as $key => $value)
        {$response->headers->set($key, $value); }
        return $response;
    }

}