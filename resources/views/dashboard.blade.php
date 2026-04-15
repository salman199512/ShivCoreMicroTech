<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @php
        $totalInvoiced = \App\Models\Invoice::sum('amount');
        $totalReceived = \App\Models\Payment::sum('amount');
        $totalDue = $totalInvoiced - $totalReceived;
        
        $recentInvoices = \App\Models\Invoice::with('customer')->latest()->take(5)->get();
    @endphp

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="vibrant-card vibrant-card-indigo p-8 animate-fade-up" style="animation-delay: 0.1s">
                    <div class="flex items-center mb-8">
                        <div class="w-14 h-14 bg-primary-gradient text-white rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-100 me-6">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase text-indigo-400 tracking-[0.2em] mb-1">Total Invoiced</p>
                            <p class="text-4xl font-black text-slate-800 tracking-tighter">Rs. {{ number_format($totalInvoiced, 2) }}</p>
                        </div>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                        <div class="bg-primary-gradient h-full rounded-full transition-all duration-1000" style="width: 100%"></div>
                    </div>
                </div>

                <div class="vibrant-card vibrant-card-success p-8 animate-fade-up" style="animation-delay: 0.2s">
                    <div class="flex items-center mb-8">
                        <div class="w-14 h-14 bg-success-gradient text-white rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-100 me-6">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase text-emerald-500 tracking-[0.2em] mb-1">Total Received</p>
                            <p class="text-4xl font-black text-slate-800 tracking-tighter">Rs. {{ number_format($totalReceived, 2) }}</p>
                        </div>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                        <div class="bg-success-gradient h-full rounded-full transition-all duration-1000" style="width: {{ $totalInvoiced > 0 ? ($totalReceived / $totalInvoiced) * 100 : 0 }}%"></div>
                    </div>
                </div>

                <div class="vibrant-card vibrant-card-danger p-8 animate-fade-up" style="animation-delay: 0.3s">
                    <div class="flex items-center mb-8">
                        <div class="w-14 h-14 bg-danger-gradient text-white rounded-2xl flex items-center justify-center shadow-lg shadow-rose-100 me-6">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase text-rose-500 tracking-[0.2em] mb-1">Total Outstanding</p>
                            <p class="text-4xl font-black text-slate-800 tracking-tighter">Rs. {{ number_format($totalDue, 2) }}</p>
                        </div>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                        <div class="bg-danger-gradient h-full rounded-full transition-all duration-1000" style="width: {{ $totalInvoiced > 0 ? ($totalDue / $totalInvoiced) * 100 : 0 }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="vibrant-card p-8 animate-fade-up" style="animation-delay: 0.4s">
                <div class="flex justify-between items-center mb-10 pb-6 border-b border-slate-50">
                    <div>
                        <h3 class="text-2xl font-black text-slate-800 tracking-tighter">Real-time Revenue Stream</h3>
                        <p class="text-sm text-slate-400 font-medium">Monitoring the latest inbound transactions and billing cycles.</p>
                    </div>
                    <a href="{{ route('invoices.index') }}" class="btn-vibrant py-3 px-6 text-xs uppercase tracking-widest">
                        Intelligence Hub &rarr;
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left premium-table">
                        <thead>
                            <tr class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">
                                <th class="pb-6">Customer Segment</th>
                                <th class="pb-6">Doc Ref</th>
                                <th class="pb-6 text-right">Settlement Value</th>
                                <th class="pb-6 text-center">Lifecycle Stage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentInvoices as $invoice)
                                <tr class="hover:bg-slate-50 transition-colors border-b border-slate-50/50 last:border-0 group">
                                    <td class="py-6 font-bold text-slate-700">{{ $invoice->customer->name }}</td>
                                    <td class="py-6 text-indigo-400 font-black">#{{ $invoice->invoice_no }}</td>
                                    <td class="py-6 text-right font-black text-slate-900">Rs. {{ number_format($invoice->amount, 2) }}</td>
                                    <td class="py-6 text-center">
                                        <span class="px-5 py-2 rounded-2xl text-[10px] font-black uppercase tracking-widest
                                            @if($invoice->status == 'Paid') bg-emerald-50 text-emerald-600
                                            @elseif($invoice->status == 'Partial') bg-amber-50 text-amber-600
                                            @else bg-rose-50 text-rose-600 @endif">
                                            {{ $invoice->status }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
