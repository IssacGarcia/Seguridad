<div>
    @auth
    <div class="card m-8 w-96 bg-base-300 shadow-xl">
        <div class="card-body">
            <h2 class="card-title">Logged In</h2>
            <p>You are logged in as {{ auth()->user()->name }}.</p>
        </div>
    </div>
    @endauth

    @guest
    <div class="hero min-h-screen bg-base-200">
        <div class="hero-content text-center">
            <div class="max-w-md">
                <h1 class="text-5xl font-bold">{{ config('app.name') }}</h1>
                <p class="py-6">
                    By Cristo Issac Garcia Rivas V2
                </p>
            </div>
        </div>
    </div>
    @endguest
</div>
