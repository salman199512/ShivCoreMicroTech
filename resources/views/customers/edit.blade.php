<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-slate-800 leading-tight tracking-tight">
            {{ __('Update Client Details') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="premium-card p-8">
                <div class="mb-8 text-center">
                    <div class="inline-flex p-4 rounded-full bg-indigo-50 text-indigo-600 mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-slate-800">Edit Client Registry</h3>
                    <p class="text-sm text-slate-400 font-medium">Modify existing organization records or follow-up rules.</p>
                </div>

                <form action="{{ route('customers.update', $customer->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-[10px] font-black uppercase text-slate-400 tracking-tighter mb-2">Display Name / Company</label>
                            <input type="text" name="name" id="name" value="{{ $customer->name }}" class="block w-full border-slate-200 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 font-bold text-slate-700 h-14" required>
                        </div>

                        <div>
                            <label for="email" class="block text-[10px] font-black uppercase text-slate-400 tracking-tighter mb-2">Primary Email Address</label>
                            <input type="email" name="email" id="email" value="{{ $customer->email }}" class="block w-full border-slate-200 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 font-bold text-slate-700 h-14" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="team1_days" class="block text-[10px] font-black uppercase text-slate-400 tracking-tighter mb-2">Team 1 Override (Days)</label>
                            <input type="number" name="team1_days" id="team1_days" value="{{ $customer->team1_days ?? 60 }}" class="block w-full border-slate-200 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 font-black text-slate-800 h-14" required>
                        </div>

                        <div>
                            <label for="team2_days" class="block text-[10px] font-black uppercase text-slate-400 tracking-tighter mb-2">Team 2 Override (Days)</label>
                            <input type="number" name="team2_days" id="team2_days" value="{{ $customer->team2_days ?? 5 }}" class="block w-full border-slate-200 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 font-black text-slate-800 h-14" required>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full btn-premium py-3 text-sm uppercase tracking-[0.2em]">
                            Update Financial Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
