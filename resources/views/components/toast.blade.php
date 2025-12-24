<div id="toast-container">

    @if (session('success'))
        <div class="toast toast-success">
            <span>{{ session('success') }}</span>
            <button class="toast-close">&times;</button>
        </div>
    @endif

    @if (session('error'))
        <div class="toast toast-error">
            <span>{{ session('error') }}</span>
            <button class="toast-close">&times;</button>
        </div>
    @endif

    @if (session('warning'))
        <div class="toast toast-warning">
            <span>{{ session('warning') }}</span>
            <button class="toast-close">&times;</button>
        </div>
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="toast toast-error">
                <span>{{ $error }}</span>
                <button class="toast-close">&times;</button>
            </div>
        @endforeach
    @endif

</div>
