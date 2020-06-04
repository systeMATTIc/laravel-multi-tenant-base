<?php

namespace App\Http\Livewire\Admin\Users;

use App\Administrator;
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

    /** @var string */
    public $administratorUuid;

    public ?array $selectedRoles;

    public $adminRoles;

    public function mount($uuid)
    {
        $this->administratorUuid = $uuid;

        $this->firstName = $this->administrator->first_name;
        $this->lastName = $this->administrator->last_name;
        $this->email = $this->administrator->email;
        $this->superadmin = (bool) $this->administrator->is_super;
        $this->adminRoles = $this->administrator->getRoles()->toArray();
    }

    public function submit()
    {
        $this->authorizeForUser(auth('admin')->user(), 'edit-administrator');

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
                'email' => [
                    'required',
                    'email',
                    Rule::unique(
                        'administrators'
                    )->ignoreModel(
                        $this->administrator
                    )
                ],
                'password' => 'nullable|alpha_num|min:6',
                'is_super' => 'boolean',
                'roles' => 'required|array|min:1'
            ]
        )->validate();

        $administrator = empty($validAdmin['password'])
            ? array_filter($validAdmin)
            : array_merge($validAdmin, [
                'password' => Hash::make($validAdmin['password']),
            ]);

        $this->administrator->update(array_merge($administrator, [
            'is_super' => (bool) $validAdmin['is_super']
        ]));

        $this->administrator->roles()->detach();

        $this->administrator->assign($validAdmin['roles']);

        return redirect()->route('admin.users.index');
    }

    public function getAdministratorProperty()
    {
        return Administrator::query()->whereUuid(
            $this->administratorUuid
        )->first();
    }

    public function render()
    {
        /** @var Bouncer */
        $bouncer = app(Bouncer::class);

        $availableRoles = $bouncer->role()->query()->where([
            'scope' => null
        ])->get();

        return view('livewire.admin.users.edit-user', [
            'roles' => $availableRoles,
        ]);
    }
}
