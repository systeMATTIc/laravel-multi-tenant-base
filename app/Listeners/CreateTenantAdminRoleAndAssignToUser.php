<?php

namespace App\Listeners;

use App\Events\TenantWasCreated;
use App\Notifications\TenantCreated;
use Silber\Bouncer\Bouncer;

class CreateTenantAdminRoleAndAssignToUser
{
    private $bouncer;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Bouncer $bouncer)
    {
        $this->bouncer = $bouncer;
    }

    /**
     * Handle the event.
     *
     * @param  TenantWasCreated  $event
     * @return void
     */
    public function handle(TenantWasCreated $event)
    {
        $role = $this->createAdminRole($event->tenant);

        $event->user->assign($role);

        $event->user->markEmailAsVerified();

        $event->user->notify(new TenantCreated);
    }

    private function createAdminRole($tenant)
    {
        $abilities = $this->createTenantAbilities($tenant);

        return $this->bouncer->scope()->onceTo($tenant->id, function () use ($tenant, $abilities) {
            /** @var \Silber\Bouncer\Database\Role */
            $role = $this->bouncer->role()->query()->create([
                'title' => 'Administrator',
                'name' => 'admin',
                'scope' => $tenant->id
            ]);
            
            $role->allow($abilities);

            return $role;
        });
    }

    private function createTenantAbilities($tenant)
    {
        $abilities = config('abilities');

        return $this->bouncer->scope()->onceTo($tenant->id, function () use ($tenant, $abilities) {
            return collect($abilities)->map(function ($ability) use ($tenant) {
                $ability = array_merge($ability, ['scope' => $tenant->id]);
                return $this->bouncer->ability()->query()->firstOrCreate($ability);
            });
        });
    }
}
