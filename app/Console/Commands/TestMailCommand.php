<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestMailCommand extends Command
{
    protected $signature = 'mail:test {email}';
    protected $description = 'Test email sending';

    public function handle()
    {
        $email = $this->argument('email');
        $this->info("Šaljem test mail na: {$email}...");

        try {
            Mail::raw('Ovo je test mail od Gym Portal. Ako primate ovo, SMTP konfiguracija radi.', function ($m) use ($email) {
                $m->to($email)->subject('Test - Gym Portal');
            });
            $this->info('Mail uspješno poslan!');
        } catch (\Exception $e) {
            $this->error('Greška: ' . $e->getMessage());
        }

        return 0;
    }
}
