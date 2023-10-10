<header>
    <ul>
        @auth
            <li><a href="{{ route('logout') }}">ログアウト</a></li>
        @endauth
    </ul>
</header>
