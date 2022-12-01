<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuth
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
        if(auth()->check()){
            if(auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_procesos || auth()->user()->is_ps_encargado || auth()->user()->is_ps_asistente || auth()->user()->is_egresos || auth()->user()->is_contabilidad || auth()->user()->is_estandar || auth()->user()->is_cliente || auth()->user()->is_cliente_ps_asistente || auth()->user()->is_cliente_ps_encargado){
                return $next($request);
            }
        }
        return redirect()->to('/');
    }
}