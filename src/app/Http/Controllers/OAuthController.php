<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;

class OAuthController extends Controller
{
    private $client_id, $client_secret, $redirect_uri;
    public function __construct()
    {
        $this->client_id = config('const.SLACK_CLIENT_ID');
        $this->client_secret = config('const.SLACK_CLIENT_SECRET');
        $this->redirect_uri = 'https://localhost:443/slack/callback';
    }

    /**
     * 認証エンドポイントにリダイレクト
     *
     * @return RedirectResponse
     */
    public function redirect(): RedirectResponse
    {
        $state = csrf_token();
        $nonce = uniqid();
        request()->session()->put('nonce', $nonce);

        $to = "https://slack.com/openid/connect/authorize" .
            "?response_type=code" .
            "&scope=openid,profile,email" .
            "&state={$state}" .
            "&nonce={$nonce}" .
            "&client_id={$this->client_id}" .
            "&redirect_uri={$this->redirect_uri}";

        return redirect($to);
    }

    /**
     * ユーザーを認証しログインする
     *
     * @param User $userModel
     * @return RedirectResponse
     */
    public function callback(User $userModel): RedirectResponse
    {
        // state の検証
        if (csrf_token() !== request('state')) {
            abort(401);
        }

        // id_token のリクエスト
        $client = new Client();
        $res = $client->request('POST', "https://slack.com/api/openid.connect.token", [
            'form_params' => [
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret,
                'code' => request('code'),
                'redirect_uri' => $this->redirect_uri
            ]
        ]);

        // レスポンスのステータスチェック
        $status = $res->getStatusCode();
        if ($status !== 200) {
            abort(401);
        }
        $contents = json_decode($res->getBody()->getContents());
        if (!$contents->ok) {
            abort(401);
        }

        // JWT の payload の取得
        $id_token = explode('.', $contents->id_token);
        $payload = json_decode(base64_decode($id_token[1]));
        

        // nonce の検証
        $session_nonce = request()->session()->pull('nonce');
        if ($session_nonce !== $payload->nonce) {
            abort(401);
        }

        $name = $payload->name;
        $email = $payload->email;
        $icon = $payload->picture;

        if($userModel->isUserResistered($email)) {
            $user = $userModel->findUserByEmail($payload->email);
            Auth::login($user);
            request()->session()->regenerate();
            return redirect()->route('index')->with('flash_message', 'ログインに成功しました');    
        }
        
        $userModel->registerUser($name, $email, $icon);
        $user = $userModel->findUserByEmail($payload->email);

        Auth::login($user);
        request()->session()->regenerate();
        return redirect()->route('index')->with('flash_message', 'ログインに成功しました');
    }
}
