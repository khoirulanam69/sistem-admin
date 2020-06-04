<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Menu;
use App\Submenu;
use App\Access;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
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
        $showusermenu = Menu::all();
        // $usermenu = UserMenu::where('accesses.role_id', $role_id);
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
            return view('menu.menu_management', compact('usermenu', 'usersubmenu', 'user', 'showusermenu'));
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
            ->select('*')
            ->get();

        $user = User::select()
            ->where('email', '=', $email)
            ->get();

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
            return view('menu.submenu_management', compact('usermenu', 'usersubmenu', 'user'));
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
