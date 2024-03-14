<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class KhususJaringan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->RelasiRoles->name != 'jaringan') {
            $role = Auth::user()->RelasiRoles->name;

            switch ($role) {
                case 'admin':
                    return redirect()->route('home');
                    break;
                case 'kepala upt':
                    return redirect()->route('home_kepala_upt');
                    break;
                case 'koordinator':
                    return redirect()->route('home_koordinator');
                    break;
                default:
                    return redirect()->route('login');
            }
        }

        return $next($request);
    }
}
