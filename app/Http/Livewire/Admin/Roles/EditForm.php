<?php

namespace App\Http\Livewire\Admin\Roles;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Silber\Bouncer\Bouncer;
use App\Role;

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
        $this->authorizeForUser(auth('admin')->user(), 'edit-role');

        $validRole = Validator::make(
            [
                'title' => $this->title,
                'name' => $this->name,
                'abilities' => $this->selectedAbilities
            ],
            [
                'title' => ['required', 'min:3', Rule::unique('roles')->whereNull('scope')->ignoreModel($this->role)],
                'name' => ['required', 'min:3', Rule::unique('roles')->whereNull('scope')->ignoreModel($this->role)],
                'abilities' => 'required|array|min:1'
            ]
        )->validate();

        $abilities = collect($this->abilities)->filter(function ($ability) use ($validRole) {
            return in_array($ability->id, $validRole['abilities']);
        });

        $this->role->update(['title' => $this->title, 'name' => $this->name]);

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
}
