<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:create-user');
    }

    public function index() {
        $users = User::orderBy('id')->get();

        return view('user', [
            'users' => $users
        ]);
    }

    public function enable($id) {
        $user = User::findOrFail($id);
        $user->enabled = true;
        $user->save();

        return redirect('/users')
            ->with('mesg', 'User \'' . $user->email . '\' has been enabled')
            ->with('mesg-type', "success");
    }

    public function disable($id) {
        $user = User::findOrFail($id);
        $authUser = Auth::user();

        // You can't disable your own account
        if ($authUser->id == $user->id) {
            return redirect('/users')
                ->with('mesg', 'You cannot disable your own account')
                ->with('mesg-type', "error");
        }

        $user->enabled = false;
        $user->save();

        return redirect('/users')
            ->with('mesg', 'User \'' . $user->email . '\' has been disabled')
            ->with('mesg-type', "success");
    }
}
