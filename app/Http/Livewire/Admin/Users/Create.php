<?php

namespace App\Http\Livewire\Admin\Users;

use App\Administrator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Silber\Bouncer\Bouncer;

class Create extends Component
{
    use AuthorizesRequests;

    /** @var string */
    public $firstName = '';

    /** @var string */
    public $lastName = '';

    /** @var string */
    public $email = '';

    /** @var string */
    public $password = '';

    /** @var bool */
    public $superadmin = false;

    public ?array $selectedRoles;

    public function submit()
    {
        $this->authorizeForUser(auth('admin')->user(), 'create-administrator');

        $validAdmin = Validator::make(
            [
                'first_name' => $this->firstName,
                'last_name' => $this->lastName,
                'email' => $this->email,
                'password' => $this->password,
                'is_super' => $this->superadmin,
                'roles' => $this->selectedRoles
            ],
            [
                'first_name' => 'required|min:3',
                'last_name' => 'required|min:3',
                'email' => 'required|email|unique:administrators',
                'password' => 'required|alpha_num|min:6',
                'is_super' => 'boolean',
                'roles' => 'required|array|min:1'
            ]
        )->validate();

        $this->dispatchBrowserEvent('submitting');

        /** @var Administrator */
        $admin = Administrator::query()->create([
            'first_name' => $validAdmin['first_name'],
            'last_name' => $validAdmin['last_name'],
            'email' => $validAdmin['email'],
            'password' => Hash::make($validAdmin['password']),
            'is_super' => $validAdmin['is_super'],
        ]);

        $admin->assign($validAdmin['roles']);

        event(new Registered($admin));

        return redirect()->route('admin.users.index');
    }

    public function render()
    {
        $availableRoles = app(Bouncer::class)->role()->all();

        return view('livewire.admin.users.create', [
            'roles' => $availableRoles
        ]);
    }
}
