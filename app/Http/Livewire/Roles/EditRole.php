<?php

namespace App\Http\Livewire\Roles;

use App\Http\Livewire\MapsAbilitiesForRoleEdit;
use App\Tenant;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Silber\Bouncer\Bouncer;

class EditRole extends Component
{
    use AuthorizesRequests, MapsAbilitiesForRoleEdit;

    public $title;

    public $name;

    public $roleId;

    public $mappedAbilities;

    public function mount($id)
    {
        $this->roleId = $id;
        $this->title = $this->role->title;
        $this->name = $this->role->name;
        $this->mappedAbilities = $this->getMappedAbililites();
    }

    public function submit()
    {
        $this->authorizeForUser(auth()->user(), 'edit-role');

        $validRole = Validator::make(
            [
                'title' => $this->title,
                'name' => $this->name,
            ],
            [
                'title' => ['required', 'min:3', Tenant::uniqueRule('roles', 'title', 'scope')->ignoreModel($this->role)],
                'name' => ['required', 'min:3', Tenant::uniqueRule('roles', 'name', 'scope')->ignoreModel($this->role)],
            ]
        )->validate();

        $selectedAbilites = $this->getAllowedAbilitiesFrom($this->mappedAbilities);

        $abilities = collect($this->abilities)->filter(function ($ability) use ($selectedAbilites) {
            return in_array($ability->name, $selectedAbilites);
        });


        $this->role->update(['title' => $validRole['title'], 'name' => $validRole['name']]);

        /** @var \Silber\Bouncer\Bouncer */
        $bouncer = app(Bouncer::class);

        $bouncer->scope()->onceTo(tenant()->id, function () use ($abilities) {
            $this->role->abilities()->detach();
            $this->role->allow($abilities->values());
        });

        return redirect()->route('roles.index');
    }

    public function getRoleProperty()
    {
        /** @var Bouncer  */
        $bouncer = app(Bouncer::class);

        try {
            return $bouncer->role()->with('abilities')
                ->where(['scope' => tenant()->id])
                ->findOrFail($this->roleId);
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function getAbilitiesProperty()
    {
        /** @var Bouncer  */
        $bouncer = app(Bouncer::class);

        return $bouncer->ability()->query()->where([
            'scope' => tenant()->id
        ])->get();
    }

    public function render()
    {
        return view('livewire.roles.edit-role', [
            'abilities' => $this->abilities
        ]);
    }

    protected function getConfig()
    {
        return config('abilities');
    }
}
