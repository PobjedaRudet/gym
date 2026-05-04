<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AutoLogoutLongStays extends Command
{
    protected $signature = 'attendance:auto-logout-long-stays';

    protected $description = 'Auto logout members that have been in gym longer than 3 hours';

    public function handle(): int
    {
        $cutoff = Carbon::now()->subHours(3);

        $updated = Attendance::whereNull('out')
            ->where('status', 1)
            ->where('in', '<=', $cutoff)
            ->update([
                'out' => Carbon::now(),
                'status' => 0,
            ]);

        $message = "Auto odjava zavrsena. Broj odjavljenih: {$updated}";
        $this->info($message);
        Log::channel('daily')->info("[AutoLogout] {$message}");

        return self::SUCCESS;
    }
}
