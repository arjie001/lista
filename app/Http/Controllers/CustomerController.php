<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\BranchTransaction;
use App\Models\Customer;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Inertia\Inertia;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $customers = Customer::with('transactions')->where(['team_id' => $user->currentTeam->id])->get();
        $branches = Branch::where(['team_id' => $user->currentTeam->id])->get();
        return Inertia::render('Customer/Index', [
            'customers' => $customers,
            'branches' => $branches,
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
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required']
        ]);
        $branch = Branch::whereCode($request->branch_code)->first();
        $user = Auth::user();

        Customer::create([
            'name' => $request->name,
            'data' => $request->info,
            'team_id' => $user->currentTeam->id,
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
        $customer = Customer::find($id);
        $branch = Branch::whereCode($request->branch_code)->first();
        $customer->update([
            'name' => $request->name,
            'data' => $request->info,
            'branch_id' => $branch->id
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
