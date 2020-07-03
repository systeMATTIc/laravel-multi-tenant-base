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

    /** @var string */
    public $phoneNo;

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
                'phone_no' => $this->phoneNo,
                'admin_first_name' => $this->firstName,
                'admin_last_name' => $this->lastName,
                'admin_email' => $this->email,
            ],
            [
                'name' => 'required|unique:tenants|min:3',
                'domain' => 'required|unique:tenants|min:3',
                'phone_no' => 'required|size:11|phone:NG,mobile|unique:tenants', // may have to account for different countries in the future
                'admin_first_name' => 'required|min:3',
                'admin_last_name' => 'required|min:3',
                'admin_email' => 'required|email',
            ],
        )->validate();

        $this->dispatchBrowserEvent('submitting');

        $tenant = Tenant::query()->create([
            'name' => $validTenant['name'],
            'domain' => $validTenant['domain'],
            'phone_no' => $validTenant['phone_no']
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

        $suffix = env('TENANT_SUBDOMAIN_SUFFIX');
        $baseUrl = env('BASE_URL');

        if (Str::contains($this->domain, ["-" . $suffix, $baseUrl])) {
            return strtolower($this->domain);
        }

        if (!(bool) env('TENANT_SUBDOMAIN')) {
            return strtolower($this->domain);
        }

        if (empty($suffix)) {
            return strtolower($this->domain . '.' . $baseUrl ?? 'localhost');
        }

        return strtolower($this->domain . '-' . $suffix . '.' . $baseUrl ?? 'localhost');
    }
}
