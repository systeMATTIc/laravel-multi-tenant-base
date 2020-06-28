<?php

namespace App\Console\Commands;

use App\Administrator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Silber\Bouncer\Bouncer;

class InstallBaseApplication extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets up the base application for first time use';

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
        if (Schema::hasTable("administrators") && Administrator::all()->isNotEmpty()) {
            return $this->line("App Already Installed");
        }

        $this->info("Preparing to Install...\n");

        $this->info("Running Database Migrations...\n");
        Artisan::call('migrate');
        $this->info("Migrations Complete \n");

        $this->info("Populating Administrative Abilites... \n");
        Artisan::call("admin:create-abilities");
        $this->info("Abilities populated successfully \n");

        $this->info("Creating Admin Role... \n");

        /** @var \Silber\Bouncer\Database\Role */
        $adminRole = $bouncer->role()->query()->where([
            'name' => 'admin',
            'scope' => null
        ])->first();

        if (is_null($adminRole)) {

            /** @var \Silber\Bouncer\Database\Role */
            $role = $bouncer->role()->query()->create([
                'title' => 'Administrator',
                'name' => 'admin'
            ]);
        } else {
            $role = $adminRole;
        }

        $abilities = $bouncer->ability()->all();
        $role->allow($abilities);

        $this->info("Admin Role Created Successfully... \n \n");

        $this->info("Now, let's create yout first login account. \n");

        $firstName = $this->ask("Enter First Name", 'Opeyemi');
        $lastName = $this->ask("Enter Last Name", 'Matti');
        $email = $this->ask("Enter your email", 'matti.opeyemi@base.com');
        $password = $this->ask("Provide a password", "secret");

        /** @var \App\Administrator */
        $admin = Administrator::query()->create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'password' => Hash::make($password),
            'is_super' => true
        ]);

        $admin->assign($role);

        $this->line("Admin User Created Successfully!!!\n");

        $this->line("Visit the login page to access the application");
    }
}
