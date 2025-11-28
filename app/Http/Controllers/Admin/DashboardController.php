<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Topup;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\AdminTransactionsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalTransactions = Transaction::count();

        // Mengambil hitungan total Pending Topups untuk kotak statistik
        $pendingTopupsCount = Topup::where('status', 'pending')->count();

        // Membuat daftar ringkasan dashboard
        $pendingTopups = Topup::with('user')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $totalVolume = Transaction::where('type', 'buy')->sum('total');

        $recentTransactions = Transaction::with('user', 'stock')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalTransactions',
            'pendingTopups',
            'pendingTopupsCount',
            'totalVolume',
            'recentTransactions'
        ));
    }

    public function exportExcel()
    {
        return Excel::download(new AdminTransactionsExport, 'all_transactions_report.xlsx');
    }

    public function exportPdf()
    {

        $transactions = Transaction::with(['user', 'stock'])
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = Pdf::loadView('exports.admin_transactions_pdf', compact('transactions'));

        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('all_transactions_report.pdf');
    }
}
