@extends('layouts.app')
@section('content')

    <body>
        <div>
            @if (Auth::id() === $userInfo->id)
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    アカウントを削除する
                </button>
                <button type="button" class="btn btn-primary mx-3" data-bs-toggle="modal" data-bs-target="#test-modal">
                    編集する
                </button>
            @endif
        </div>
        <div>
            <p>{{ $userInfo->name }}</p>
            <p>{{ $userInfo->email }}</p>
        </div>

        <!--　更新モーダル -->
        <div id="test-modal" class="modal fade" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content update-modal">
                    <div class="modal-header">
                        <h5 class="modal-title">マイページの編集</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="update" method="POST" action="{{ route('users.update', ['id' => $userInfo->id]) }}">
                            @csrf
                            @method('PUT')
                            <label for="name">ユーザー名</label>
                            <input type="text" id="name" name="name" value="{{ $userInfo->name }}">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                        <button type="submit" form="update" class="btn btn-primary" data-bs-dismiss="modal">更新する</button>
                    </div>
                </div>
            </div>
        </div>

        <!--削除モーダル -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">アカウント削除</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        アカウントを削除してもよろしいでしょうか？
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                        <button type="submit" form="delete" class="btn btn-danger" data-bs-dismiss="modal">削除する</button>
                        <form id="delete" class="btn" action="{{ route('users.delete') }}" method="POST">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
@endsection
