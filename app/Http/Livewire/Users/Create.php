<?php

namespace App\Http\Livewire\Users;

use App\Tenant;
use App\User;
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
        $this->authorizeForUser(auth()->user(), 'create-user');

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
                'email' => ['required', 'email', Tenant::uniqueRule('users')],
                'password' => 'required|alpha_num|min:6',
                'is_super' => 'boolean',
                'roles' => 'required|array|min:1'
            ]
        )->validate();

        /** @var User */
        $admin = User::query()->create([
            'first_name' => $validAdmin['first_name'],
            'last_name' => $validAdmin['last_name'],
            'email' => $validAdmin['email'],
            'password' => Hash::make($validAdmin['password']),
            'is_super' => $validAdmin['is_super'],
        ]);

        /** @var \Silber\Bouncer\Bouncer */
        $bouncer = app(Bouncer::class);

        $bouncer->scope()->onceTo(tenant()->id, function () use ($admin, $validAdmin, $bouncer) {
            $bouncer->assign($validAdmin['roles'])->to($admin);
        });

        event(new Registered($admin));

        return redirect()->route('users.index');
    }

    public function render()
    {
        /** @var \Silber\Bouncer\Bouncer */
        $bouncer = app(Bouncer::class);

        $availableRoles = $bouncer->role()->query()->where([
            'scope' => tenant()->id
        ])->get();

        return view('livewire.users.create', [
            'roles' => $availableRoles
        ]);
    }
}
