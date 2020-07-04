<?php

namespace App\Http\Livewire\Users;

use App\User;
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

    protected $listeners = ['userDeleted' => 'render'];

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
        $this->authorize('delete-user');

        $user = User::query()->where('uuid', '=', $uuid)->first();

        if ($user->is_super) {

            $this->dispatchBrowserEvent('flash', [
                'type' => 'error',
                'message' => "Cannot Delete a Superadmin"
            ]);

            return;
        }

        if ($user->is(auth()->user())) {

            $this->dispatchBrowserEvent('flash', [
                'type' => 'error',
                'message' => "Cannot delete the currently logged in user"
            ]);

            return;
        }

        $user->delete();

        $this->emitSelf('userDeleted');

        $this->dispatchBrowserEvent('flash', [
            'type' => 'success',
            'message' => "User Deleted Successfully"
        ]);
    }

    public function render()
    {
        $users = User::search($this->search)
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.users.users-list', [
            'users' => $users
        ]);
    }
}
