<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Menu;
use App\Role;
use App\Submenu;
use App\Access;

class MenuController extends Controller
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
            $access = Access::where('role_id', $data['role_id'])->where('menu_id', $id->id)->get();
            foreach ($access as $acc) {
                if ($acc->menu_id) {
                    $accessed = true;
                } else {
                    $accessed = false;
                }
            }
        }
        if ($accessed) {
            return view('menu.menu_management', $data);
        } else {
            return redirect('/blocked');
        }
    }

    public function createmenu()
    {
        $this->request->validate([
            'menu' => 'required'
        ]);

        Menu::create($this->request->all());
        return redirect('/menu')->with('status', 'New menu successfuly added');
    }

    public function submenu()
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
            $access = Access::where('role_id', $data['role_id'])->where('menu_id', $id->id)->get();
            foreach ($access as $acc) {
                if ($acc->menu_id) {
                    $accessed = true;
                } else {
                    $accessed = false;
                }
            }
        }
        if ($accessed) {
            return view('menu.submenu_management', $data);
        } else {
            return redirect('/blocked');
        }
    }

    public function createsubmenu()
    {
        $this->request->validate([
            'menu_id' => 'required',
            'title' => 'required',
            'icon' => 'required',
            'url' => 'required',
        ]);
        Submenu::create($this->request->all());
        return redirect('/menu/submenu')->with('status', 'New submenu successfuly added');
    }

    public function deletemenu($id)
    {
        Menu::destroy($id);
        return redirect('/menu')->with('status', 'Menu deleted');
    }

    public function deletesubmenu($id)
    {
        Submenu::destroy($id);
        return redirect('/menu/submenu')->with('status', 'Submenu deleted');
    }
}
