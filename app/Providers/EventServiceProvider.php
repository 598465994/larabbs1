<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // 发送邮件监听事件
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        // 验证用户邮箱认证事件   \Illuminate\Auth\Events\Verified这个是 事件
        \Illuminate\Auth\Events\Verified::class => [
            // \App\Listeners\EmailVerified 这个是监听器
            \App\Listeners\EmailVerified::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
