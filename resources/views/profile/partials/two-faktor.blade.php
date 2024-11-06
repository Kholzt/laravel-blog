<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Enable Two-Factor Authentication') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Two-factor authentication adds an extra layer of security to your account. Please scan the QR code with your authenticator app.') }}
        </p>
    </header>

    <div class="flex items-center justify-center">
        <!-- <img src="{{ $QRCodeUrl }}" alt="QR Code" class="w-1/3 h-auto" /> -->
        {{!! $QRCodeUrl !!}}
    </div>

    <form method="POST" action="{{ route('2fa.enable') }}">
        <div class="mt-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('Or enter the secret key manually:') }}
            </p>
            <div class="mt-2">
                <x-input-label for="google2fa_secret" :value="__('Secret Key')" />
                <x-text-input
                    id="google2fa_secret"
                    name="google2fa_secret"
                    type="text"
                    value="{{ $secret }}"
                    class="mt-1 block w-3/4"
                    readonly />
            </div>
        </div>

        <div class="mt-6 flex items-center">
            <label class="inline-flex items-center cursor-pointer">
                <input type="checkbox" id="2fa_toggle" class="sr-only peer"
                    {{ $user->two_factor_enabled ? 'checked' : '' }}>
                <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">ENABLE 2-FA</span>
            </label>
        </div>

        <div class="mt-6 flex justify-start">
            @csrf
            <input type="hidden" name="enabled" id="enabled" value="0">
            <input type="hidden" name="disabled" id="disabled" value="0">
            <x-primary-button id="submit-btn">
                {{ __('Save') }}
            </x-primary-button>
        </div>
    </form>
</section>

<script>
    const toggleSwitch = document.getElementById('2fa_toggle');
    const enabledInput = document.getElementById('enabled');
    const disabledInput = document.getElementById('disabled');

    // Initialize inputs based on toggle state
    toggleSwitch.addEventListener('change', function() {
        if (this.checked) {
            enabledInput.value = 1; // Set enabled to 1
            disabledInput.value = 0; // Set disabled to 0
        } else {
            enabledInput.value = 0; // Set enabled to 0
            disabledInput.value = 1; // Set disabled to 1
        }
    });

    // Trigger change event to set initial values
    toggleSwitch.dispatchEvent(new Event('change'));
</script>