<div class="navbar h-16 bg-base-300">
    <div class="flex-1">
        <a href="{{ route('index') }}" class="btn btn-ghost text-xl">{{ config('app.name') }}</a>
    </div>
    <div class="flex-none gap-2">
        @auth
            <div class="dropdown dropdown-end">
                <label tabindex="0" class="btn btn-ghost">
                    <x-heroicon-s-user class="inline h-6 w-6" />
                    {{ auth()->user()->name }}
                </label>
                <ul tabindex="0" class="menu-compact menu dropdown-content mt-3 w-52 rounded-box bg-base-200 p-2 shadow">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <li><button type="submit">
                            <x-heroicon-s-arrow-left-start-on-rectangle class="inline h-6 w-6" />Logout
                        </button></li>
                    </form>
                </ul>
            </div>
        @endauth

        @guest
            <a href="{{ route('login') }}" class="btn btn-ghost">Login</a>
            <a href="{{ route('register') }}" class="btn btn-ghost">Register</a>
        @endguest
    </div>
</div>
