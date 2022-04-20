<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\BranchTransaction;
use App\Models\Wallet;
use App\Models\Customer;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Inertia\Inertia;

class BranchTransactionController extends Controller
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
        $transactions = BranchTransaction::where(['branch_id' => $branch->id])->get();
        $wallets = Wallet::where(['team_id' => $user->currentTeam->id])->get();
        $customers = Customer::where(['branch_id' => $branch->id])->get();

        $team = $user->currentTeam;
        if ($user->super_admin) {
            $admin = true;
        }else {
            $admin = $user->hasTeamRole($team, 'admin');
        }

        return Inertia::render('BranchTransactions/Index', [
            'branch' => $branch,
            'wallets' => $wallets,
            'customers' => $customers,
            'transactions' => $transactions,
            'admin_user' => $admin
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

        $request->validate([
            'list_data.money_in.amount' => ['required'],
            'list_data.money_in.paid' => ['required'],
            'list_data.money_out.amount' => ['required']
        ]);

        $user = Auth::user();
        $branch = Branch::whereCode($branch_code)->first();
        $branch->update([
            'config->default->wallet_in' => $request->list_data['money_in']['wallet_id'],
            'config->default->wallet_out' => $request->list_data['money_out']['wallet_id']
        ]);

        $wallet_in = Wallet::find($request->list_data['money_in']['wallet_id']);
        $wallet_in->update([
            'balance' => $wallet_in->balance + $request->list_data['money_in']['paid']
        ]);

        $wallet_out = Wallet::find($request->list_data['money_out']['wallet_id']);
        $wallet_out->update([
            'balance' => $wallet_out->balance - $request->list_data['money_out']['amount']
        ]);

        BranchTransaction::create([
            'data' => $request->list_data,
            'user_id' => $user->id,
            'customer_id' => $request->customer_id,
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
    public function update(Request $request, $branch_code, $id)
    {
        $user = Auth::user();
        $branch = Branch::whereCode($branch_code)->first();

        $transaction = BranchTransaction::find($id);
        $old_data = $transaction->data;

        $wallet_in = Wallet::find($request->list_data['money_in']['wallet_id']);
        if ($wallet_in->id != $old_data['money_in']['wallet_id']) {
            //update old wallet wrong input
            $old_wallet_in = Wallet::find($old_data['money_in']['wallet_id']);
            $old_wallet_in->update([
                'balance' => $old_wallet_in->balance - $old_data['money_in']['paid']
            ]);
            $total_paid = $request->list_data['money_in']['paid'];
        }else {
            $total_paid = $request->list_data['money_in']['paid'] - $old_data['money_in']['paid'];
        }
        $wallet_in->update([
            'balance' => $wallet_in->balance + $total_paid
        ]);

        $wallet_out = Wallet::find($request->list_data['money_out']['wallet_id']);
        if ($wallet_out->id != $old_data['money_out']['wallet_id']) {
            //update old wallet wrong input
            $old_wallet_out = Wallet::find($old_data['money_out']['wallet_id']);
            $old_wallet_out->update([
                'balance' => $old_wallet_out->balance + $old_data['money_out']['amount']
            ]);
        }else {
            if ($old_data['money_out']['amount'] != $request->list_data['money_out']['amount']) {
                $total_amount = $old_data['money_out']['amount'] - $request->list_data['money_out']['amount'];
                $wallet_out->update([
                    'balance' => $wallet_out->balance + $total_amount
                ]);
            }
        }

        $transaction->update([
            'customer_id' => $request->customer_id,
            'data' => $request->list_data
        ]);

        return Redirect::back();
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
