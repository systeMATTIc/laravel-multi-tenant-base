<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Silber\Bouncer\Bouncer;

class CreateAdminAbilities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create-abilities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populates abilities for admin';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Bouncer $bouncer)
    {
        $this->info("Preparing abilities...");

        $abilities = config('admin.abilities');

        collect($abilities)->each(function ($ability) use ($bouncer) {
            $bouncer->ability()->query()->firstOrCreate($ability);
        });

        $this->info("Abilities populated successfully");
    }
}
