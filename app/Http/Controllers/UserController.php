<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Access;
use App\Menu;
use Illuminate\Support\Facades\DB;
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
        $role_id = $this->request->session()->get('role_id');
        $menu = $this->request->segment(1);

        $menu_id = Menu::where('menu', $menu)->get();
        $usermenu = DB::table('menus')
            ->join('accesses', 'menus.id', '=', 'accesses.menu_id')
            ->select('menus.*')
            ->where('accesses.role_id', '=', $role_id)
            ->get();
        $usersubmenu = DB::table('submenus')
            ->join('menus', 'menus.id', '=', 'submenus.menu_id')
            ->select('submenus.*')
            ->get();
        $user = User::where('email', $email)->get();

        if (!$email) {
            return redirect('/');
        }
        $accessed = false;
        foreach ($menu_id as $id) {
            $access = Access::where('role_id', $role_id)->where('menu_id', $id->id)->get();
            foreach ($access as $acc) {
                if ($acc->menu_id) {
                    $accessed = true;
                } else {
                    $accessed = false;
                }
            }
        }
        if ($accessed) {
            return view('user.user', compact('usermenu', 'usersubmenu', 'user'));
        } else {
            return redirect('/blocked');
        }
    }

    public function edit()
    {
        $email = $this->request->session()->get('email');
        $role_id = $this->request->session()->get('role_id');

        $usermenu = DB::table('menus')
            ->join('accesses', 'menus.id', '=', 'accesses.menu_id')
            ->select('menus.*')
            ->where('accesses.role_id', '=', $role_id)
            ->get();
        $usersubmenu = DB::table('submenus')
            ->join('menus', 'menus.id', '=', 'submenus.menu_id')
            ->select('submenus.*')
            ->get();
        $user = User::select()
            ->where('email', '=', $email)
            ->get();
        return view('user.edit', compact('user', 'usermenu', 'usersubmenu'));
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
