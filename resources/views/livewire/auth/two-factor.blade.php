<div class="h-[calc(100vh-theme(space.32))]">
    <div class="card mx-auto mt-8 w-96 bg-base-200 shadow-xl">
        <div class="card-body">
            <h2 class="card-title">Two Factor Authentication</h2>

            <form wire:submit.prevent="confirm">
                <x-input for="code" label="Code" />

                <div class="card-actions mt-4 justify-end">
                    <button type="button" class="btn" wire:click="cancel">Cancel</button>
                    <button type="submit" class="btn btn-primary">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>
