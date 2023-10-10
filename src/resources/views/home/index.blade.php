@extends('layouts.app')
@section('content')
    @if (session('flash_message'))
        <div class="flash_message danger">
            {{ session('flash_message') }}
        </div>
    @endif

    <h1>ホーム画面</h1>
@endsection
