<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PasswordResetController extends Controller
{
    public function __invoke($token)
    {
        return view('admin.auth.passwords.reset', [
            'token' => $token,
        ]);
    }
}
