<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecordLastVisitedPage
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && !$request->is('logout') && !$request->ajax()) {
            session(['last_visited_page' => $request->fullUrl()]);
        }

        return $next($request);
    }
}
