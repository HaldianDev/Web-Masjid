<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecureHeaders
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Click‑jacking protection
        $response->headers->set('X-Frame-Options', 'DENY');
        // XSS protection (legacy browsers)
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        // MIME sniffing protection
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        // Enforce HTTPS (HSTS)
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        // Content Security Policy – adjust sources as needed
        $csp = "default-src 'self'; " .
               "script-src 'self' https://cdn.jsdelivr.net; " .
               "style-src  'self' 'unsafe-inline' https://fonts.googleapis.com; " .
               "img-src    'self' data:; " .
               "font-src   'self' https://fonts.gstatic.com; " .
               "connect-src 'self'; " .
               "frame-ancestors 'none'; " .
               "base-uri 'self'; " .
               "form-action 'self'";
        $response->headers->set('Content-Security-Policy', $csp);
        // Referrer policy
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        // Permissions Policy – disable risky features
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');

        return $response;
    }
}
?>
