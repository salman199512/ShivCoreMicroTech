<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-slate-800 leading-tight tracking-tight">
            {{ __('Onboard New Client') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="premium-card p-8">
                <div class="mb-8 text-center">
                    <div class="inline-flex p-4 rounded-full bg-indigo-50 text-indigo-600 mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-slate-800">Client Entry Form</h3>
                    <p class="text-sm text-slate-400 font-medium">Add a new organization or individual to your service registry.</p>
                </div>

                <form action="{{ route('customers.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-[10px] font-black uppercase text-slate-400 tracking-tighter mb-2">Display Name / Company</label>
                            <input type="text" name="name" id="name" class="block w-full border-slate-200 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 font-bold text-slate-700 h-14" placeholder="e.g. Acme Corp" required>
                        </div>

                        <div>
                            <label for="email" class="block text-[10px] font-black uppercase text-slate-400 tracking-tighter mb-2">Primary Email Address</label>
                            <input type="email" name="email" id="email" class="block w-full border-slate-200 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 font-bold text-slate-700 h-14" placeholder="client@example.com" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="team1_days" class="block text-[10px] font-black uppercase text-slate-400 tracking-tighter mb-2">Team 1 Override (Days)</label>
                            <input type="number" name="team1_days" id="team1_days" value="60" class="block w-full border-slate-200 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 font-black text-slate-800 h-14" required>
                            <p class="text-[10px] text-indigo-400 mt-2 font-bold uppercase tracking-widest">Global Default applied if left 60</p>
                        </div>

                        <div>
                            <label for="team2_days" class="block text-[10px] font-black uppercase text-slate-400 tracking-tighter mb-2">Team 2 Override (Days)</label>
                            <input type="number" name="team2_days" id="team2_days" value="5" class="block w-full border-slate-200 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 font-black text-slate-800 h-14" required>
                            <p class="text-[10px] text-indigo-400 mt-2 font-bold uppercase tracking-widest">Global Default applied if left 5</p>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full btn-premium py-3 text-sm uppercase tracking-[0.2em]">
                            Complete Onboarding
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
