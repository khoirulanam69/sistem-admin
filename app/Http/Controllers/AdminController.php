<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Menu;
use App\MenuRole;
use App\Role;
use PDF;

class AdminController extends Controller
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
            'user' => User::where('email', '=', $email)->get()
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
            return view('admin/admin', $data);
        } else {
            return redirect('/blocked');
        }
    }

    public function listuser()
    {
        $email = $this->request->session()->get('email');
        $menu_id = Menu::where('menu', $this->request->segment(1))->get();
        $data = [
            'role_id' => $this->request->session()->get('role_id'),
            'menus' => Menu::get(),
            'roles' => Role::get(),
            'user' => User::where('email', '=', $email)->get(),
            'users' => User::paginate(10)
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
            return view('admin/listuser', $data);
        } else {
            return redirect('/blocked');
        }
    }

    public function search()
    {
        $search = $this->request->search;

        if ($search == null) {
            return redirect(url('/admin/listuser'));
        }

        $email = $this->request->session()->get('email');
        $menu_id = Menu::where('menu', $this->request->segment(1))->get();
        $data = [
            'role_id' => $this->request->session()->get('role_id'),
            'menus' => Menu::get(),
            'roles' => Role::get(),
            'user' => User::where('email', '=', $email)->get(),
            'users' => User::where('name', 'like', '%' . $search . '%')->paginate()
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
            return view('admin/listuser', $data);
        } else {
            return redirect('/blocked');
        }
    }

    public function downloadpdf()
    {
        $data = [
            'users' => User::all(),
        ];
        $pdf = PDF::loadview('admin/userpdf', $data);
        return $pdf->stream();
    }
}
