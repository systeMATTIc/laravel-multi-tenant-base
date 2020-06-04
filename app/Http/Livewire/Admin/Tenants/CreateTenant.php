<?php

namespace App\Http\Livewire\Admin\Tenants;

use App\Events\TenantWasCreated;
use App\Tenant;
use App\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Illuminate\Support\Str;

class CreateTenant extends Component
{
    use AuthorizesRequests;

    /** @var string */
    public $name = '';

    /** @var string */
    public $domain = '';

    /** @var bool */
    public $isFullDomain = false;

    /** @var string */
    public $firstName;

    /** @var string */
    public $lastName;

    /** @var string */
    public $email;

    public function submit()
    {
        $this->authorizeForUser(auth('admin')->user(), 'create-tenant');

        $validTenant = Validator::make(
            [
                'name' => $this->name,
                'domain' => $this->getDomain(),
                'admin_first_name' => $this->firstName,
                'admin_last_name' => $this->lastName,
                'admin_email' => $this->email,
            ],
            [
                'name' => 'required|unique:tenants|min:3',
                'domain' => 'required|unique:tenants|min:3',
                'admin_first_name' => 'required|min:3',
                'admin_last_name' => 'required|min:3',
                'admin_email' => 'required|email',
            ],
        )->validate();

        $this->dispatchBrowserEvent('submitting');

        $tenant = Tenant::query()->create([
            'name' => $validTenant['name'],
            'domain' => $validTenant['domain']
        ]);

        $password = Str::random(10);

        session()->put('tenant_admin.pass', $password);

        $tenantAdmin = User::withoutTenancy()->create([
            'first_name' => $validTenant['admin_first_name'],
            'last_name' => $validTenant['admin_last_name'],
            'email' => $validTenant['admin_email'],
            'password' => Hash::make($password),
            'tenant_id' => $tenant->id
        ]);

        event(new TenantWasCreated($tenant, $tenantAdmin));

        return redirect()->route('admin.tenants.index');
    }

    public function render()
    {
        return view('livewire.admin.tenants.create-tenant');
    }

    private function getDomain()
    {
        if (empty($this->domain)) {
            return null;
        }

        if ($this->isFullDomain) {
            return strtolower($this->domain);
        }

        if (app()->environment('local')) {
            return strtolower($this->domain . '.' . env('LOCAL_APP_BASE_URL'));
        }

        if (app()->environment('staging')) {
            return strtolower($this->domain . '.' . env('STAGING_APP_BASE_URL'));
        }

        if (app()->environment('local')) {
            return strtolower($this->domain . '.' . env('PROD_APP_BASE_URL'));
        }
    }
}
