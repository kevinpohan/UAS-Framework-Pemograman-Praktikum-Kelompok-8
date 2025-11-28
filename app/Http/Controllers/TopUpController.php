<?php

namespace App\Http\Controllers;

use App\Models\Topup;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopUpController extends Controller
{
    public function create()
    {
        return view('topup.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10',
            'proof' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $topup = new Topup();
        $topup->user_id = Auth::id();
        $topup->amount = $request->amount;

        if ($request->hasFile('proof')) {
            $path = $request->file('proof')->store('topup-proofs', 'public');
            $topup->proof = $path;
        }

        $topup->save();

        return redirect()->route('topup.create')->with('success', 'Top-up request submitted successfully. Awaiting admin approval.');
    }
}
