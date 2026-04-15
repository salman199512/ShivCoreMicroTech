<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::whereHas('invoices', function($q) {
            $q->whereIn('status', ['Pending', 'Partial']);
        })->get();

        return view('payments.index', compact('customers'));
    }

    /**
     * Get invoices for a customer that are not fully paid.
     */
    public function getInvoices($customerId)
    {
        $invoices = Invoice::where('customer_id', $customerId)
            ->whereIn('status', ['Pending', 'Partial'])
            ->get();
        
        $invoices->each(function($invoice) {
            $invoice->due_amount = $invoice->due_amount; // Computed attribute
        });

        return response()->json($invoices);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_id' => 'required|exists:invoices,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
        ]);

        $invoice = Invoice::findOrFail($request->invoice_id);
        
        // Prevent overpayment
        if ($request->amount > $invoice->due_amount) {
            return redirect()->back()->withErrors(['amount' => 'Payment amount exceeds the due amount (Rs. ' . $invoice->due_amount . ')']);
        }

        Payment::create($request->all());

        // Update Invoice status
        $newDue = $invoice->due_amount; // This calculates including the new payment if using refreshed model, 
        // but here we just registered it. Let's refresh.
        $invoice = $invoice->fresh();
        
        if ($invoice->due_amount <= 0) {
            $invoice->status = 'Paid';
        } else {
            $invoice->status = 'Partial';
        }
        $invoice->save();

        return redirect()->route('payments.index')->with('success', 'Payment recorded successfully.');
    }
}
