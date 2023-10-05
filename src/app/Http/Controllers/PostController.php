<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class PostController extends Controller
{
    /**
     * トップページを表示
     *
     * @return View
     */
    public function showTopPage(): View
    {
        return view('home.index');
    }
}
