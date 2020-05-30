<?php

namespace App\Http\Livewire\Roles;

use App\Tenant;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
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
        $this->authorizeForUser(auth()->user(), 'create-role');

        $validRole = Validator::make(
            [
                'title' => $this->title,
                'name' => $this->name,
                'abilities' => $this->selectedAbilities
            ],
            [
                'title' => ['required', 'min:3', Tenant::uniqueRule('roles', 'title', 'scope')],
                'name' => ['required', 'min:3', Tenant::uniqueRule('roles', 'name', 'scope')],
                'abilities' => 'required|array|min:1'
            ]
        )->validate();

        $abilities = collect($this->abilities)->filter(function ($ability) use ($validRole) {
            return in_array($ability->id, $validRole['abilities']);
        });
        // dd($abilities);
        $bouncer->scope()->onceTo(tenant()->id, function () use ($bouncer, $abilities) {
            /** @var \Silber\Bouncer\Database\Role */
            $role = $bouncer->role()->query()->create([
                'title' => $this->title,
                'name' => $this->name,
                'scope' => tenant()->id
            ]);

            $role->allow($abilities);
        });

        return redirect()->route('roles.index');
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
        return view('livewire.roles.create-form', [
            'abilities' => $this->abilities
        ]);
    }
}
