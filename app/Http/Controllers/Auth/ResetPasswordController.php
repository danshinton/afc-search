<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function change() {
        return view('auth.passwords.change');
    }

    public function store(Request $request) {
        $request->validate([ 'password' => 'required|confirmed|min:8' ], []);

        $user = Auth::user();

        if ($user) {
            $this->resetPassword($user, $request['password']);
            return redirect($this->redirectPath())->with('status', 'Password has been changed');
        }

        return redirect()->back()->withErrors(['status' => 'Could not reset password']);
    }
}
