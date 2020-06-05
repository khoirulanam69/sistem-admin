<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\MenuRole;
use App\Menu;
use App\Role;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        $email = $this->request->session()->get('email');
        $menu_id = Menu::where('menu', $this->request->segment(1))->get();
        $data = [
            'role_id' => $this->request->session()->get('role_id'),
            'menus' => Menu::get(),
            'roles' => Role::get(),
            'user' => User::where('email', '=', $email)->get(),
        ];

        if (!$email) {
            return redirect('/');
        }
        $accessed = false;
        foreach ($menu_id as $id) {
            $access = MenuRole::where('role_id', $data['role_id'])->where('menu_id', $id->id)->get();
            foreach ($access as $acc) {
                if ($acc->menu_id) {
                    $accessed = true;
                } else {
                    $accessed = false;
                }
            }
        }
        if ($accessed) {
            return view('user.user', $data);
        } else {
            return redirect('/blocked');
        }
    }

    public function edit()
    {
        $email = $this->request->session()->get('email');
        $data = [
            'role_id' => $this->request->session()->get('role_id'),
            'menus' => Menu::get(),
            'roles' => Role::get(),
            'user' => User::where('email', '=', $email)->get(),
        ];
        return view('user.edit', $data);
    }

    public function update()
    {
        $this->request->validate([
            'name' => 'required',
            'image' => 'required'
        ]);

        $email = $this->request->session()->get('email');

        // delete old image
        $image = User::where('email', $email)->get();
        if ($image[0]['image'] != 'default.png') {
            Storage::disk('local')->delete($image[0]['image']);
        }

        // add new image
        $file = $this->request->file('image')->store('profiles');
        User::where('email', $email)
            ->update([
                'name' => $this->request->name,
                'image' => $file
            ]);


        return redirect('/user/edit')->with('status', 'Your profile has been updated');
    }
}
