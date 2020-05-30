<?php

namespace App\Http\Livewire\Roles;

use App\Tenant;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Silber\Bouncer\Bouncer;
use Silber\Bouncer\Database\Role;

class EditForm extends Component
{
    use AuthorizesRequests;

    public $title;

    public $name;

    public $selectedAbilities;

    public $roleId;

    public function mount($id)
    {
        $this->roleId = $id;
        $this->title = $this->role->title;
        $this->name = $this->role->name;
        $this->selectedAbilities = $this->role->getAbilities()->pluck('id')->toArray();
    }

    public function submit()
    {
        $this->authorizeForUser(auth()->user(), 'edit-role');

        $validRole = Validator::make(
            [
                'title' => $this->title,
                'name' => $this->name,
                'abilities' => $this->selectedAbilities
            ],
            [
                'title' => ['required', 'min:3', Tenant::uniqueRule('roles', 'title', 'scope')->ignoreModel($this->role)],
                'name' => ['required', 'min:3', Tenant::uniqueRule('roles', 'name', 'scope')->ignoreModel($this->role)],
                'abilities' => 'required|array|min:1'
            ]
        )->validate();

        $abilities = collect($this->abilities)->filter(function ($ability) use ($validRole) {
            return in_array($ability->id, $validRole['abilities']);
        });

        $this->role->update(['title' => $this->title, 'name' => $this->name]);

        /** @var \Silber\Bouncer\Bouncer */
        $bouncer = app(Bouncer::class);

        $bouncer->scope()->onceTo(tenant()->id, function () use ($abilities) {
            $this->role->abilities()->detach();
            $this->role->allow($abilities);
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
        return view('livewire.roles.edit-form', [
            'abilities' => $this->abilities
        ]);
    }
}
