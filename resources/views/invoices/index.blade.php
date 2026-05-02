<x-app-layout>
    <x-slot name="header">
        <div class="responsive-header animate-fade-up">
            <div>
                <h2 class="font-black text-3xl text-slate-800 leading-tight tracking-tighter">
                    Invoices
                </h2>
                <p class="text-sm text-slate-400 font-medium">Track billing, revenue, and payment status.</p>
            </div>
            <div class="flex flex-wrap gap-4">
                <button onclick="toggleImport()" style="height: 40px; border-radius: 12px" class="inline-flex items-center px-6 py-3 bg-white border border-slate-200 rounded-2xl font-black text-xs uppercase tracking-widest text-slate-700 hover:bg-slate-50 transition shadow-sm">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    Import
                </button>
                <a href="{{ route('invoices.create') }}" class="btn-vibrant">
                    <svg class="w-4 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Add Invoice
                </a>
            </div>
        </div>
    </x-slot>

    <div id="importSection" style="display: none" class="py-8 animate-fade-up">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="vibrant-card p-8 bg-[linear-gradient(135deg,#f8f9ff_0%,#f1f5f9_100%)] border-indigo-100 relative">
                <div class="flex items-start justify-between mb-8">
                    <div>
                        <h3 class="text-2xl font-black text-slate-800 mb-2 tracking-tighter">Import Invoices</h3>
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                            <p class="text-xs text-indigo-500 font-bold uppercase tracking-widest">Global Synchronization via Excel Schema</p>
                            <span class="text-slate-300 hidden sm:inline">|</span>
                            <a href="{{ asset('invoice.xlsx') }}" download class="text-xs text-emerald-600 hover:text-emerald-800 font-black uppercase tracking-widest flex items-center gap-2 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Download Sample
                            </a>
                        </div>
                    </div>
                    <button onclick="toggleImport()" class="text-slate-400 hover:text-slate-600 transition p-2">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form action="{{ route('invoices.import') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div class="flex flex-col sm:flex-row sm:items-center gap-4 sm:gap-6 bg-white p-4 rounded-3xl border border-slate-100 shadow-sm">
                        <div class="flex-grow">
                            <input type="file" name="file" class="block w-full text-sm text-slate-500 file:mr-3 sm:file:mr-6 file:py-3 sm:file:py-4 file:px-4 sm:file:px-8 file:rounded-2xl file:border-0 file:text-xs file:font-black file:uppercase file:tracking-widest file:bg-indigo-600 file:text-white hover:file:bg-black transition cursor-pointer" required>
                        </div>
                        <button type="submit" class="btn-vibrant py-4 px-10 text-xs sm:w-auto w-full">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="vibrant-card p-8 animate-fade-up" style="animation-delay: 0.2s">
                <div class="overflow-x-auto w-full">
                    <table class="w-full premium-table invoice-datatable">
                        <thead>
                            <tr class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">
                                <th>ID</th>
                                <th>Invoice No.</th>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th width="100px">Action</th>
                            </tr>
                        </thead>
                    <tbody class="text-slate-600 font-bold">
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    @endpush

    @push('scripts')
        <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
        <script type="text/javascript">
            function toggleImport() {
                var x = document.getElementById("importSection");
                if (x.style.display === "none") {
                    x.style.display = "block";
                } else {
                    x.style.display = "none";
                }
            }

            $(function () {
                var table = $('.invoice-datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('invoices.index') }}",
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                        {data: 'invoice_no', name: 'invoice_no'},
                        {data: 'invoice_date', name: 'invoice_date'},
                        {data: 'customer_name', name: 'customer_name'},
                        {data: 'amount', name: 'amount', render: function(data) { return 'Rs. ' + parseFloat(data).toFixed(2); }},
                        {data: 'status', name: 'status'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ]
                });
            });
        </script>
    @endpush
    </div>
</x-app-layout>
