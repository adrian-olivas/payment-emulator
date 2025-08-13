<?php

namespace App\Http\Controllers\Admin;

use App\Models\Transaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $transactions = Transaction::latest()->paginate(15);
        return view('admin.dashboard', ['transactions' => $transactions]);
    }

    public function complete(Transaction $transaction)
{
    if ($transaction->status === 'pending') {
        $transaction->status = 'success';
        $transaction->save();
    }
    return redirect()->route('admin.dashboard');
}

public function fail(Transaction $transaction)
{
    if ($transaction->status === 'pending') {
        $transaction->status = 'decline';
        $transaction->save();
    }
    return redirect()->route('admin.dashboard');
}
}
