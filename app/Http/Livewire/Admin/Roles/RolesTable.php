<?php

namespace App\Http\Livewire\Admin\Roles;

use App\Role;
use Livewire\Component;
use Livewire\WithPagination;

class RolesTable extends Component
{
    use WithPagination;

    public int $perPage = 10;

    public string $sortField = 'created_at';
    
    public bool $sortAsc = true;
    
    public string $search = '';

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = ! $this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function render()
    {
        $roles = Role::search($this->search)
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage)
        ;
        
        return view('livewire.admin.roles.roles-table', [
            'roles' => $roles
        ]);
    }
}
