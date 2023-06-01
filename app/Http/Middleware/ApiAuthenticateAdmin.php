<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class ApiAuthenticateAdmin
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
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
        if ($this->auth->guest()) {
            return response('Unauthorized.', 401);
        }

        // if( $this->auth->user()->email === 'abdullahnaseer999@gmail.com' || $this->auth->user()->email === 'tevarjohnson@gmail.com' )
        if( $this->auth->user()->role === 1 ) // In case of admin
            return $next($request);

        return response('Unauthorized.', 401);
    }
}
