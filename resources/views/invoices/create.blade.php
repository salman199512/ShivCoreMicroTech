<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-slate-800 leading-tight tracking-tight">
            {{ __('Generate Service Invoice') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="premium-card p-8">
                <div class="mb-8 text-center">
                    <div class="inline-flex p-4 rounded-full bg-indigo-50 text-indigo-600 mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-slate-800">Billing Information</h3>
                    <p class="text-sm text-slate-400 font-medium">Generate a professional financial statement for your client.</p>
                </div>

                <form action="{{ route('invoices.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="customer_id" class="block text-[10px] font-black uppercase text-slate-400 tracking-tighter mb-2">Billed Client</label>
                        <select name="customer_id" id="customer_id" class="block w-full border-slate-200 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 font-bold text-slate-700 h-14" required>
                            <option value="">-- Choose Target Client --</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ $selected_customer == $customer->id ? 'selected' : '' }}>{{ $customer->name }} ({{ $customer->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="invoice_no" class="block text-[10px] font-black uppercase text-slate-400 tracking-tighter mb-2">Internal Reference No</label>
                            <input type="text" name="invoice_no" id="invoice_no" value="INV-{{ strtoupper(Str::random(6)) }}" class="block w-full border-slate-200 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 font-black text-slate-800 h-14" required>
                        </div>

                        <div>
                            <label for="invoice_date" class="block text-[10px] font-black uppercase text-slate-400 tracking-tighter mb-2">Issuance Date</label>
                            <input type="date" name="invoice_date" id="invoice_date" value="{{ date('Y-m-d') }}" class="block w-full border-slate-200 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 font-black text-slate-800 h-14" required>
                        </div>
                    </div>

                    <div>
                        <label for="amount" class="block text-[10px] font-black uppercase text-slate-400 tracking-tighter mb-2">Total Service Amount (Rs.)</label>
                        <div class="relative">
                            <span class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 font-black text-sm">Rs.</span>
                            <input type="number" step="0.01" name="amount" id="amount" class="block w-full border-slate-200 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 font-black text-slate-800 h-14 pl-14" placeholder="0.00" required>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full btn-premium py-3 text-sm uppercase tracking-[0.2em]">
                            Generate & Commit Invoice
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
