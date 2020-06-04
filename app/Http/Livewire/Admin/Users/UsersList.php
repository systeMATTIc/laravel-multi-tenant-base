<?php

namespace App\Http\Livewire\Admin\Users;

use App\Administrator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class UsersList extends Component
{
    use WithPagination, AuthorizesRequests;

    public int $perPage = 10;

    public string $sortField = 'created_at';

    public bool $sortAsc = true;

    public string $search = '';

    protected $listeners = ['adminDeleted' => 'render'];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function delete($uuid)
    {
        $this->authorizeForUser(auth('admin')->user(), 'delete-administrator');

        $admin = Administrator::query()->where('uuid', '=', $uuid)->first();

        if ($admin->is_super) {
            $this->emitSelf('failedAdminDeletion', [
                'msg' => 'Cannot Delete a Superadmin'
            ]);

            return;
        }

        if ($admin->is(auth('admin')->user())) {
            $this->emitSelf('failedAdminDeletion', [
                'msg' => 'Cannot delete the currently logged in user'
            ]);

            return;
        }

        $admin->delete();

        $this->emitSelf('adminDeleted');
    }

    public function render()
    {
        $administrators = Administrator::search($this->search)
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.users.users-list', [
            'administrators' => $administrators
        ]);
    }
}
