<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {


        // 三个判断
        // 1.如果用户已经登录
        // 2.并且还为认证邮箱
        // 3.并且访问的不是邮箱验证的相关url 或者 退出的 url
        if ($request->user()
            && ! $request->user()->hasVerifiedEmail()
            && ! $request->is('email/*', 'logout')) {

            // 根据客户端返回对应的内容
            return $request->expectsJson()
                        ? abort(403, 'Your email address is not verified.')
                        : redirect()->route('verification.notice');

        }


        return $next($request);
    }
}
