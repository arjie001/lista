<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Transaction;
use App\Models\Wallet;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Inertia\Inertia;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($branch_code)
    {
        $user = Auth::user();
        $branch = Branch::whereCode($branch_code)->first();
        $transactions = Transaction::where(['branch_id' => $branch->id])->get();
        $wallets = Wallet::where(['team_id' => $user->currentTeam->id])->get();
        return Inertia::render('BranchTransactions/Index', [
            'branch' => $branch,
            'wallets' => $wallets,
            'transactions' => $transactions
        ]);
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
    public function store(Request $request, $branch_code)
    {
        $branch = Branch::whereCode($branch_code)->first();
        $user = Auth::user();

        $wallet_in = Wallet::find($request->list_data['money_in']['wallet_id']);
        $wallet_in->update([
            'balance' => $wallet_in->balance + $request->list_data['money_in']['amount']
        ]);

        $wallet_out = Wallet::find($request->list_data['money_out']['wallet_id']);
        $wallet_out->update([
            'balance' => $wallet_out->balance - $request->list_data['money_out']['amount']
        ]);

        Transaction::create([
            'data' => $request->list_data,
            'user_id' => $user->id,
            'branch_id' => $branch->id
        ]);

        return Redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
