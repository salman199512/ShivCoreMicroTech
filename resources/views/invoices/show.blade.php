<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-slate-800 leading-tight tracking-tight">
                {{ __('Invoice Document') }}: <span class="text-indigo-600">#{{ $invoice->invoice_no }}</span>
            </h2>
            <div class="flex gap-3">
                <button onclick="window.print()" class="inline-flex items-center px-6 py-3 bg-white border border-slate-200 rounded-xl font-bold text-sm text-slate-700 hover:bg-slate-50 transition shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2-2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Print PDF
                </button>
                <a href="{{ route('payments.index', ['invoice_id' => $invoice->id]) }}" class="btn-premium shadow-lg shadow-indigo-100">
                    Register Payment
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Invoice Summary Card -->
                <div class="lg:col-span-2">
                    <div class="premium-card p-8 bg-white relative overflow-hidden">
                        <!-- Watermark Status -->
                        <div class="absolute -right-8 -top-8 opacity-[0.03] pointer-events-none">
                            <h1 class="text-[12rem] font-black uppercase rotate-12">{{ $invoice->status }}</h1>
                        </div>

                        <div class="flex justify-between items-start mb-16">
                            <div>
                                <p class="text-[10px] font-black uppercase text-indigo-500 tracking-[0.2em] mb-4">Invoice From</p>
                                <h3 class="text-2xl font-black text-slate-900 mb-1">{{ config('app.name') }}</h3>
                                <p class="text-sm text-slate-400 font-medium">Billed to: <span class="text-slate-900 font-black">{{ $invoice->customer->name }}</span></p>
                            </div>
                            <div class="text-right">
                                <span class="px-5 py-2 rounded-2xl text-[10px] font-black uppercase tracking-widest
                                    @if($invoice->status == 'Paid') bg-emerald-50 text-emerald-600
                                    @elseif($invoice->status == 'Partial') bg-amber-50 text-amber-600
                                    @else bg-rose-50 text-rose-600 @endif">
                                    {{ $invoice->status }}
                                </span>
                                <p class="mt-4 text-[10px] font-black uppercase text-slate-400">Issue Date: {{ Carbon\Carbon::parse($invoice->invoice_date)->format('d M, Y') }}</p>
                            </div>
                        </div>

                        <div class="border-y border-slate-50 py-6 my-6 grid grid-cols-3 gap-6">
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Invoice Amount</p>
                                <p class="text-xl font-black text-slate-900">Rs. {{ number_format($invoice->amount, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Total Received</p>
                                <p class="text-xl font-black text-emerald-600">Rs. {{ number_format($invoice->received_amount, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Outstanding Due</p>
                                <p class="text-xl font-black text-rose-600">Rs. {{ number_format($invoice->due_amount, 2) }}</p>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <h4 class="text-xs font-black text-slate-900 uppercase tracking-widest">Transaction History</h4>
                            <table class="w-full text-left">
                                <thead class="text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">
                                    <tr>
                                        <th class="pb-3 px-2">Payment Date</th>
                                        <th class="pb-3 px-2 text-right">Amount Applied</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($invoice->payments as $payment)
                                        <tr class="border-b border-slate-50/50 last:border-0">
                                            <td class="py-4 px-2 font-bold text-slate-600">{{ Carbon\Carbon::parse($payment->payment_date)->format('d M, Y') }}</td>
                                            <td class="py-4 px-2 text-right font-black text-slate-900">Rs. {{ number_format($payment->amount, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="py-8 text-center text-slate-400 font-medium space-y-2">
                                                <div class="opacity-20 flex justify-center mb-2">
                                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                </div>
                                                <p>No payments recorded yet.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Timeline / Notifications Card -->
                <div class="space-y-6">
                    <div class="premium-card p-7 bg-slate-900 text-white border-none">
                        <h4 class="text-xs font-black uppercase tracking-widest text-indigo-400 mb-8 border-b border-white/5 pb-4">Communication Timeline</h4>
                        <div class="space-y-6">
                            @forelse($invoice->emailLogs as $log)
                                <div class="relative pl-8 before:content-[''] before:absolute before:left-3 before:top-2 before:bottom-0 before:w-[2px] before:bg-white/10 last:before:hidden">
                                    <div class="absolute left-0 top-1.5 w-6 h-6 rounded-full bg-indigo-500 border-4 border-slate-900"></div>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-white mb-1">{{ ucfirst($log->type) }} Sent</p>
                                    <p class="text-xs text-indigo-200 font-medium">{{ Carbon\Carbon::parse($log->sent_at)->diffForHumans() }}</p>
                                </div>
                            @empty
                                <p class="text-xs text-slate-500 font-medium italic">No automated reminders have been triggered yet.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="premium-card p-7 bg-white shadow-xl shadow-slate-100">
                        <h4 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-6 border-b border-slate-50 pb-4">Client Information</h4>
                        <div class="space-y-4">
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase mb-1">Email</p>
                                <p class="text-sm font-bold text-slate-900">{{ $invoice->customer->email }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase mb-1">Follow-up Rules</p>
                                <p class="text-sm font-bold text-slate-900">Team 1: {{ $invoice->customer->team1_days ?: 'Global' }} Days</p>
                                <p class="text-sm font-bold text-slate-900">Team 2: {{ $invoice->customer->team2_days ?: 'Global' }} Days</p>
                            </div>
                        </div>
                        <div class="mt-8">
                            <a href="{{ route('customers.detail', $invoice->customer->id) }}" class="block text-center py-3 bg-slate-50 rounded-xl text-xs font-black text-indigo-600 hover:bg-indigo-50 transition">View Customer Profile</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
