<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Customer::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $viewBtn = '<a href="'.route('customers.detail', $row->id).'" class="text-indigo-600 hover:text-indigo-900 transition-colors mx-2" title="View Detail">
                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </a>';
                    $editBtn = '<a href="'.route('customers.edit', $row->id).'" class="text-amber-500 hover:text-amber-700 transition-colors mx-2" title="Edit Customer">
                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </a>';
                    $deleteBtn = '<form action="'.route('customers.destroy', $row->id).'" method="POST" class="inline">
                        '.csrf_field().'
                        '.method_field('DELETE').'
                        <button type="submit" class="text-rose-500 hover:text-rose-700 transition-colors mx-2" onclick="return confirm(\'Are you sure you want to delete this customer?\')" title="Delete Customer">
                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>';
                    return '<div class="flex items-center">'.$viewBtn.$editBtn.$deleteBtn.'</div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('customers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'email_2' => 'nullable|email',
            'email_3' => 'nullable|email',
            'team1_days' => 'required|integer',
            'team2_days' => 'required|integer',
        ]);

        Customer::create($request->all());
        session()->flash('alert-type', 'success');
        session()->flash('message', 'Customer has been created successfully!');
        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = Customer::with('invoices.payments')->findOrFail($id);

        $stats = [
            'total' => $customer->invoices->sum('amount'),
            'received' => $customer->invoices->sum(fn($i) => $i->payments->sum('amount')),
        ];
        $stats['due'] = $stats['total'] - $stats['received'];

        return view('customers.show', compact('customer', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'email_2' => 'nullable|email',
            'email_3' => 'nullable|email',
            'team1_days' => 'required|integer',
            'team2_days' => 'required|integer',
        ]);

        $customer = Customer::findOrFail($id);
        $customer->update($request->all());
        session()->flash('alert-type', 'success');
        session()->flash('message', 'Customer has been updated successfully!');
        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}
