<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-slate-800 leading-tight tracking-tight">
            {{ __('Organization Settings') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('settings.update') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <!-- Company Information -->
                    <div class="lg:col-span-1 space-y-6">
                        <div class="premium-card p-7">
                            <h3 class="text-xs font-black text-indigo-600 uppercase tracking-widest mb-6 border-b border-indigo-50 pb-3">Business Identity</h3>
                            <div class="space-y-5">
                                <div>
                                    <label class="block text-[10px] font-black uppercase text-slate-400 tracking-tighter mb-2">Legal Company Name</label>
                                    <input type="text" name="company_name" value="{{ $settings['company_name'] ?? '' }}" class="block w-full border-slate-200 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 font-bold text-slate-700">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black uppercase text-slate-400 tracking-tighter mb-2">Corporate Correspondence Email</label>
                                    <input type="email" name="company_email" value="{{ $settings['company_email'] ?? '' }}" class="block w-full border-slate-200 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 font-bold text-slate-700">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black uppercase text-slate-400 tracking-tighter mb-2">Primary Contact Number</label>
                                    <input type="text" name="company_phone" value="{{ $settings['company_phone'] ?? '' }}" class="block w-full border-slate-200 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 font-bold text-slate-700">
                                </div>
                            </div>
                        </div>

                        <div class="premium-card p-7">
                            <h3 class="text-xs font-black text-indigo-600 uppercase tracking-widest mb-5 border-b border-indigo-50 pb-3">Team Follow-up Rules</h3>
                            <div class="space-y-5">
                                <div>
                                    <label class="block text-[10px] font-black uppercase text-slate-400 tracking-tighter mb-2">Team 1 Escalation</label>
                                    <div class="flex items-center gap-3">
                                        <input type="number" name="team1_days" value="{{ $settings['team1_days'] ?? '60' }}" class="block w-full border-slate-200 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 font-black text-slate-800">
                                        <span class="text-slate-400 font-black text-xs uppercase tracking-widest">Days</span>
                                    </div>
                                    <p class="text-[10px] text-slate-400 mt-2 italic">Standard: Invoice Date + X</p>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black uppercase text-slate-400 tracking-tighter mb-2">Team 2 Escalation</label>
                                    <div class="flex items-center gap-3">
                                        <input type="number" name="team2_days" value="{{ $settings['team2_days'] ?? '5' }}" class="block w-full border-slate-200 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 font-black text-slate-800">
                                        <span class="text-slate-400 font-black text-xs uppercase tracking-widest">Days</span>
                                    </div>
                                    <p class="text-[10px] text-slate-400 mt-2 italic">Standard: Team 1 + X</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Email Templates -->
                    <div class="lg:col-span-2">
                        <div class="premium-card p-7">
                            <h3 class="text-xs font-black text-indigo-600 uppercase tracking-widest mb-5 border-b border-indigo-50 pb-3">Automated Communication Templates</h3>
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-[10px] font-black uppercase text-indigo-400 mb-3 bg-indigo-50 inline-block px-3 py-1 rounded-full">Phase 1: Team 1 Notification Message</label>
                                    <textarea name="team1_template" rows="5" class="block w-full border-slate-200 rounded-2xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 font-medium text-slate-600 leading-relaxed p-4">{{ $settings['team1_template'] ?? '' }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black uppercase text-rose-400 mb-3 bg-rose-50 inline-block px-3 py-1 rounded-full">Phase 2: Critical Team 2 Escalation</label>
                                    <textarea name="team2_template" rows="5" class="block w-full border-slate-200 rounded-2xl shadow-sm focus:ring-rose-500 focus:border-rose-500 font-medium text-slate-600 leading-relaxed p-4">{{ $settings['team2_template'] ?? '' }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black uppercase text-emerald-400 mb-3 bg-emerald-50 inline-block px-3 py-1 rounded-full">Recurring Routine Reminder</label>
                                    <textarea name="recurring_template" rows="5" class="block w-full border-slate-200 rounded-2xl shadow-sm focus:ring-emerald-500 focus:border-emerald-500 font-medium text-slate-600 leading-relaxed p-4">{{ $settings['recurring_template'] ?? '' }}</textarea>
                                </div>
                                <div class="bg-indigo-900/5 p-6 rounded-2xl border border-indigo-100/50">
                                    <p class="text-[10px] text-indigo-900 font-black uppercase tracking-widest mb-3">Dynamic Smart Placeholders</p>
                                    <div class="flex flex-wrap gap-2">
                                        <code class="text-[10px] font-black bg-white px-2 py-1 rounded border border-indigo-100 text-indigo-600">{customer_name}</code>
                                        <code class="text-[10px] font-black bg-white px-2 py-1 rounded border border-indigo-100 text-indigo-600">{invoice_no}</code>
                                        <code class="text-[10px] font-black bg-white px-2 py-1 rounded border border-indigo-100 text-indigo-600">{amount}</code>
                                        <code class="text-[10px] font-black bg-white px-2 py-1 rounded border border-indigo-100 text-indigo-600">{company_name}</code>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-10 flex justify-end">
                            <button type="submit" class="btn-premium shadow-xl shadow-indigo-100 px-12 py-4 text-sm tracking-widest uppercase">
                                Deploy Systems Configuration
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</x-app-layout>
