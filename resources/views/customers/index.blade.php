<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center animate-fade-up">
            <h2 class="font-black text-3xl text-slate-800 leading-tight tracking-tighter">
                Customer <span class="text-indigo-600">Ecosystem</span>
            </h2>
            <a href="{{ route('customers.create') }}" class="btn-vibrant">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Deploy New Client
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="vibrant-card p-8 animate-fade-up" style="animation-delay: 0.2s">
                <table class="w-full premium-table customer-datatable">
                    <thead>
                        <tr class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">
                            <th>Identity ID</th>
                            <th>Global Descriptor</th>
                            <th>Secure Communication</th>
                            <th>Tier 1 Lead</th>
                            <th>Tier 2 Lead</th>
                            <th width="180px" class="text-center">Operations</th>
                        </tr>
                    </thead>
                    <tbody class="text-slate-600 font-bold">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('styles')
        <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
        <style>
            .customer-datatable thead {
                background-color: #f8fafc;
            }
            .customer-datatable th {
                font-weight: 600;
                color: #475569;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
        <script type="text/javascript">
            $(function () {
                var table = $('.customer-datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('customers.index') }}",
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                        {data: 'name', name: 'name'},
                        {data: 'email', name: 'email'},
                        {data: 'team1_days', name: 'team1_days'},
                        {data: 'team2_days', name: 'team2_days'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ]
                });
            });
        </script>
    @endpush
</x-app-layout>
