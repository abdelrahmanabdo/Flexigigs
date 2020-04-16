<?php

namespace App\Http\Middleware;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Hash;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\User;
use App\Permission;
use App\Role;
use Closure;

class Permissions extends Authenticatable
{
     protected $router;

    public function __construct(User $user, Router $router)
    {
        $this->router = $router;
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
        // exit;
        // auto save permtions for every active function 
        list($controller, $method) = explode('@',$this->router->getRoutes()->match($request)->getActionName());
        $controller = preg_replace('/.*\\\/', '', $controller);
        $permtion_name = $controller.'-'.$method;
        $permtion_check = Permission::where('name',$permtion_name)->first();
        if (!$permtion_check) {
            $permtion = new Permission;
            $permtion->name = $permtion_name;
            $permtion->display_name = $method;
            $permtion->save();
            Role::find('1')->attachPermission($permtion);
        }
        // End of save permtion
        $email = $request->header('PHP_AUTH_USER');
        $password = $request->header('PHP_AUTH_PW');
        $email_chick = User::where('email',$email)->first();
        $user =[];
        if ($email_chick) {
          if (Hash::check( $password ,$email_chick->password)) {
            $user = $email_chick;
          }   
        }
        
        if ($user) {
            if($user->hasRole('admin')){
                return $next($request);
            }else{
                if ($user->can($permtion_name)) {
                    return $next($request);
                }elseif($user->can($permtion_name)){
                    return $next($request);
                }else{
                    $data['status'] = false;
                    $data['permtion_name'] = $permtion_name;
                    $data['message'] = "you are not permited to access this area";
                    return response()->json($data,400);
                }
            }
        }else{
            $data['status'] = false;
            $data['message'] = "sorry, Auth failed , chick the docx file";
            return response()->json($data,400);
        }
    }
}
