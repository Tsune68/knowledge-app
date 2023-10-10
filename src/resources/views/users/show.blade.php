@extends('layouts.app')
@section('content')

<body>
    <div>
        <p>{{ $userInfo->name }}</p>
        <p>{{ $userInfo->email }}</p>
    </div>
</body>
@endsection
