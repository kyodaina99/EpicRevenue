<?php

namespace App\Http\Middleware;

use App\Models\AccountStatus;
use Closure;
use App\User;
use Illuminate\Contracts\Auth\Guard;

class CheckStatus
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
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('/login');
            }
        } elseif ($this->auth->check()) {
            $status = AccountStatus::where('user_id', $this->auth->user()->id)->first();
            if ($status->is_contact_info_added === 'no') {
                return redirect('/account/create/address/?middleware_error=1');
            } elseif ($status->any_payment_method_added === 'no') {
                return redirect('/account/create/payment/?middleware_error=1');
            } elseif ($status->email_confirmed !== 'yes') {
                $middleware_error = 'You have not confirmed your email. Confirm Your email now to confirm your account!';
                return redirect('/login/check/?middleware_error=You have not confirmed your email. Confirm Your email now to confirm your account!');
            } elseif( $this->auth->user()->approved !== 'yes') {
                $middleware_error = 'Your account is not approved by administration. Be back soon!';
                return redirect('/login/check/?middleware_error=Your account is currently pending approval. Check back soon!');
            }
        } else {
            return redirect()->guest('/login');
        }

        return $next($request);
    }
}
