<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\TransactionsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        /** @var \App\Models\User $user */
        $transactions = $user->transactions()
            ->with('stock')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('transactions.index', compact('transactions'));
    }

    public function exportExcel()
    {
        return Excel::download(new TransactionsExport, 'my_transactions.xlsx');
    }

    public function exportPdf()
    {
        $user = Auth::user();
        /** @var \App\Models\User $user */
        $transactions = $user->transactions()->with('stock')->orderBy('created_at', 'desc')->get();

        $pdf = Pdf::loadView('exports.transactions_pdf', compact('transactions'));
        return $pdf->download('my_transactions.pdf');
    }
}
