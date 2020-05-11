<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use App\Conts;
use App\Permission;
use App\Action;

class Permit
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
        $userRole = $request->user()->role->name;
        // $userRole = 'user';
        $action = Route::getCurrentRoute()->getActionName();
        $route = str_replace('App\Http\Controllers\\', '', $action);
        $route = explode('@', $route);

        if($userRole === 'admin')
            return $next($request);

        $controller = Conts::where(['name' => $route[0]])->first();
        if(!$controller){
            return response()->json(['error' => true, 'message' => 'Access denied']);
        }
        $act = Action::where(['code' => $route[1]])->where(['conts_id' => $controller->id])->first();
        if(!$act){
            return response()->json(['error' => true, 'message' => 'Access denied action']);
        }
        $permission = Permission::where(['role_id' => $request->user()->role->id])
                                ->where(['conts_id' => $controller->id])
                                ->where(['action_id' => $act->id])->first();

        if($permission){
            return $next($request);
        }
        return response()->json(['error'=>true, 'message'=> 'Access denied']);
    }
}
