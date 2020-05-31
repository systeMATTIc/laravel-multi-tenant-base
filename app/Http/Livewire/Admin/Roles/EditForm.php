<?php

namespace App\Http\Livewire\Admin\Roles;

use App\Http\Livewire\MapsAbilitiesForRoleEdit;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Silber\Bouncer\Bouncer;
use App\Role;

class EditForm extends Component
{
    use AuthorizesRequests, MapsAbilitiesForRoleEdit;

    public $title;

    public $name;

    public $mappedAbilities;

    public $roleId;

    public function mount($id)
    {
        $this->roleId = $id;
        $this->title = $this->role->title;
        $this->name = $this->role->name;
        $this->mappedAbilities = $this->getMappedAbililites();
    }

    public function submit()
    {
        $this->authorizeForUser(auth('admin')->user(), 'edit-role');

        $validRole = Validator::make(
            [
                'title' => $this->title,
                'name' => $this->name,
            ],
            [
                'title' => ['required', 'min:3', Rule::unique('roles')->whereNull('scope')->ignoreModel($this->role)],
                'name' => ['required', 'min:3', Rule::unique('roles')->whereNull('scope')->ignoreModel($this->role)],
            ]
        )->validate();

        $selectedAbilites = $this->getAllowedAbilitiesFrom($this->mappedAbilities);

        $abilities = collect($this->abilities)->filter(function ($ability) use ($selectedAbilites) {
            return in_array($ability->name, $selectedAbilites);
        });

        $this->role->update(['title' => $validRole['title'], 'name' => $validRole['name']]);

        $this->role->abilities()->detach();

        $this->role->allow($abilities);

        return redirect()->route('admin.roles.index');
    }

    public function getRoleProperty()
    {
        /** @var Bouncer  */
        $bouncer = app(Bouncer::class);

        return $bouncer->role()->with('abilities')->findOrFail(
            $this->roleId
        );
    }

    public function getAbilitiesProperty()
    {
        /** @var Bouncer  */
        $bouncer = app(Bouncer::class);

        return $bouncer->ability()->query()->where([
            'scope' => null
        ])->get();
    }

    public function render()
    {
        return view('livewire.admin.roles.edit-form', [
            'abilities' => $this->abilities
        ]);
    }

    protected function getConfig()
    {
        return config('admin.abilities');
    }
}
