<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Transaction;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0.01',
            'currency' => 'required|string|size:3',
            'details' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $transaction = new Transaction();
        $transaction->transaction_id = Str::uuid();
        $transaction->amount = $request->input('amount');
        $transaction->currency = strtoupper($request->input('currency'));
        $transaction->status = 'pending';
        $transaction->details = $request->input('details');
        $transaction->save();

        return response()->json([
            'message' => 'Transaction created successfully',
            'status' => 'pending',
            'transaction_id' => $transaction->transaction_id
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $transaction_id)
{
    $transaction = Transaction::where('transaction_id', $transaction_id)->first();

    if (!$transaction) {
        return response()->json(['error' => 'Transaction not found'], 404);
    }

    return response()->json([
        'transaction_id' => $transaction->transaction_id,
        'status' => $transaction->status,
        'amount' => $transaction->amount,
        'currency' => $transaction->currency,
        'created_at' => $transaction->created_at,
        'updated_at' => $transaction->updated_at,
    ]);
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
        //
    }
}
