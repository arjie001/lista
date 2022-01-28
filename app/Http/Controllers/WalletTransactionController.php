<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\WalletTransaction;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use Inertia\Inertia;

class WalletTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($walelt_code)
    {
        $user = Auth::user();
        $wallet = Wallet::whereCode($walelt_code)->first();
        $transactions = WalletTransaction::with('user')->where(['wallet_id' => $wallet->id])->get();
        return Inertia::render('WalletTransactions/Index', [
            'wallet' => $wallet,
            'transactions' => $transactions,
            'admin_user' => $user->hasTeamRole($user->currentTeam, 'admin')
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
    public function store(Request $request, $wallet_code)
    {
        $wallet = Wallet::whereCode($wallet_code)->first();
        $user = Auth::user();

        if ($request->list_data['method'] == 'in') {
            $new_balance = $wallet->balance + $request->list_data['amount'];
        } else {
            $new_balance = $wallet->balance - $request->list_data['amount'];
        }
        
        $wallet->update([
            'balance' =>  $new_balance
        ]);

        $transaction = WalletTransaction::create([
            'data' => $request->list_data,
            'user_id' => $user->id,
            'wallet_id' => $wallet->id
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
