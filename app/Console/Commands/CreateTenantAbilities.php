<?php

namespace App\Console\Commands;

use App\Tenant;
use Illuminate\Console\Command;
use Silber\Bouncer\Bouncer;

class CreateTenantAbilities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenants:create-abilities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populates abilities for tenants';

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

        $abilities = config('abilities');

        Tenant::all()->each(function ($tenant) use ($bouncer, $abilities) {
            $bouncer->scope()->onceTo($tenant->id, function () use ($tenant, $abilities, $bouncer) {
                collect($abilities)->each(function ($ability) use ($tenant, $bouncer) {
                    $ability = array_merge($ability, ['scope' => $tenant->id]);
                    $bouncer->ability()->query()->firstOrCreate($ability);
                });
            });
        });

        $this->info("Abilities populated successfully");
    }
}
