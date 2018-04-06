<?php
/**
 * Created by PhpStorm.
 * User: cfpd-home
 * Date: 03.04.2018
 * Time: 14:34
 */

namespace App\Http\Controllers;

Use App\User;
Use App\Mail\UserRegistered;
Use Illuminate\Support\Facades\Mail;
Use App\Http\Controllers\Controller;
Use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    /**
     * Функция подтверждения эмейла
     *
     * @param Request $request
     * @param $token
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View Редирект на страницу логина
     */
    public function confirmEmail(Request $request, $token)
    {
        $user = User::whereToken($token)->firstOrFail();
        $user->confirmEmail();
        Auth::login($user, true);
        $request->session()->flash('message', 'Учётная запись подтверждена.');
        return redirect('user/edit/'.$user->id);
    }

    /**
     * Редирект на форму регистрации
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function register()
    {
        return view('auth.register');
    }

    /**
     * Валидация данных отправленных пользователем
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postRegister(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);
        $user = User::create($request->all());
        $link = 'https://us18.api.mailchimp.com/3.0/lists/';
        $listId = '2bca7ce9d8';
        $code = $user->subscribeInMailchimp($listId, $link);
        var_dump($code);
        die();
        Mail::to($user)->send(new UserRegistered($user));
        $request->session()->flash('message', 'На Ваш адрес было выслано письмо для активации');
        return redirect()->back();
    }

    /**
     * RegistrationController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
}