@if(session('notification_type') && session('notification_message'))
    <div class="position-fixed bottom-0 left-0 mb-3 ml-3">
        <div class="Toast Toast--{{ session('notification_type') }}">
            <span class="Toast-icon">
                @if (session('notification_type') === "success")
                    <svg width="12" height="16" viewBox="0 0 12 16" class="octicon octicon-check" aria-hidden="true">
                        <path fill-rule="evenodd" d="M12 5l-8 8-4-4 1.5-1.5L4 10l6.5-6.5L12 5z" />
                    </svg>
                @elseif(session('notification_type') === "error")
                    <svg width="16" height="16" viewBox="0 0 16 16" class="octicon octicon-alert" aria-hidden="true">
                        <path fill-rule="evenodd" d="M8.893 1.5c-.183-.31-.52-.5-.887-.5s-.703.19-.886.5L.138 13.499a.98.98 0 0 0 0 1.001c.193.31.53.501.886.501h13.964c.367 0 .704-.19.877-.5a1.03 1.03 0 0 0 .01-1.002L8.893 1.5zm.133 11.497H6.987v-2.003h2.039v2.003zm0-3.004H6.987V5.987h2.039v4.006z"/>
                    </svg>
                @endif
            </span>
            <span class="Toast-content">{{ session('notification_message') }}</span>
            <button class="Toast-dismissButton">
                <svg width="12" height="16" viewBox="0 0 12 16" class="octicon octicon-x" aria-hidden="true">
                    <path
                        fill-rule="evenodd"
                        d="M7.48 8l3.75 3.75-1.48 1.48L6 9.48l-3.75 3.75-1.48-1.48L4.52 8 .77 4.25l1.48-1.48L6 6.52l3.75-3.75 1.48 1.48L7.48 8z"
                    />
                </svg>
            </button>
        </div>
    </div>
@endif
