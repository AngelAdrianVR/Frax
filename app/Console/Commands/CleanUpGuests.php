<?php

namespace App\Console\Commands;

use App\Models\Guest;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CleanUpGuests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clean-up-guests';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove visitors whose visit_date has passed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            // Obtén la fecha y hora actuales
            $now = Carbon::now();

            // Encuentra y elimina los visitantes cuya fecha de visita ha pasado
            $guestsToDelete = Guest::where('visit_date', '<', $now)->get();

            foreach ($guestsToDelete as $guest) {
                $guest->delete();
            }

        $this->info('Guests cleaned up successfully.');
    
        } catch (\Exception $e) {
            $this->error('Error during cleanup: ' . $e->getMessage());
        }
        
    }
}
