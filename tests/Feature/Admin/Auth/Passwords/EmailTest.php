<?php

namespace Tests\Feature\Admin\Auth\Passwords;

use App\Administrator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class EmailTest extends TestCase
{
    use RefreshDatabase;

    private $routeNamePrefix;

    protected function setUp(): void
    {
        parent::setUp();

        $this->routeNamePrefix = config('admin.base.route_name_prefix');
    }

    /** @test */
    public function can_view_password_request_page()
    {
        $this->get(route($this->routeNamePrefix . '.password.request'))
            ->assertSuccessful()
            ->assertSeeLivewire('admin.auth.passwords.email');
    }

    /** @test */
    public function a_user_must_enter_an_email_address()
    {
        Livewire::test('admin.auth.passwords.email')
            ->call('sendResetPasswordLink')
            ->assertHasErrors(['email' => 'required']);
    }

    /** @test */
    public function a_user_must_enter_a_valid_email_address()
    {
        Livewire::test('admin.auth.passwords.email')
            ->set('email', 'email')
            ->call('sendResetPasswordLink')
            ->assertHasErrors(['email' => 'email']);
    }

    /** @test */
    public function a_user_who_enters_a_valid_email_address_will_get_sent_an_email()
    {
        $user = factory(Administrator::class)->create();

        Livewire::test('admin.auth.passwords.email')
            ->set('email', $user->email)
            ->call('sendResetPasswordLink')
            ->assertNotSet('emailSentMessage', false);

        $this->assertDatabaseHas('password_resets', [
            'email' => $user->email,
        ]);
    }
}
