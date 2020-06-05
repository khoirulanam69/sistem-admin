<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Auth;
use \App\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function login()
    {
        $email = $this->request->session()->get('email');
        if ($email) {
            return redirect('/user');
        }
        return view('auth.login');
    }

    public function loginStore()
    {
        $this->request->validate([
            'email' => 'required|email',
            'password' => 'required|min:3'
        ]);
        $user = User::select('*')
            ->where('email', $this->request->email)
            ->get();
        if (Auth::attempt(['email' => $this->request->email, 'password' => $this->request->password])) {
            foreach ($user as $u) {
                $this->request->session()->put('role_id', $u->role_id);
                $this->request->session()->put('email', $u->email);

                if ($u->role_id == 1) {
                    return redirect('/admin');
                } else {
                    return redirect('/user');
                }
            }
        } else {
            return redirect('/')->with('error', 'Login failed! Email or password was wrong');
        }
    }

    public function registration()
    {
        $email = $this->request->session()->get('email');
        if ($email) {
            return redirect('/user');
        }
        return view('auth.registration');
    }

    public function registrationStore()
    {
        $this->request->validate([
            'name' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:3|same:repassword',
            'repassword' => 'required|same:password',
        ]);

        $user = new User;
        $user->name = $this->request->name;
        $user->email = $this->request->email;
        $user->image = 'default.png';
        $user->password = Hash::make($this->request->password);
        $user->role_id = 2;
        $user->remember_token = '';
        $user->date_created = time();
        $user->email_verified_at = null;
        $user->save();

        return redirect('/')->with('status', 'Your account has been created! Please Activation');
    }

    public function forgotpassword()
    {
        return view('auth.passwords.email');
    }

    public function blocked()
    {
        return view('auth.blocked');
    }

    public function logout()
    {
        $this->request->session()->flush();
        return redirect('/')->with('status', 'You has been logout');
    }
}
