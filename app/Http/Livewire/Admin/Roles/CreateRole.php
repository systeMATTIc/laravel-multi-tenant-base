<?php

namespace App\Http\Livewire\Admin\Roles;

use App\Http\Livewire\MapsAbilitiesForRoleCreation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Silber\Bouncer\Bouncer;

class CreateRole extends Component
{
    use AuthorizesRequests, MapsAbilitiesForRoleCreation;

    public $title;

    public $name;

    public $mappedAbilities;

    public function mount()
    {
        $this->mappedAbilities = $this->getMappedAbililites();
    }

    public function submit(Bouncer $bouncer)
    {
        $this->authorizeForUser(auth('admin')->user(), 'create-role');

        $validRole = Validator::make(
            [
                'title' => $this->title,
                'name' => $this->name,
            ],
            [
                'title' => ['required', 'min:3', Rule::unique('roles')->whereNull('scope')],
                'name' => ['required', 'min:3', Rule::unique('roles')->whereNull('scope')],
            ]
        )->validate();

        $selectedAbilites = $this->getAllowedAbilitiesFrom($this->mappedAbilities);

        $abilities = collect($this->abilities)->filter(function ($ability) use ($selectedAbilites) {
            return in_array($ability->name, $selectedAbilites);
        });

        /** @var \Silber\Bouncer\Database\Role */
        $role = $bouncer->role()->query()->create([
            'title' => $validRole['title'],
            'name' => $validRole['name'],
        ]);

        $role->allow($abilities);

        return redirect()->route('admin.roles.index');
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
        return view('livewire.admin.roles.create-role', [
            'abilities' => $this->abilities
        ]);
    }

    protected function getConfig()
    {
        return config('admin.abilities');
    }
}
