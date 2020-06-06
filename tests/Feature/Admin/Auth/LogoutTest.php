<?php

namespace Tests\Feature\Admin\Auth;

use App\Administrator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    private $routeNamePrefix;

    protected function setUp(): void
    {
        parent::setUp();

        $this->routeNamePrefix = config('admin.base.route_name_prefix');
    }

    /** @test */
    public function an_authenticated_user_can_log_out()
    {
        $user = factory(Administrator::class)->create();
        $this->be($user);

        $this->post(route($this->routeNamePrefix . '.logout'))
            ->assertRedirect(route($this->routeNamePrefix . '.login'));

        $this->assertFalse(Auth::guard('admin')->check());
    }

    /** @test */
    public function an_unauthenticated_user_can_not_log_out()
    {
        $this->post(route($this->routeNamePrefix . '.logout'))
            ->assertRedirect(route($this->routeNamePrefix . '.login'));

        $this->assertFalse(Auth::check());
    }
}
