<?php

namespace App\Http\Livewire\Admin\Auth;

use App\Administrator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Register extends Component
{
    /** @var string */
    public $firstName = '';

    /** @var string */
    public $lastName = '';

    /** @var string */
    public $email = '';

    /** @var string */
    public $password = '';

    /** @var string */
    public $passwordConfirmation = '';

    public function register()
    {
        $this->validate([
            'firstName' => ['required'],
            'lastName' => ['required'],
            'email' => ['required', 'email', 'unique:administrators'],
            'password' => ['required', 'min:8', 'same:passwordConfirmation'],
        ]);

        $admin = Administrator::create([
            'email' => $this->email,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'password' => Hash::make($this->password),
        ]);

        event(new Registered($admin));

        Auth::login($admin, true);

        redirect(route('admin.home'));
    }

    public function render()
    {
        return view('livewire.admin.auth.register');
    }
}
