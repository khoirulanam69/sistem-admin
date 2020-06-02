<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserAccessMenu;
use App\UserMenu;
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

        $menu_id = UserMenu::where('menu', $menu)->get();
        $usermenu = DB::table('table_user_menu')
            ->join('table_user_access_menu', 'table_user_menu.id', 'table_user_access_menu.menu_id')
            ->select('table_user_menu.*')
            ->where('table_user_access_menu.role_id', $role_id)
            ->get();
        $usersubmenu = DB::table('table_user_sub_menu')
            ->join('table_user_menu', 'table_user_menu.id', 'table_user_sub_menu.menu_id')
            ->select('table_user_sub_menu.*')
            ->get();     
        $user = User::where('email', $email)->get();
        
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
            return view('user.user', compact('usermenu', 'usersubmenu', 'user'));        
        } else {
            return redirect('/blocked');
        }
            
    }

    public function edit()
    {
        $email = $this->request->session()->get('email');        
        $role_id = $this->request->session()->get('role_id');

        $usermenu = DB::table('table_user_menu')
            ->join('table_user_access_menu', 'table_user_menu.id', '=', 'table_user_access_menu.menu_id')
            ->select('table_user_menu.*')
            ->where('table_user_access_menu.role_id', '=', $role_id)
            ->get();
        $usersubmenu = DB::table('table_user_sub_menu')
            ->join('table_user_menu', 'table_user_menu.id', '=', 'table_user_sub_menu.menu_id')
            ->select('table_user_sub_menu.*')
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
