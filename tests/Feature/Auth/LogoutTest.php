<?php

namespace Tests\Feature\Auth;

use App\Tenant;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $tenant = factory(Tenant::class)->create();
        $tenant->makeCurrent();
    }

    /** @test */
    public function an_authenticated_user_can_log_out()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $this->post(route('logout'))
            ->assertRedirect(route('home'));

        $this->assertFalse(Auth::check());
    }

    /** @test */
    public function an_unauthenticated_user_can_not_log_out()
    {
        $this->post(route('logout'))
            ->assertRedirect(route('login'));

        $this->assertFalse(Auth::check());
    }
}
