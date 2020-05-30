<?php

namespace App\Http\Livewire\Admin\Roles;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Silber\Bouncer\Bouncer;

class CreateForm extends Component
{
    use AuthorizesRequests;

    public $title;

    public $name;

    public $selectedAbilities;

    public function submit(Bouncer $bouncer)
    {
        $this->authorizeForUser(auth('admin')->user(), 'create-role');

        $validRole = Validator::make(
            [
                'title' => $this->title,
                'name' => $this->name,
                'abilities' => $this->selectedAbilities
            ],
            [
                'title' => ['required', 'min:3', Rule::unique('roles')->whereNull('scope')],
                'name' => ['required', 'min:3', Rule::unique('roles')->whereNull('scope')],
                'abilities' => 'required|array|min:1'
            ]
        )->validate();

        /** @var \Silber\Bouncer\Database\Role */
        $role = $bouncer->role()->query()->create([
            'title' => $this->title,
            'name' => $this->name
        ]);

        $abilities = collect($this->abilities)->filter(function ($ability) use ($validRole) {
            return in_array($ability->id, $validRole['abilities']);
        });

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
        return view('livewire.admin.roles.create-form', [
            'abilities' => $this->abilities
        ]);
    }
}
