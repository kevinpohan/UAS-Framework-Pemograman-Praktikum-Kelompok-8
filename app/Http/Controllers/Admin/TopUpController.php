<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Topup;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TopUpController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->input('sort', 'created_at');
        $direction = $request->input('direction', 'desc');

        $allowedSorts = ['amount', 'status', 'created_at'];
        if (!in_array($sort, $allowedSorts)) $sort = 'created_at';
        $direction = $direction === 'asc' ? 'asc' : 'desc';

        $topups = Topup::with('user')
            ->orderBy($sort, $direction)
            ->paginate(15)
            ->appends(['sort' => $sort, 'direction' => $direction]);

        return view('admin.topups.index', compact('topups', 'sort', 'direction'));
    }

    public function approve(Topup $topup)
    {
        if ($topup->status !== 'pending') {
            return redirect()->back()->with('error', 'Top-up request is not pending.');
        }

        DB::transaction(function () use ($topup) {
            $topup->update([
                'status' => 'approved',
                'admin_id' => Auth::id(),
            ]);

            $user = $topup->user;
            $user->increment('balance', $topup->amount);

            // Membuat transaction record
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'topup',
                'total' => $topup->amount,
                'status' => 'completed',
                'meta' => ['topup_id' => $topup->id],
            ]);
        });

        return redirect()->back()->with('success', 'Top-up approved successfully.');
    }

    public function reject(Topup $topup, Request $request)
    {
        if ($topup->status !== 'pending') {
            return redirect()->back()->with('error', 'Top-up request is not pending.');
        }

        $topup->update([
            'status' => 'rejected',
            'admin_id' => Auth::id(),
            'note' => $request->note,
        ]);

        return redirect()->back()->with('success', 'Top-up rejected successfully.');
    }
}
