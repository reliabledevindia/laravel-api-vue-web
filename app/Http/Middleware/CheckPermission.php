<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Providers\RouteServiceProvider;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission = null)
    {
        if(!Auth::guard('admin')->user()){
             if(\Request::segment(1) == 'admin'){
                 return  redirect()->route('admin.login');
            }
        }
        $route = \Request::route()->getName(); 
        $pathAccess =  Auth::user()->checkPermissionTo($route,'admin');  
        $admin =  Auth::guard('admin')->user()->hasRole('admin');
        if(!$admin)
        { 
            if($pathAccess) 
                return $next($request);

                return redirect()->route(RouteServiceProvider::HOME_ROUTE)->with('error',trans('flash.error.you_have_not_permission_for_this_page_access'));  
        }
        else
        { 
            return $next($request);
        }
    }
}
