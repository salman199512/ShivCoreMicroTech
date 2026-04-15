<x-guest-layout>
    <div class="mb-8 text-center">
        <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-slate-900">Reset your password</h1>
        <p class="mt-3 text-sm text-slate-500 max-w-lg mx-auto">Enter the email for your account and we'll send a secure reset link instantly.</p>
    </div>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
