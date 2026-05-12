<x-app-layout>
    <x-slot name="header">
        <div class="responsive-header">
            <div>
                <h2 class="font-black text-3xl sm:text-4xl text-slate-800 leading-tight tracking-tighter mb-1">
                    Invoice Logs
                </h2>
                <p class="text-xs sm:text-sm text-slate-400 font-medium">Tracking all sent reminders and notifications.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="vibrant-card p-8 animate-fade-up">
                <div class="overflow-x-auto w-full">
                    <table class="w-full premium-table emaillog-datatable">
                        <thead>
                            <tr class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">
                                <th class="pb-6">No</th>
                                <th class="pb-6">Invoice No.</th>
                                <th class="pb-6">Customer</th>
                                <th class="pb-6">Total Amount</th>
                                <th class="pb-6">Received</th>
                                <th class="pb-6">Due</th>
                                <th class="pb-6">Reminder Type</th>
                                <th class="pb-6">Sent Date</th>
                            </tr>
                        </thead>
                        <tbody>
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
            $(function () {
                var table = $('.emaillog-datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('invoice-logs.index') }}",
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                        {data: 'invoice_no', name: 'invoice.invoice_no'},
                        {data: 'customer_name', name: 'invoice.customer.name', orderable: false, searchable: true},
                        {data: 'total_amount', name: 'invoice.amount', orderable: false, searchable: false},
                        {data: 'received_amount', name: 'invoice.received_amount', orderable: false, searchable: false},
                        {data: 'due_amount', name: 'invoice.due_amount', orderable: false, searchable: false},
                        {data: 'type', name: 'type'},
                        {data: 'sent_at', name: 'sent_at'},
                    ],
                    language: {
                        search: "",
                        searchPlaceholder: "Search logs...",
                        paginate: {
                            previous: "Prev",
                            next: "Next"
                        }
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
