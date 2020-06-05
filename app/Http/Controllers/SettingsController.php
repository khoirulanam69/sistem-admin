<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use App\User;
use App\Role;
use App\Menu;

class SettingsController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function language()
    {
        $email = $this->request->session()->get('email');
        $data = [
            'role_id' => $this->request->session()->get('role_id'),
            'menus' => Menu::get(),
            'roles' => Role::get(),
            'user' => User::where('email', '=', $email)->get()
        ];

        if (!$email) {
            return redirect('/');
        }
        return view('settings', $data);
    }
}
