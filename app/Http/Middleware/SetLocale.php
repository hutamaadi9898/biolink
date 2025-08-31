<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user has locale preference in session
        $locale = $request->session()->get('locale');
        
        // If not in session, check browser language
        if (!$locale) {
            $acceptLanguage = $request->header('Accept-Language');
            
            // Check if Indonesian is preferred
            if ($acceptLanguage && str_contains($acceptLanguage, 'id')) {
                $locale = 'id';
            } else {
                $locale = config('app.locale', 'id');
            }
        }
        
        // Ensure we only use supported locales
        $supportedLocales = ['id', 'en'];
        if (!in_array($locale, $supportedLocales)) {
            $locale = 'id';
        }
        
        App::setLocale($locale);
        
        return $next($request);
    }
}
