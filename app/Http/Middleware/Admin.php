<?php

namespace BovinApp\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;


class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

      public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {
        
               

     
        return $next($request);
    }
}
