<x-app-layout>
    <x-slot name="header">
        <div class="animate-fade-up">
            <h2 class="font-black text-2xl text-slate-800 leading-tight tracking-tight">
                {{ __('Profile') }}
            </h2>
            <p class="text-sm text-slate-400 font-medium">Manage your personal account details and security settings.</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="vibrant-card p-8 animate-fade-up" style="animation-delay: 0.1s">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="vibrant-card p-8 animate-fade-up" style="animation-delay: 0.2s">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
