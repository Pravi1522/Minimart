<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Factory as Auth;

class  Authenticate
{

    /**
     * The authentication factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
     public function handle($request, Closure $next, ...$guards)
    {
        $guard = @$guards[0] ?: 'web';

        $redirect_to = 'login';

        if($guard == 'admin') {
            $redirect_to = 'admin.login';
        }

        if($request->filled('token')) {
            $request->headers->set('Authorization',"Bearer ". $request->token);
        }

        if (!$this->auth->guard($guard)->check()) {
            session(['url.intended' => url()->current()]);
            if($guard == 'api') {
                return response()->json(['status' => 'token_expired'],401);
            }
            $redirect_url = resolveRoute($redirect_to);
            return redirect($redirect_url);
        }

        return $next($request);
    }
}
