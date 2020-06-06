<?php

namespace Tests\Feature\Admin;

use App\Administrator;
use App\Events\TenantWasCreated;
use App\Http\Livewire\Admin\Tenants\CreateTenant;
use App\Notifications\TenantCreated;
use App\Role;
use App\Tenant;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use Tests\TestCase;

class CreateTenantTest extends TestCase
{
    use RefreshDatabase;

    public function testItCreatesTenant()
    {
        $admin = factory(Administrator::class)->create();
        $admin->allow(['create-tenant', 'view-tenant-list']);
        $this->actingAs($admin, 'admin');

        $adminBasePrefix = config('admin.base.route_prefix');

        Livewire::test(CreateTenant::class)
            ->set('name', 'just')
            ->set('domain', 'just.localhost')
            ->set('isFullDomain', true)
            ->set('firstName', 'Opeyemi')
            ->set('lastName', 'Matti')
            ->set('email', 'articulz@gmail.com')
            ->call('submit')
            ->assertRedirect("/$adminBasePrefix/tenants");

        $tenant = Tenant::whereName('just')->first();

        $this->assertNotNull($tenant);
    }

    public function testItCreatesAdminUserForTenant()
    {
        Event::fake();

        $admin = factory(Administrator::class)->create();
        $admin->allow(['create-tenant', 'view-tenant-list']);
        $this->actingAs($admin, 'admin');

        Livewire::test(CreateTenant::class)
            ->set('name', 'just')
            ->set('domain', 'just.localhost')
            ->set('isFullDomain', true)
            ->set('firstName', 'Opeyemi')
            ->set('lastName', 'Matti')
            ->set('email', 'articulz@gmail.com')
            ->call('submit');

        $tenant = Tenant::whereName('just')->first();
        $tenantAdmin = User::whereFirstName('Opeyemi')->first();

        $this->assertNotNull($tenantAdmin);

        $this->assertEquals($tenant->id, $tenantAdmin->tenant_id);

        Event::assertDispatched(TenantWasCreated::class);
    }

    public function testItAssignsAdminRoleToTenantAdmin()
    {
        $admin = factory(Administrator::class)->create();
        $admin->allow(['create-tenant', 'view-tenant-list']);
        $this->actingAs($admin, 'admin');

        Livewire::test(CreateTenant::class)
            ->set('name', 'just')
            ->set('domain', 'just.localhost')
            ->set('isFullDomain', true)
            ->set('firstName', 'Opeyemi')
            ->set('lastName', 'Matti')
            ->set('email', 'articulz@gmail.com')
            ->call('submit');

        $tenantAdmin = User::whereFirstName('Opeyemi')->first();
        $tenant = Tenant::whereName('just')->first();

        $role = Role::query()->whereScope($tenant->id)->first();

        $this->assertEquals($role->name, 'admin');

        $this->assertTrue($tenantAdmin->isAn('admin'));

        $this->assertContains('edit-user', $tenantAdmin->getAbilities()->pluck('name'));
    }

    public function testItVerifiesTenantAdmin()
    {
        $admin = factory(Administrator::class)->create();
        $admin->allow(['create-tenant', 'view-tenant-list']);
        $this->actingAs($admin, 'admin');

        Livewire::test(CreateTenant::class)
            ->set('name', 'just')
            ->set('domain', 'just.localhost')
            ->set('isFullDomain', true)
            ->set('firstName', 'Opeyemi')
            ->set('lastName', 'Matti')
            ->set('email', 'articulz@gmail.com')
            ->call('submit');

        $tenantAdmin = User::whereFirstName('Opeyemi')->first();

        $this->assertTrue($tenantAdmin->hasVerifiedEmail());
    }

    public function testItNotifiesTenantAdmin()
    {
        Notification::fake();

        $admin = factory(Administrator::class)->create();
        $admin->allow(['create-tenant', 'view-tenant-list']);
        $this->actingAs($admin, 'admin');

        Livewire::test(CreateTenant::class)
            ->set('name', 'just')
            ->set('domain', 'just.localhost')
            ->set('isFullDomain', true)
            ->set('firstName', 'Opeyemi')
            ->set('lastName', 'Matti')
            ->set('email', 'articulz@gmail.com')
            ->call('submit');

        $tenantAdmin = User::whereFirstName('Opeyemi')->first();

        Notification::assertSentTo($tenantAdmin, TenantCreated::class);
    }
}
