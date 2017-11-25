<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;
use Closure;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
    ];

    public function handle($request, Closure $next)
    {
        if($request->input('token') <=20){

            echo '年龄不能小于20';
            echo '<a href="addUser">点击返回</a>';
            exit;
        }
        return $next($request);
    }
}
