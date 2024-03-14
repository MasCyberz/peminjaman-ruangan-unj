<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class KhususKoordinator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::user()->RelasiRoles->name != 'koordinator') {
            $role = Auth::user()->RelasiRoles->name;

            switch ($role) {
                case 'admin':
                    return redirect()->route('home');
                    break;
                case 'jaringan':
                    return redirect()->route('home_jaringan');
                    break;
                case 'kepala upt':
                    return redirect()->route('home_kepala_upt');
                    break;
                default:
                    return redirect()->route('login');
            }
        }

        return $next($request);
    }
}
