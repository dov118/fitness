@if(session('notification_type') && session('notification_message'))
    <div class="position-fixed top-0 right-0 mb-3 ml-3">
        <div class="Toast Toast--{{ session('notification_type') }}">
            <span class="Toast-icon">
                @if (session('notification_type') === "success")
                    <img class="octicon octicon-check" src="{{ Vite::asset('resources/imgs/check.svg') }}" alt="">
                @elseif(session('notification_type') === "error")
                    <img class="octicon octicon-check" src="{{ Vite::asset('resources/imgs/alert.svg') }}" alt="">
                @endif
            </span>
            <span class="Toast-content">{{ session('notification_message') }}</span>
            <button class="Toast-dismissButton">
                <img class="octicon octicon-x" src="{{ Vite::asset('resources/imgs/close.svg') }}" alt="">
            </button>
        </div>
    </div>
@endif
