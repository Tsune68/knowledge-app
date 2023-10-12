<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'icon',
    ];

    /**
     * ユーザー新規登録
     *
     * @param string $name
     * @param string $email
     * @param string $icon
     * @return void
     */
    public function registerUser(string $name, string $email, string $icon): void
    {
        $this->name = $name;
        $this->email = $email;
        $this->icon = $icon;
        $this->save();
    }

    /**
     * ユーザーが登録済みかを調べる
     *
     * @param string $email
     * @return boolean
     */
    public function isUserResistered(string $email): bool
    {
        return $this->where('email', $email)->exists();
    }

    /**
     * メールアドレスが一致するユーザーを取得
     *
     * @param string $email
     * @return User
     */
    public function findUserByEmail(string $email): User
    {
        return $this->where('email', $email)->first();
    }

    /**
     * 全てのユーザーを取得する。
     *
     * @return Collection
     */
    public function getAllUsers(): Collection
    {
        return User::all()->sortByDesc('created_at');
    }

    /**
     * 特定のユーザーを取得
     *
     * @param integer $userId
     * @return User
     */
    public function findByUserId(int $userId): User
    {
        $userDetail = $this->find($userId);
        if (is_null($userDetail)) abort(404);

        return $userDetail;
    }

    /**
     * ログインユーザー削除
     *
     * @return void
     */
    public function deleteUser(): void
    {
        $this->destroy(Auth::id());
    }

    /**
     * ユーザー名の更新
     *
     * @param integer $userId
     * @param string $name
     * @return void
     */
    public function updateUser(int $userId, string $name): void
    {
        $user = $this->findByUserId($userId);
        $user->name = $name;
        $user->save();
    }
}
