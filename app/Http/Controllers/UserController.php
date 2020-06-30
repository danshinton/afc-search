<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

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
}
