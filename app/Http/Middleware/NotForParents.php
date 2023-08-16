<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NotForParents
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->current_role_id != 5 || $request->user()->hasAllRoles())
            return $next($request);
        else {
            Notification::make()
                ->title('No tiene permisos para entrar a este portal.')
                ->danger()
                ->send();

            return redirect()
                ->route('filament.parents.pages.dashboard');
        }
    }
}
