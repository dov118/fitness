<div class="Header flex-sm-row-reverse">
    @guest
        <div class="Header-item">
            <a class="Header-link" href="{{ route('login') }}">Login</a>
        </div>
    @endguest
    @auth
        <div class="d-flex flex-justify-end position-relative">
            <details class="details-reset details-overlay">
                <summary aria-haspopup="true">
                    <div class="Header-item mr-0">
                        <img
                            class="avatar"
                            height="20"
                            alt="@octocat"
                            src="https://cdn.discordapp.com/avatars/{{Auth::user()->id}}/{{Auth::user()->avatar}}.webp"
                            width="20">
                    </div>
                </summary>
                <div class="SelectMenu right-0">
                    <div class="SelectMenu-modal">
                        <header class="SelectMenu-header">
                            <h3 class="SelectMenu-title">{{ Auth::user()->email }}</h3>
                        </header>
                        <div class="SelectMenu-list">
                            <a class="SelectMenu-item" href="{{ route('admin.index') }}">Dashboard</a>
                            <hr class="SelectMenu-divider">
                            <form method="post" action="{{ route('logout') }}">
                                @csrf
                                @method('delete')
                                <button class="SelectMenu-item">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </details>
        </div>
    @endauth
</div>
