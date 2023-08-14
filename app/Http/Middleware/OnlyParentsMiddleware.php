<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OnlyParentsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // dd($request->user()->hasRole(5));
        if (!$request->user()->current_role_id === 5 || !$request->user()->hasRole('Padre de familia')) {
            Notification::make()
                ->title('Usted ha intentado entrar al portal para padres.')
                ->color('info')
                ->send();

            return redirect()
                ->route('filament.admin.pages.dashboard');
        }
        return $next($request);
    }
}
