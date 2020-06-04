<?php

namespace App\Http\Livewire\Admin\Tenants;

use App\Tenant;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Livewire\Component;

class EditTenant extends Component
{
    use AuthorizesRequests;

    /** @var string */
    public $name = '';

    /** @var string */
    public $domain = '';

    public $tenantUuid;

    public function mount($uuid)
    {
        $this->tenantUuid = $uuid;

        $this->name = $this->tenant->name;

        $this->domain = $this->tenant->domain;
    }

    public function submit()
    {
        $this->authorizeForUser(auth('admin')->user(), 'edit-tenant');

        $validTenant = $this->validate([
            'name' => ['required', 'min:3', Rule::unique('tenants')->ignoreModel($this->tenant)],
            'domain' => ['required', 'min:3', Rule::unique('tenants')->ignoreModel($this->tenant)],
        ]);

        $this->tenant->update($validTenant);

        return redirect()->route('admin.tenants.index');
    }

    public function getTenantProperty()
    {
        return Tenant::query()->whereUuid(
            $this->tenantUuid
        )->first();
    }

    public function render()
    {
        return view('livewire.admin.tenants.edit-tenant');
    }
}
