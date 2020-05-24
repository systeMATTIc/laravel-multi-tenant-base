<?php

namespace App\Http\Livewire\Admin\Roles;

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
    
    public $abilities;

    /** @var Role */
    public $role = null;

    public function mount($abilities, Role $role)
    {
        $this->abilities = $abilities;
        $this->role = $role;

        $this->title = $role->title;
        $this->name = $role->name;
        $this->selectedAbilities = $role->getAbilities()->pluck('id')->toArray();
        
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
                'title' => ['required', 'min:3', Rule::unique('roles')->ignoreModel($this->role)],
                'name' => ['required', 'min:3', Rule::unique('roles')->ignoreModel($this->role)],
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

    public function render()
    {
        return view('livewire.admin.roles.edit-form');
    }
}
