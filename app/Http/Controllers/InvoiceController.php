<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Customer;
use App\Imports\InvoicesImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Invoice::with('customer')->select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('customer_name', function($row){
                    return $row->customer->name;
                })
                ->addColumn('status', function($row){
                    $status = $row->status;
                    $class = '';
                    if($status == 'Paid') $class = 'bg-emerald-50 text-emerald-600';
                    elseif($status == 'Partial') $class = 'bg-amber-50 text-amber-600';
                    else $class = 'bg-rose-50 text-rose-600';
                    
                    return '<span class="px-5 py-2 rounded-2xl text-[10px] font-black uppercase tracking-widest '.$class.'">'.$status.'</span>';
                })
                ->addColumn('action', function($row){
                    $viewBtn = '<a href="'.route('invoices.show', $row->id).'" class="text-indigo-600 hover:text-indigo-900 transition-colors mx-2" title="View Invoice">
                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </a>';
                    $deleteBtn = '<form action="'.route('invoices.destroy', $row->id).'" method="POST" class="inline">
                        '.csrf_field().'
                        '.method_field('DELETE').'
                        <button type="submit" class="text-rose-500 hover:text-rose-700 transition-colors mx-2" onclick="return confirm(\'Are you sure you want to delete this invoice?\')" title="Delete Invoice">
                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>';
                    return '<div class="flex items-center">'.$viewBtn.$deleteBtn.'</div>';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        return view('invoices.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $customers = Customer::all();
        $selected_customer = $request->customer_id ?? null;
        return view('invoices.create', compact('customers', 'selected_customer'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'invoice_no' => 'required|unique:invoices',
            'invoice_date' => 'required|date',
            'customer_id' => 'required|exists:customers,id',
            'amount' => 'required|numeric',
        ]);

        Invoice::create($request->all());

        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
    }

    /**
     * Import invoices from excel.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new InvoicesImport, $request->file('file'));
            return redirect()->back()->with('success', 'Invoices imported successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $invoice = Invoice::with('customer', 'payments', 'emailLogs')->findOrFail($id);
        return view('invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();
        
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }

    /**
     * Send a manual reminder email for the invoice.
     */
    public function sendReminder(Request $request, string $id)
    {
        $invoice = Invoice::with('customer')->findOrFail($id);
        $customer = $invoice->customer;
        $settings = \App\Models\Setting::all()->pluck('value', 'key')->toArray();
        
        \Illuminate\Support\Facades\Mail::to($customer->email)->send(new \App\Mail\ReminderEmail($customer, [$invoice], 'Manual Reminder', $settings));
        
        \App\Models\EmailLog::create([
            'invoice_id' => $invoice->id,
            'type' => 'Manual Reminder',
            'sent_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Reminder sent successfully!');
    }
}
