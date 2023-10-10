<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;


class AuthController extends Controller
{
    /**
     * ログアウト
     *
     * @return RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect('/');
    }

    /**
     * ログイン画面を表示
     *
     * @return View
     */
    public function showLogin(): View
    {
        return view('auth.login');
    }

}
