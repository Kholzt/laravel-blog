<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mt-4">
        <h3 class="text-lg font-medium text-white">{{ __('Two-Factor Authentication') }}</h3>
        <p class="text-white">{{ __('Please enter the verification code sent to your authenticator app.') }}</p>

        <form method="POST" action="{{ route('2fa.verify') }}">
            @csrf
            <div class="mt-4">
                <x-input-label for="one_time_password" class="text-white" :value="__('Verification Code')" />
                <x-text-input id="one_time_password" class="block mt-1 w-full" type="text" name="one_time_password" required autofocus />
                <x-input-error :messages="$errors->get('one_time_password')" class="mt-2" />
            </div>

            <x-primary-button class="mt-4">
                {{ __('Verify') }}
            </x-primary-button>
        </form>
    </div>
</x-guest-layout>