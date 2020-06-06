<?php

namespace Tests\Feature\Admin\Auth;

use App\Administrator;
use Tests\TestCase;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    private $routeNamePrefix;

    protected function setUp(): void
    {
        parent::setUp();

        $this->routeNamePrefix = config('admin.base.route_name_prefix');
    }

    /** @test */
    function registration_page_contains_livewire_component()
    {
        $this->get(route($this->routeNamePrefix . '.register'))
            ->assertSuccessful()
            ->assertSeeLivewire('admin.auth.register');
    }

    /** @test */
    public function is_redirected_if_already_logged_in()
    {
        $user = factory(Administrator::class)->create();

        $this->be($user, 'admin');

        $this->get(route($this->routeNamePrefix . '.register'))
            ->assertRedirect(route($this->routeNamePrefix . '.home'));
    }

    /** @test */
    function a_user_can_register()
    {
        Livewire::test('admin.auth.register')
            ->set('firstName', 'Tall')
            ->set('lastName', 'Stack')
            ->set('email', 'tallstack@example.com')
            ->set('password', 'password')
            ->set('passwordConfirmation', 'password')
            ->call('register')
            ->assertRedirect(route($this->routeNamePrefix . '.home'));

        $this->assertTrue(Administrator::whereEmail('tallstack@example.com')->exists());
        $this->assertEquals('tallstack@example.com', Auth::user()->email);
    }

    /** @test */
    function first_name_is_required()
    {
        Livewire::test('admin.auth.register')
            ->set('firstName', '')
            ->call('register')
            ->assertHasErrors(['firstName' => 'required']);
    }

    /** @test */
    function last_name_is_required()
    {
        Livewire::test('admin.auth.register')
            ->set('lastName', '')
            ->call('register')
            ->assertHasErrors(['lastName' => 'required']);
    }

    /** @test */
    function email_is_required()
    {
        Livewire::test('admin.auth.register')
            ->set('email', '')
            ->call('register')
            ->assertHasErrors(['email' => 'required']);
    }

    /** @test */
    function email_is_valid_email()
    {
        Livewire::test('admin.auth.register')
            ->set('email', 'tallstack')
            ->call('register')
            ->assertHasErrors(['email' => 'email']);
    }

    /** @test */
    function email_hasnt_been_taken_already()
    {
        factory(Administrator::class)->create(['email' => 'tallstack@example.com']);

        Livewire::test('admin.auth.register')
            ->set('email', 'tallstack@example.com')
            ->call('register')
            ->assertHasErrors(['email' => 'unique']);
    }

    /** @test */
    function see_email_hasnt_already_been_taken_validation_message_as_user_types()
    {
        factory(Administrator::class)->create(['email' => 'tallstack@example.com']);

        Livewire::test('admin.auth.register')
            ->set('email', 'smallstack@gmail.com')
            ->assertHasNoErrors()
            ->set('email', 'tallstack@example.com')
            ->call('register')
            ->assertHasErrors(['email' => 'unique']);
    }

    /** @test */
    function password_is_required()
    {
        Livewire::test('admin.auth.register')
            ->set('password', '')
            ->set('passwordConfirmation', 'password')
            ->call('register')
            ->assertHasErrors(['password' => 'required']);
    }

    /** @test */
    function password_is_minimum_of_eight_characters()
    {
        Livewire::test('admin.auth.register')
            ->set('password', 'secret')
            ->set('passwordConfirmation', 'secret')
            ->call('register')
            ->assertHasErrors(['password' => 'min']);
    }

    /** @test */
    function password_matches_password_confirmation()
    {
        Livewire::test('admin.auth.register')
            ->set('email', 'tallstack@example.com')
            ->set('password', 'password')
            ->set('passwordConfirmation', 'not-password')
            ->call('register')
            ->assertHasErrors(['password' => 'same']);
    }
}
