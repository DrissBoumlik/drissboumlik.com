<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;

class LocationMiddleware
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
        $ip = $request->ip();
//        $ip = '105.158.165.210';
//        $ip = '48.188.144.248';
        $currentUserInfo = Location::get($ip);
        if ($currentUserInfo) {
            $visitedbefore = \App\Models\Visitor::where('ip', $currentUserInfo->ip)->first();
            if (!$visitedbefore) {
                \App\Models\Visitor::create((array) $currentUserInfo);
            }
        }
        return $next($request);
    }
}
