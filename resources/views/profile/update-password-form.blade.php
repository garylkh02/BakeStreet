<x-form-section submit="updatePassword">
    <x-slot name="title">
        {{ __('Update Password') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Ensure your account is using a long, random password to stay secure.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-label for="current_password" value="{{ __('Current Password') }}" />
            <div class="relative">
                <x-input id="current_password" type="password" class="mt-1 block w-full pr-10" wire:model="state.current_password" autocomplete="current-password" />
                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600" onclick="togglePasswordVisibility('current_password')">
                    <i id="current_password_icon" class="fa fa-eye"></i>
                </button>
            </div>
            <x-input-error for="current_password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password" value="{{ __('New Password') }}" />
            <div class="relative">
                <x-input id="password" type="password" class="mt-1 block w-full pr-10" wire:model="state.password" autocomplete="new-password" />
                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600" onclick="togglePasswordVisibility('password')">
                    <i id="password_icon" class="fa fa-eye"></i>
                </button>
            </div>
            <small class="text-gray-600">
                Password must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, and one number.
            </small>
            <x-input-error for="password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
            <div class="relative">
                <x-input id="password_confirmation" type="password" class="mt-1 block w-full pr-10" wire:model="state.password_confirmation" autocomplete="new-password" />
                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600" onclick="togglePasswordVisibility('password_confirmation')">
                    <i id="password_confirmation_icon" class="fa fa-eye"></i>
                </button>
            </div>
            <x-input-error for="password_confirmation" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
        @if (session('status'))
            <span class="alert alert-success mb-4">
                {{ session('status') }}
            </span>
            &nbsp;&nbsp;&nbsp;
        @endif
            {{ __('Saved.') }}
        </x-action-message>

        <x-button>
            {{ __('Save') }}
        </x-button>
    </x-slot>
</x-form-section>

<script>
    function togglePasswordVisibility(fieldId) {
        const passwordField = document.getElementById(fieldId);
        const icon = document.getElementById(`${fieldId}_icon`);
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
