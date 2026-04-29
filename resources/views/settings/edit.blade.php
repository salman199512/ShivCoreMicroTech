<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-black text-2xl text-slate-800 leading-tight tracking-tight">
                {{ __('Setting') }}
            </h2>
            <p class="text-sm text-slate-400 font-medium">Configure your business profile and automation rules.</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('settings.update') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <!-- Business Identity -->
                    <div class="premium-card p-8">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-black text-slate-800 tracking-tight">Business Identity</h3>
                                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Public Profile Settings</p>
                            </div>
                        </div>
                        
                        <div class="space-y-6">
                            <div>
                                <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-2">Legal Company Name</label>
                                <input type="text" name="company_name" value="{{ $settings['company_name'] ?? '' }}" class="block w-full border-slate-200 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 font-bold text-slate-700 py-3">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-2">Corporate Correspondence Email</label>
                                <input type="email" name="company_email" value="{{ $settings['company_email'] ?? '' }}" class="block w-full border-slate-200 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 font-bold text-slate-700 py-3">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-2">Primary Contact Number</label>
                                <input type="text" name="company_phone" value="{{ $settings['company_phone'] ?? '' }}" class="block w-full border-slate-200 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 font-bold text-slate-700 py-3">
                            </div>
                        </div>
                    </div>

                    <!-- Follow-up Rules -->
                    <div class="premium-card p-8">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-black text-slate-800 tracking-tight">Follow-up Rules</h3>
                                <p class="text-xs text-amber-500 font-bold uppercase tracking-widest">Automation Intervals</p>
                            </div>
                        </div>

                        <div class="space-y-8">
                            <div class="bg-slate-50/50 p-6 rounded-2xl border border-slate-100">
                                <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-3">Team 1 Escalation (First Contact)</label>
                                <div class="flex items-center gap-4">
                                    <input type="number" name="team1_days" value="{{ $settings['team1_days'] ?? '60' }}" class="block w-full border-slate-200 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 font-black text-xl text-slate-800 py-3">
                                    <span class="text-slate-400 font-black text-xs uppercase tracking-widest">Days</span>
                                </div>
                                <p class="text-[10px] text-slate-400 mt-3 font-medium">Triggered X days after the original Invoice Date.</p>
                            </div>

                            <div class="bg-slate-50/50 p-6 rounded-2xl border border-slate-100">
                                <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-3">Team 2 Escalation (Critical)</label>
                                <div class="flex items-center gap-4">
                                    <input type="number" name="team2_days" value="{{ $settings['team2_days'] ?? '5' }}" class="block w-full border-slate-200 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 font-black text-xl text-slate-800 py-3">
                                    <span class="text-slate-400 font-black text-xs uppercase tracking-widest">Days</span>
                                </div>
                                <p class="text-[10px] text-slate-400 mt-3 font-medium">Triggered X days after the Team 1 reminder.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-12 flex items-center justify-center gap-6">
                    <a href="{{ route('dashboard') }}" class="w-[200px] btn-vibrant btn-danger py-4 text-sm font-black uppercase tracking-widest">
                        Cancel
                    </a>
                    <button type="submit" class="w-[200px] btn-premium shadow-2xl shadow-indigo-200 py-4 text-sm font-black tracking-widest uppercase">
                        Save Settings
                    </button>
                </div>
            </form>
    </div>
</x-app-layout>
