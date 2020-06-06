<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Menu;
use App\Role;
use App\Submenu;
use App\MenuRole;

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
            return view('menu.menu', $data);
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
            return view('menu.submenu', $data);
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

    public function editmenu($id)
    {
        $email = $this->request->session()->get('email');
        $data = [
            'role_id' => $this->request->session()->get('role_id'),
            'menus' => Menu::get(),
            'roles' => Role::get(),
            'user' => User::where('email', '=', $email)->get(),
            'show' => Menu::where('id', $id)->get(),
        ];
        return view('menu.menu_edit', $data);
    }

    public function editsubmenu($id)
    {
        $email = $this->request->session()->get('email');
        $data = [
            'role_id' => $this->request->session()->get('role_id'),
            'menus' => Menu::get(),
            'roles' => Role::get(),
            'user' => User::where('email', '=', $email)->get(),
            'show' => Submenu::where('id', $id)->get(),
        ];
        return view('menu.submenu_edit', $data);
    }

    public function updatemenu($id)
    {
        $this->request->validate([
            'menu' => 'required'
        ]);

        Menu::where('id', $id)->update(['menu' => $this->request->menu]);
        return redirect(url('/menu/' . $id))->with('status', 'The menu has been updated');
    }

    public function updatesubmenu($id)
    {
        $this->request->validate([
            'menu_id' => 'required',
            'title' => 'required',
            'icon' => 'required',
            'url' => 'required',
        ]);

        $is_active = $this->request->is_active;
        if ($is_active == null) {
            $is_active = 0;
        }
        Submenu::where('id', $id)->update([
            'menu_id' => $this->request->menu_id,
            'title' => $this->request->title,
            'icon' => $this->request->icon,
            'url' => $this->request->url,
            'is_active' => $is_active
        ]);
        return redirect(url('/menu/submenu/' . $id))->with('status', 'The submenu has been updated');
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
