<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('login');
        }
        
        if ($role === 'moniteur' && !Auth::user()->isMoniteur()) {
            return redirect()->route('dashboard')->with('error', 'Accès non autorisé');
        }
        
        if ($role === 'eleve' && !Auth::user()->isEleve()) {
            return redirect()->route('dashboard')->with('error', 'Accès non autorisé');
        }
        
        return $next($request);
    }
}