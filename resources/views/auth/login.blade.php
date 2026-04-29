<x-guest-layout>
    <div class="mb-8 text-center">
        <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-slate-900">Welcome Back </h1>
        <p class="mt-3 text-sm text-slate-500 max-w-lg mx-auto">Securely sign in to access your premium dashboard,
            invoices, payments, and customer insights.</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mt-6">
            <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember" class="premium-checkbox" style="width: 20px !important; height: 20px !important;">
                <span class="ms-2 text-sm text-slate-600 group-hover:text-slate-900 transition-colors">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <div class="mt-8">
            <x-primary-button class="btn-vibrant w-full py-4 text-base">
                {{ __('Secure Access') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>