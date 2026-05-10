<?php

namespace App\Http\Controllers;

use App\Models\EmailLog;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class EmailLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = EmailLog::with('invoice')->select('email_logs.*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('invoice_no', function($row){
                    if ($row->invoice) {
                        $url = route('invoices.show', $row->invoice_id);
                        return '<a href="'.$url.'" class="text-indigo-600 font-bold hover:text-indigo-800 transition">#'.$row->invoice->invoice_no.'</a>';
                    }
                    return '<span class="text-slate-400">N/A</span>';
                })
                ->addColumn('type', function($row){
                    $type = $row->type;
                    $class = '';
                    if(str_contains(strtolower($type), '1')) $class = 'bg-blue-50 text-blue-600';
                    elseif(str_contains(strtolower($type), '2')) $class = 'bg-amber-50 text-amber-600';
                    else $class = 'bg-purple-50 text-purple-600';
                    
                    return '<span class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest '.$class.'">'.$type.'</span>';
                })
                ->editColumn('sent_at', function($row){
                    if ($row->sent_at) {
                        return Carbon::parse($row->sent_at)->format('d M, Y \a\t h:i A');
                    }
                    return '-';
                })
                ->rawColumns(['invoice_no', 'type'])
                ->make(true);
        }

        return view('email_logs.index');
    }
}
