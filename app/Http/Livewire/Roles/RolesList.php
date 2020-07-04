<?php

namespace App\Http\Livewire\Roles;

use App\Role;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;
use Silber\Bouncer\Bouncer;

class RolesList extends Component
{
    use WithPagination, AuthorizesRequests;

    public int $perPage = 10;

    public string $sortField = 'created_at';

    public bool $sortAsc = true;

    public string $search = '';

    protected $listeners = ['roleDeleted' => 'render'];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function delete($id)
    {
        /** @var \App\User */
        $user = auth()->user();

        $this->authorizeForUser($user, 'delete-role');

        try {
            $role = Role::query()->where(['scope' => tenant()->id])->findOrFail(decrypt($id));

            if ($user->isA($role)) {

                throw new \Exception('Cannot delete role because it has been assigned to the currently logged in user');
            }

            $role->delete();

            $this->emitSelf('roleDeleted');

            $this->dispatchBrowserEvent('flash', [
                'type' => 'success',
                'message' => "User Deleted Successfully"
            ]);
        } catch (\Throwable $th) {

            $this->dispatchBrowserEvent('flash', [
                'type' => 'error',
                'message' => $th->getMessage()
            ]);
        }
    }

    public function render()
    {
        $roles = Role::search($this->search, tenant()->id)
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.roles.roles-list', [
            'roles' => $roles
        ]);
    }
}
