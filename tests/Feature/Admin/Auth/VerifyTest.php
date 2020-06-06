<?php

namespace Tests\Feature\Admin\Auth;

use App\Administrator;
use Tests\TestCase;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class VerifyTest extends TestCase
{
    use RefreshDatabase;

    private $routeNamePrefix;

    protected function setUp(): void
    {
        parent::setUp();

        $this->routeNamePrefix = config('admin.base.route_name_prefix');
    }

    /** @test */
    public function can_view_verification_page()
    {
        $user = factory(Administrator::class)->create([
            'email_verified_at' => null,
        ]);

        Auth::guard('admin')->login($user);

        $this->get(route($this->routeNamePrefix . '.verification.notice'))
            ->assertSuccessful()
            ->assertSeeLivewire($this->routeNamePrefix . '.auth.verify');
    }

    /** @test */
    public function can_resend_verification_email()
    {
        $user = factory(Administrator::class)->create();

        Livewire::actingAs($user);

        Livewire::test('admin.auth.verify')
            ->call('resend')
            ->assertEmitted('resent');
    }

    /** @test */
    public function can_verify()
    {
        $user = factory(Administrator::class)->create([
            'email_verified_at' => null,
        ]);

        Auth::guard('admin')->login($user);

        $url = URL::temporarySignedRoute($this->routeNamePrefix . '.verification.verify', Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)), [
            'id' => $user->getKey(),
            'hash' => sha1($user->getEmailForVerification()),
        ]);

        $this->get($url)
            ->assertRedirect(route($this->routeNamePrefix . '.home'));

        $this->assertTrue($user->hasVerifiedEmail());
    }
}
