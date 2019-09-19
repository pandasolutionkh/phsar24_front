<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Cache;
use Session;

class Client
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
        if(Auth::check()){
            $user = Auth::user();
            $user_id = $user->id;
            $cache_id = 'user-is-online-'.$user_id;

            if (!($user->is_activated && $user->enabled)) {
                Cache::forget($cache_id);
                Auth::logout();
                $_msg = _t('Your account is invalid.').' '._t('Please contact administrator.');
                return redirect('login')->with('warning', $_msg);
            }

            //todo check which user is online
            $expireAt = 10;//$now->addMinutes(10);
            Cache::put($cache_id, true, $expireAt);
        }
        return $next($request);
    }
}
