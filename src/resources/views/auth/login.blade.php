@extends('layouts.app')
@section('content')
    <h1>ログイン画面</h1>
    <a href="/slack/redirect" class="slack-btn">
        <img class="slack-icon" src="{{ asset('images/slackIcon.svg') }}">
        Sign in with Slack
    </a>
@endsection
