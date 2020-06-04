<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Menu;
use App\Access;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
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

        $user = User::where('email', '=', $email)->get();


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
            return view('admin/admin', compact('usermenu', 'usersubmenu', 'user'));
        } else {
            return redirect('/blocked');
        }
    }

    public function listuser()
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
        $user = User::where('email', '=', $email)->get();
        $users = User::paginate(10);

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
            return view('admin/listuser', compact('usermenu', 'usersubmenu', 'user', 'users'));
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
        $user = User::where('email', '=', $email)->get();
        $users = User::where('name', 'like', '%' . $search . '%')->paginate();

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
            return view('admin/listuser', compact('usermenu', 'usersubmenu', 'user', 'users'));
        } else {
            return redirect('/blocked');
        }
    }
}
