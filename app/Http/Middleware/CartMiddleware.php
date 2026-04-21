<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CartMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (!$request->hasCookie('guest_id')) {
            $guestId = (string) Str::uuid();

            $request->cookies->add(['guest_id' => $guestId]);
            $response = $next($request);
            return $response->withCookie(cookie()->forever('guest_id', $guestId));
        }
        return $next($request);
    }
}
