<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Middleware Reader
 *
 * @package App\Http\Middleware
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 06/10/2020 01:14
 */
class Reader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

       if($request->user() and $request->user()->role >= config('custum.user_role.reader')) {
            return $next($request);
        } else {
            return redirect(url('not_authorize'));
        }

    }
}