<div>
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li class="error_message">{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    @if (session('flash_message'))
        <div class="flash_message">
            {{ session('flash_message') }}
        </div>
    @endif
</div>
