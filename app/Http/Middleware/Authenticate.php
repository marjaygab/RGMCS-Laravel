<?php

namespace App\Http\Middleware;

use App\Http\Controllers\UserController;
use Closure;
// use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */

     public function handle($request , Closure $next)
     {
         if (!UserController::checkLoggedIn()) {
             UserController::logout();
             return redirect('/');
         }else{
             return $next($request);
         }
     }
}
