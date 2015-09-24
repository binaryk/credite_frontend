<?php namespace App\Providers;

use App\Services\InvitationSender;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application as App;

class InvitationSenderProvider extends ServiceProvider {

    public function register() {

        $this->app->bind('App\Services\InvitationSender', function (App $app) {

            $tokens = $app->make('Illuminate\Auth\Passwords\TokenRepositoryInterface');
            $mailer = $app->make('Illuminate\Mail\Mailer');

            return new InvitationSender($tokens, $mailer);
        });
    }
}
