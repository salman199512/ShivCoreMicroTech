<x-guest-layout>
    <div class="mb-8 text-center">
        <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-slate-900">Confirm your password</h1>
        <p class="mt-3 text-sm text-slate-500 max-w-lg mx-auto">This is a secure section. Please confirm your account password to continue.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <x-primary-button>
                {{ __('Confirm') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
