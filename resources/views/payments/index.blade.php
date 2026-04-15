<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-slate-800 leading-tight tracking-tight">
            {{ __('Financial Settlement') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="premium-card p-8">
                <div class="mb-8 text-center">
                    <div class="inline-flex p-4 rounded-full bg-indigo-50 text-indigo-600 mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-slate-800">Register Incoming Payment</h3>
                    <p class="text-sm text-slate-400 font-medium">Link customer receipts to outstanding service invoices.</p>
                </div>

                @if ($errors->any())
                    <div class="bg-rose-50 border-l-4 border-rose-400 p-6 mb-8 rounded-xl">
                        <ul class="list-disc list-inside text-sm text-rose-600 font-bold">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('payments.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="customer_id" class="block text-[10px] font-black uppercase text-slate-400 tracking-tighter mb-2">Select Active Client</label>
                        <select name="customer_id" id="customer_id" class="block w-full border-slate-200 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 font-bold text-slate-700 h-14" required>
                            <option value="">-- Search and Choose Client --</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="hidden animate-fade-in" id="invoice_group">
                        <label for="invoice_id" class="block text-[10px] font-black uppercase text-slate-400 tracking-tighter mb-2">Select Pending Bill</label>
                        <select name="invoice_id" id="invoice_id" class="block w-full border-slate-200 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 font-bold text-slate-700 h-14" required>
                            <option value="">-- Choose Invoice --</option>
                        </select>
                        <div id="due_notice_container" class="mt-4 p-4 bg-indigo-50 rounded-xl border border-indigo-100 hidden">
                             <p id="due_notice" class="text-sm text-indigo-600 font-black"></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="amount" class="block text-[10px] font-black uppercase text-slate-400 tracking-tighter mb-2">Amount Received (Rs.)</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-black text-sm">Rs.</span>
                                <input type="number" step="0.01" name="amount" id="amount" class="block w-full border-slate-200 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 font-black text-slate-800 h-14 pl-12" placeholder="0.00" required>
                            </div>
                        </div>

                        <div>
                            <label for="payment_date" class="block text-[10px] font-black uppercase text-slate-400 tracking-tighter mb-2">Processing Date</label>
                            <input type="date" name="payment_date" id="payment_date" value="{{ date('Y-m-d') }}" class="block w-full border-slate-200 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 font-black text-slate-800 h-14" required>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full btn-premium py-3 text-sm uppercase tracking-[0.2em]">
                            Authorize Payment Entry
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script type="text/javascript">
            $(function () {
                $('#customer_id').change(function() {
                    var customerId = $(this).val();
                    if (customerId) {
                        $('#invoice_group').removeClass('hidden');
                        $('#invoice_id').empty().append('<option value="">-- Loading... --</option>');
                        
                        $.get('/payments/get-invoices/' + customerId, function(data) {
                            $('#invoice_id').empty().append('<option value="">-- Choose Invoice --</option>');
                            $.each(data, function(index, invoice) {
                                $('#invoice_id').append('<option value="'+invoice.id+'" data-due="'+invoice.due_amount+'">'+invoice.invoice_no+' (Due: Rs. '+invoice.due_amount+')</option>');
                            });
                        });
                    } else {
                        $('#invoice_group').addClass('hidden');
                    }
                });

                $('#invoice_id').change(function() {
                    var due = $(this).find(':selected').data('due');
                    if (due) {
                        $('#due_notice').text('Total Due for this invoice: Rs. ' + due);
                        $('#amount').val(due);
                    } else {
                        $('#due_notice').text('');
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
