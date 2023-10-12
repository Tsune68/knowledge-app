<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

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

    /**
     * ユーザー削除
     *
     * @return RedirectResponse
     */
    public function deleteUser(): RedirectResponse {
        $this->user->deleteUser();

        return redirect()->route('login');
    }

    /**
     * ユーザー名の更新
     *
     * @param integer $userId
     * @param UpdateUserRequest $request
     * @return RedirectResponse
     */
    public function  updateUser(int $userId, UpdateUserRequest $request): RedirectResponse 
    {
        if (Auth::id() !== $userId) {
            abort(403);
        }
        $name = $request->name;
        $this->user->updateUser($userId, $name);

        return redirect()->route('users.show', ['id' => $userId])->with('flash_message', '更新しました');
    }
}
