<?php

namespace App\Http\Livewire\Admin\Tenants;

use App\Tenant;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Illuminate\Support\Str;


class EditTenant extends Component
{
    use AuthorizesRequests;

    /** @var string */
    public $name = '';

    /** @var string */
    public $domain = '';

    public $phoneNo;

    public $tenantUuid;

    public function mount($uuid)
    {
        $this->tenantUuid = $uuid;

        $this->name = $this->tenant->name;

        $this->domain = $this->tenant->domain;

        $this->phoneNo = $this->tenant->phone_no;
    }

    public function submit()
    {
        $this->authorizeForUser(auth('admin')->user(), 'edit-tenant');

        $validTenant = Validator::make(
            [
                'name' => $this->name,
                'domain' => $this->getDomain(),
                'phone_no' => $this->phoneNo
            ],
            [
                'name' => ['required', 'min:3', Rule::unique('tenants')->ignoreModel($this->tenant)],
                'domain' => ['required', 'min:3', Rule::unique('tenants')->ignoreModel($this->tenant)],
                'phone_no' => ['required', 'size:11', 'phone:NG,mobile', Rule::unique('tenants')->ignoreModel($this->tenant)],
            ]
        )->validate();

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
