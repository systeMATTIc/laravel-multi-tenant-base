<?php

namespace App\Http\Livewire\Admin\Roles;

use App\Role;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

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
        /** @var \App\Administrator */
        $admin = auth('admin')->user();

        $this->authorizeForUser($admin, 'delete-role');

        try {
            $role = Role::query()->where(['scope' => null])->findOrFail(decrypt($id));

            if ($admin->isA($role)) {
                $this->emitSelf('failedRoleDeletion', [
                    'msg' => 'Cannot delete this role because it has been assigned to the currently logged in user'
                ]);

                return;
            }

            $role->delete();

            $this->emitSelf('roleDeleted');
        } catch (\Throwable $th) {
            abort(404);
        }
    }

    public function render()
    {
        $roles = Role::search($this->search)
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.roles.roles-list', [
            'roles' => $roles
        ]);
    }
}
