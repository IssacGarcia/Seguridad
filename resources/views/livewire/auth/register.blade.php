<div class="h-[calc(100vh-theme(space.32))]">
    <div class="card mx-auto mt-8 w-96 bg-base-200 shadow-xl">
        <div class="card-body">
            <h2 class="card-title">Register</h2>

            <form wire:submit.prevent="register">
                <x-input for="name" label="Name" />
                <x-input for="email" type="email" label="Email" />
                <x-input for="password" type="password" label="Password" />
                <x-input for="password_confirmation" type="password" label="Confirm Password" />

                <div class="card-actions mt-4 justify-end">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </form>
        </div>
    </div>
</div>
