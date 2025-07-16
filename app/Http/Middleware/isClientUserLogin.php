<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isClientUserLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $userArr = request()->session()->get('clientUser');
        $newReqArr = [];

        if(isset($userArr["id"])) {
            $newReqArr["client_user_id"] = $userArr["id"];
        }
        $request->merge($newReqArr);
        return $next($request);
    }
}
