<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center animate-fade-up">
            <h2 class="font-black text-3xl text-slate-800 leading-tight tracking-tighter">
                Client <span class="text-indigo-600">Profile</span>: {{ $customer->name }}
            </h2>
            <div class="flex gap-4">
                <a href="{{ route('invoices.create', ['customer_id' => $customer->id]) }}" class="btn-vibrant bg-emerald-600 shadow-emerald-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    New Bill
                </a>
                <a href="{{ route('customers.edit', $customer->id) }}" class="inline-flex items-center px-8 py-3 bg-white border border-slate-100 rounded-2xl font-black text-xs uppercase tracking-widest text-slate-700 hover:bg-slate-50 transition shadow-sm">
                    Manage Identity
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="vibrant-card vibrant-card-indigo p-8 animate-fade-up" style="animation-delay: 0.1s">
                    <div class="flex items-center">
                        <div class="w-16 h-16 bg-primary-gradient text-white rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-100 me-6">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase text-indigo-400 tracking-[0.2em] mb-1">Total Billed</p>
                            <p class="text-3xl font-black text-slate-800 tracking-tighter">Rs. {{ number_format($stats['total'], 2) }}</p>
                        </div>
                    </div>
                </div>
                <div class="vibrant-card vibrant-card-success p-8 animate-fade-up" style="animation-delay: 0.2s">
                    <div class="flex items-center">
                        <div class="w-16 h-16 bg-success-gradient text-white rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-100 me-6">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase text-emerald-500 tracking-[0.2em] mb-1">Total Cleared</p>
                            <p class="text-3xl font-black text-slate-800 tracking-tighter">Rs. {{ number_format($stats['received'], 2) }}</p>
                        </div>
                    </div>
                </div>
                <div class="vibrant-card vibrant-card-danger p-8 animate-fade-up" style="animation-delay: 0.3s">
                    <div class="flex items-center">
                        <div class="w-16 h-16 bg-danger-gradient text-white rounded-2xl flex items-center justify-center shadow-lg shadow-rose-100 me-6">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase text-rose-500 tracking-[0.2em] mb-1">Open Liability</p>
                            <p class="text-3xl font-black text-slate-800 tracking-tighter">Rs. {{ number_format($stats['due'], 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Invoice History Table -->
            <div class="vibrant-card p-8 animate-fade-up" style="animation-delay: 0.4s">
                <h3 class="text-2xl font-black text-slate-800 mb-10 tracking-tighter">Financial Audit Logs</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left premium-table">
                        <thead>
                            <tr class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">
                                <th class="pb-6">Reference ID</th>
                                <th class="pb-6">Issued Date</th>
                                <th class="pb-6 text-right">Gross Value</th>
                                <th class="pb-6 text-right">Net Cleared</th>
                                <th class="pb-6 text-right">Net Open</th>
                                <th class="pb-6 text-center">Lifecycle</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customer->invoices as $invoice)
                                <tr class="hover:bg-slate-50/50 transition border-b border-slate-50 last:border-0">
                                    <td class="py-5 px-6 font-bold text-slate-600">#{{ $invoice->invoice_no }}</td>
                                    <td class="py-5 px-6 text-slate-400 font-medium">{{ Carbon\Carbon::parse($invoice->invoice_date)->format('M d, Y') }}</td>
                                    <td class="py-5 px-6 text-right font-black text-slate-800">Rs. {{ number_format($invoice->amount, 2) }}</td>
                                    <td class="py-5 px-6 text-right text-emerald-600 font-bold">Rs. {{ number_format($invoice->received_amount, 2) }}</td>
                                    <td class="py-5 px-6 text-right text-rose-600 font-bold">Rs. {{ number_format($invoice->due_amount, 2) }}</td>
                                    <td class="py-5 px-6 text-center">
                                        <span class="px-5 py-2 rounded-2xl text-[10px] font-black uppercase tracking-widest
                                            @if($invoice->status == 'Paid') bg-emerald-50 text-emerald-600
                                            @elseif($invoice->status == 'Partial') bg-amber-50 text-amber-600
                                            @else bg-rose-50 text-rose-600 @endif">
                                            {{ $invoice->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-slate-400 font-medium italic">No transaction history found for this client.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
