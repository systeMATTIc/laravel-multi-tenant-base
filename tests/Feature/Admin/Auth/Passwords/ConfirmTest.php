<?php

namespace Tests\Feature\Admin\Auth\Passwords;

use App\Administrator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Tests\TestCase;

class ConfirmTest extends TestCase
{
    use RefreshDatabase;

    private $routeNamePrefix;

    protected function setUp(): void
    {
        parent::setUp();

        $this->routeNamePrefix = config('admin.base.route_name_prefix');

        $adminConfirmRoute = $this->routeNamePrefix . '.password.confirm';

        Route::get('/must-be-confirmed', function () {
            return 'You must be confirmed to see this page.';
        })->middleware(['web', "password.confirm:$adminConfirmRoute"]);
    }

    /** @test */
    public function a_user_must_confirm_their_password_before_visiting_a_protected_page()
    {
        $user = factory(Administrator::class)->create();
        $this->be($user, 'admin');

        $this->get('/must-be-confirmed')
            ->assertRedirect(route($this->routeNamePrefix . '.password.confirm'));

        $this->followingRedirects()
            ->get('/must-be-confirmed')
            ->assertSeeLivewire('admin.auth.passwords.confirm');
    }

    /** @test */
    public function a_user_must_enter_a_password_to_confirm_it()
    {
        Livewire::test('admin.auth.passwords.confirm')
            ->call('confirm')
            ->assertHasErrors(['password' => 'required']);
    }

    /** @test */
    public function a_user_must_enter_their_own_password_to_confirm_it()
    {
        $user = factory(Administrator::class)->create([
            'password' => Hash::make('password'),
        ]);

        Livewire::test('admin.auth.passwords.confirm')
            ->set('password', 'not-password')
            ->call('confirm')
            ->assertHasErrors(['password' => 'password']);
    }

    /** @test */
    public function a_user_who_confirms_their_password_will_get_redirected()
    {
        $user = factory(Administrator::class)->create([
            'password' => Hash::make('password'),
        ]);

        $this->be($user, 'admin');

        $this->withSession(['url.intended' => '/must-be-confirmed']);

        Livewire::test('admin.auth.passwords.confirm')
            ->set('password', 'password')
            ->call('confirm')
            ->assertRedirect('/must-be-confirmed');
    }
}
