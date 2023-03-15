<?php

namespace App\Providers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;

class MailServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (app()->isLocal()) {
            Mail::alwaysTo(
                config('mail.to.address'),
                config('mail.to.name')
            );
        }
    }
}
