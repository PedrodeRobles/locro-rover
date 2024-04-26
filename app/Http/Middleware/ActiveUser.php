<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ActiveUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if($user->active === 1) {
            return $next($request);
        }

        // dd('No eres un usuario activo. Si eres un Rover actual pidele al administrador que active tu cuenta');
        return redirect()->route('guest')->with('error', 'No tienes permiso para acceder a esta página.');
    }
}
