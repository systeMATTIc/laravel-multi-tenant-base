<?php

namespace App\Http\Livewire\Users;

use App\Administrator;
use App\Tenant;
use App\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Silber\Bouncer\Bouncer;

class EditUser extends Component
{
    use AuthorizesRequests;

    /** @var string */
    public $firstName = '';

    /** @var string */
    public $lastName = '';

    /** @var string */
    public $email = '';

    /** @var string */
    public $password = null;

    /** @var bool */
    public $superadmin = false;

    public $userId;

    public ?array $selectedRoles;

    public $adminRoles;

    public function mount($uuid)
    {
        $this->userId = $uuid;

        $this->firstName = $this->user->first_name;
        $this->lastName = $this->user->last_name;
        $this->email = $this->user->email;
        $this->superadmin = (bool) $this->user->is_super;
        $this->adminRoles = $this->user->getRoles()->toArray();
    }

    public function submit()
    {
        $this->authorizeForUser(auth()->user(), 'edit-user');

        $validUser = Validator::make(
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
                'email' => [
                    'required',
                    'email',
                    Tenant::uniqueRule(
                        'users'
                    )->ignoreModel(
                        $this->user
                    )
                ],
                'password' => 'nullable|alpha_num|min:6',
                'is_super' => 'boolean',
                'roles' => 'required|array|min:1'
            ]
        )->validate();

        $user = empty($validUser['password'])
            ? array_filter($validUser)
            : array_merge($validUser, [
                'password' => Hash::make($validUser['password']),
            ]);

        $user = array_merge($user, ['is_super' => $this->superadmin]);

        $this->user->update($user);

        /** @var \Silber\Bouncer\Bouncer */
        $bouncer = app(Bouncer::class);

        $bouncer->scope()->onceTo(tenant()->id, function () use ($validUser, $bouncer) {
            $this->user->roles()->detach();
            $bouncer->assign($validUser['roles'])->to($this->user);
        });

        return redirect()->route('users.index');
    }

    public function getUserProperty()
    {
        return User::query()->where(['uuid' => $this->userId])->first();
    }

    public function render()
    {
        /** @var \Silber\Bouncer\Bouncer */
        $bouncer = app(Bouncer::class);

        $availableRoles = $bouncer->role()->query()->where([
            'scope' => tenant()->id
        ])->get();

        return view('livewire.users.edit-user', [
            'roles' => $availableRoles,
        ]);
    }
}
