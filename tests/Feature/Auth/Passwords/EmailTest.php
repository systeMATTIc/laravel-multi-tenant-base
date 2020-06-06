<?php

namespace Tests\Feature\Auth\Passwords;

use App\Tenant;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class EmailTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $tenant = factory(Tenant::class)->create();
        $tenant->makeCurrent();
    }

    /** @test */
    public function can_view_password_request_page()
    {
        $this->get(route('password.request'))
            ->assertSuccessful()
            ->assertSeeLivewire('auth.passwords.email');
    }

    /** @test */
    public function a_user_must_enter_an_email_address()
    {
        Livewire::test('auth.passwords.email')
            ->call('sendResetPasswordLink')
            ->assertHasErrors(['email' => 'required']);
    }

    /** @test */
    public function a_user_must_enter_a_valid_email_address()
    {
        Livewire::test('auth.passwords.email')
            ->set('email', 'email')
            ->call('sendResetPasswordLink')
            ->assertHasErrors(['email' => 'email']);
    }

    /** @test */
    public function a_user_who_enters_a_valid_email_address_will_get_sent_an_email()
    {
        $user = factory(User::class)->create();

        Livewire::test('auth.passwords.email')
            ->set('email', $user->email)
            ->call('sendResetPasswordLink')
            ->assertNotSet('emailSentMessage', false);

        $this->assertDatabaseHas('password_resets', [
            'email' => $user->email,
        ]);
    }
}
