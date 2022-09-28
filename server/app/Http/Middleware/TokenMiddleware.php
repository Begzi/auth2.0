<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\OauthAuthToken;

class TokenMiddleware
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
        // $token = $request->header()['tokenheader'][0];
        if (!(isset($request->header()['tokenheader']))){
            abort(403);
        }
        else{
            $check = OauthAuthToken::where('token', $request->header()['tokenheader'][0])->first();
            $request['token'] = $check;
            if ($check == null){
                abort(402);
            }
        }
        return $next($request);
    }
}

function decToStr($hex)
{
    $string='';
    for ($i=0; $i < count($hex); $i++)
    {
        $string .= chr(($hex[$i]));
    }
    return $string;
}