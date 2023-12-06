<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
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
            $route = $request->decodedPath();
            $currentUserInfo->url = $route === '/' ? 'Home' : "/$route";
            $visitor = Visitor::where('ip', $ip)->orderBy('updated_at', 'desc')->first();
            if ($visitor) {
                $timeSinceLastVisit = now()->diffInRealSeconds($visitor->updated_at);
                $timeSinceLastVisitMinValue = 7200;
                if ($timeSinceLastVisit > $timeSinceLastVisitMinValue) {
                    Visitor::create((array)$currentUserInfo);
                }
            } else {
                Visitor::create((array)$currentUserInfo);
            }
        }
        return $next($request);
    }
}
