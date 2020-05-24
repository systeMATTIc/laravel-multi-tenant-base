<?php

namespace App\Http\Livewire\Admin\Tenants;

use App\Tenant;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Create extends Component
{
    use AuthorizesRequests;

    /** @var string */
    public $name = '';

    /** @var string */
    public $domain = '';

    /** @var bool */
    public $isFullDomain = false;

    public function submit()
    {
        $this->authorizeForUser(auth('admin')->user(), 'create-tenant');

        $validTenant = Validator::make(
            ['name' => $this->name, 'domain' => $this->getDomain()],
            ['name' => 'required|unique:tenants|min:3', 'domain' => 'required|unique:tenants|min:3'],
        )->validate();

        Tenant::query()->create($validTenant);

        return redirect()->route('admin.tenants.index');
    }

    public function render()
    {
        return view('livewire.admin.tenants.create');
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
