<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class hasVerifyEmail
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Session::has('pending_email')){
            return redirect()->route('verify.email')->with('echec', 'veuillez verifier cotre email');
        }
        return $next($request);
    }
}
