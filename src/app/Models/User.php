<?php

namespace App\Models;

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
}
