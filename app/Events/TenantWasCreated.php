<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class TenantWasCreated
{
    use SerializesModels;

    /**
     * The newly created tenant
     * 
     * @var \App\Tenant
     */
    public $tenant;

    /**
     * The tenant's administrator
     * 
     * @var \App\User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($tenant, $user)
    {
        $this->tenant = $tenant;

        $this->user = $user;
    }
}
