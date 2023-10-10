<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * インスタンスの生成
     */
    private $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * ユーザー一覧ページの表示
     *
     * @return View
     */
    public function showAllUsers():View
    {
        $allUsers = $this->user->getAllUsers();

        return view('users.index', compact('allUsers'));
    }

    /**
     * 特定のユーザーを取得して表示
     *
     * @param integer $userId
     * @return View
     */
    public function findByUserId(int $userId): View
    {
        $userInfo = $this->user->findByUserId($userId);

        return view('users.show', compact('userInfo'));
    }
}
