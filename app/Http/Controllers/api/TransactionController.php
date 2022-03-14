<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\transaction\StoreTransactionRequest;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::all();
        return $transactions;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransactionRequest $request)
    {
        $current_date = date('Y-m-d H:i:s');

        try {
            $transaction = Transaction::create([
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
                'amount' => $request->amount,
                'payer_id' => Auth::id(),
                'due_on' => $request->due_on,
                'vat' => $request->vat,
                'is_vat_inclusive' => $request->is_vat_inclusive == true ? 1 : 0,
                'status' => $current_date < $request->due_on ? 'outstanding' : 'overdue'
            ]);

            return $transaction;
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        $total_paid_amount = $transaction->payments()->get()->sum('amount');
        if ($transaction->amount === $total_paid_amount) {
            $transaction->update(['status' => 'paid']);
        }
        return $transaction;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function my_transaction(Transaction $transaction)
    {
        // return Auth::user();
        if (Auth::id() === $transaction->payer_id) {
            return $transaction;
        }

        return response()->json(['message' => 'Unauthorized to view other transactions']);
    }
}
