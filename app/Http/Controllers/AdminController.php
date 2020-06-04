<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserMenu;
use App\UserAccessMenu;
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

        $menu_id = UserMenu::where('menu', $menu)->get();
        $usermenu = DB::table('table_user_menu')
            ->join('table_user_access_menu', 'table_user_menu.id', '=', 'table_user_access_menu.menu_id')
            ->select('table_user_menu.*')
            ->where('table_user_access_menu.role_id', '=', $role_id)
            ->get();
        $usersubmenu = DB::table('table_user_sub_menu')
            ->join('table_user_menu', 'table_user_menu.id', '=', 'table_user_sub_menu.menu_id')
            ->select('table_user_sub_menu.*')
            ->get();

        $user = User::where('email', '=', $email)->get();


        if (!$email) {
            return redirect('/');
        }
        $accessed = false;
        foreach ($menu_id as $id) {
            $access = UserAccessMenu::where('role_id', $role_id)->where('menu_id', $id->id)->get();
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

        $menu_id = UserMenu::where('menu', $menu)->get();
        $usermenu = DB::table('table_user_menu')
            ->join('table_user_access_menu', 'table_user_menu.id', '=', 'table_user_access_menu.menu_id')
            ->select('table_user_menu.*')
            ->where('table_user_access_menu.role_id', '=', $role_id)
            ->get();
        $usersubmenu = DB::table('table_user_sub_menu')
            ->join('table_user_menu', 'table_user_menu.id', '=', 'table_user_sub_menu.menu_id')
            ->select('table_user_sub_menu.*')
            ->get();
        $user = User::where('email', '=', $email)->get();
        $users = User::paginate(10);

        if (!$email) {
            return redirect('/');
        }
        $accessed = false;
        foreach ($menu_id as $id) {
            $access = UserAccessMenu::where('role_id', $role_id)->where('menu_id', $id->id)->get();
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

        $menu_id = UserMenu::where('menu', $menu)->get();
        $usermenu = DB::table('table_user_menu')
            ->join('table_user_access_menu', 'table_user_menu.id', '=', 'table_user_access_menu.menu_id')
            ->select('table_user_menu.*')
            ->where('table_user_access_menu.role_id', '=', $role_id)
            ->get();
        $usersubmenu = DB::table('table_user_sub_menu')
            ->join('table_user_menu', 'table_user_menu.id', '=', 'table_user_sub_menu.menu_id')
            ->select('table_user_sub_menu.*')
            ->get();
        $user = User::where('email', '=', $email)->get();
        $users = User::where('name', 'like', '%' . $search . '%')->paginate();

        if (!$email) {
            return redirect('/');
        }
        $accessed = false;
        foreach ($menu_id as $id) {
            $access = UserAccessMenu::where('role_id', $role_id)->where('menu_id', $id->id)->get();
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
