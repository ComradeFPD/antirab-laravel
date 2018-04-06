<?php
/**
 * Created by PhpStorm.
 * User: cfpd-home
 * Date: 03.04.2018
 * Time: 15:21
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class SessionController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, ['email' => 'required|email', 'password' => 'required']);
        if($this->signIn($request)){
            $request->session()->flash('message', 'Вы вошли под свою учётную запись!');
            return redirect('/');
        }
        $request->session()->flash('message', 'Вход запрещён!');
        return redirect()->back();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flash('message', 'Вы вышли из своей учётной записи!');
        return redirect('login');
    }

    protected function signIn(Request $request)
    {
        return Auth::attempt($this->getCredentials($request), $request->has('remember'));
    }

    protected function getCredentials(Request $request)
    {
        return [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'verifed' => true
        ];
    }
}