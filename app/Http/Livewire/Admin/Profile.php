<?php

namespace App\Http\Livewire\Admin;

use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Profile extends Component
{
    public $firstName;

    public $lastName;
    
    public $password;
    
    public $passwordConfirmation;

    public function mount()
    {
        $user = auth()->user();

        $this->firstName = $user->first_name;

        $this->lastName = $user->last_name;
    }

    public function update()
    {
        $this->validate([
            'firstName' => 'required|min:3',
            'lastName' => 'required|min:3'
        ]);

        /** @var \App\Administrator */
        $user = auth('admin')->user();

        $user->update([
            'first_name' => $this->firstName,
            'last_name' => $this->lastName
        ]);

        $this->dispatchBrowserEvent('updated-profile', ['name' => 'data']);
    }

    public function changePassword()
    {
        $this->validate([
            'password' => 'required|alpha_num|min:8|same:passwordConfirmation'
        ]);

        /** @var \App\Administrator */
        $user = auth('admin')->user();

        $user->update(['password' => Hash::make($this->password)]);

        $this->password = "";
        $this->passwordConfirmation = "";

        $this->dispatchBrowserEvent('updated-profile', ['name' => 'pwd']);
    }
    
    public function render()
    {
        return view('livewire.admin.profile');
    }
}
