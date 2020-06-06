<?php

namespace Tests\Feature\Admin\Auth;

use App\Administrator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    private $routeNamePrefix;

    protected function setUp(): void
    {
        parent::setUp();

        $this->routeNamePrefix = config('admin.base.route_name_prefix');
    }

    /** @test */
    public function can_view_login_page()
    {
        $this->get(route($this->routeNamePrefix . '.login'))
            ->assertSuccessful()
            ->assertSeeLivewire('admin.auth.login');
    }

    /** @test */
    public function is_redirected_if_already_logged_in()
    {
        $user = factory(Administrator::class)->create();

        $this->be($user, 'admin');

        $this->get(route($this->routeNamePrefix . '.login'))
            ->assertRedirect(route($this->routeNamePrefix . '.home'));
    }

    /** @test */
    public function a_user_can_login()
    {
        $user = factory(Administrator::class)->create(['password' => Hash::make('password')]);

        Livewire::test('admin.auth.login')
            ->set('email', $user->email)
            ->set('password', 'password')
            ->call('authenticate');

        $this->assertAuthenticatedAs($user, 'admin');
    }

    /** @test */
    public function is_redirected_to_the_home_page_after_login()
    {
        $user = factory(Administrator::class)->create(['password' => Hash::make('password')]);

        Livewire::test('admin.auth.login')
            ->set('email', $user->email)
            ->set('password', 'password')
            ->call('authenticate')
            ->assertRedirect(route($this->routeNamePrefix . '.home'));
    }

    /** @test */
    public function email_is_required()
    {
        $user = factory(Administrator::class)->create(['password' => Hash::make('password')]);

        Livewire::test('admin.auth.login')
            ->set('password', 'password')
            ->call('authenticate')
            ->assertHasErrors(['email' => 'required']);
    }

    /** @test */
    public function email_must_be_valid_email()
    {
        $user = factory(Administrator::class)->create(['password' => Hash::make('password')]);

        Livewire::test('admin.auth.login')
            ->set('email', 'invalid-email')
            ->set('password', 'password')
            ->call('authenticate')
            ->assertHasErrors(['email' => 'email']);
    }

    /** @test */
    public function password_is_required()
    {
        $user = factory(Administrator::class)->create(['password' => Hash::make('password')]);

        Livewire::test('admin.auth.login')
            ->set('email', $user->email)
            ->call('authenticate')
            ->assertHasErrors(['password' => 'required']);
    }

    /** @test */
    public function bad_login_attempt_shows_message()
    {
        $user = factory(Administrator::class)->create();

        Livewire::test('admin.auth.login')
            ->set('email', $user->email)
            ->set('password', 'bad-password')
            ->call('authenticate')
            ->assertHasErrors('email');

        $this->assertFalse(Auth::check());
    }
}
