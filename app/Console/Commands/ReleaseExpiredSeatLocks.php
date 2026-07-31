<?php

namespace App\Console\Commands;

use App\Models\SeatAvailability;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

#[Signature('app:release-expired-seat-locks')]
#[Description('Release expired seat locks and make them available again')]
class ReleaseExpiredSeatLocks extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Releasing expired seat locks...');

        try {
            $released = SeatAvailability::releaseExpiredLocks();

            $this->info("Released {$released} expired seat locks.");

            if ($released > 0) {
                $this->info('Cache cleared for seat availability.');
            } else {
                $this->info('No expired locks found.');
            }

            return 0;
        } catch (\Exception $e) {
            $this->error('Error releasing expired seat locks: ' . $e->getMessage());
            return 1;
        }
    }
}
