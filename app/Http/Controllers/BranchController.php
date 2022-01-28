<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\BranchTransaction;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

use Inertia\Inertia;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $branches = Branch::where(['team_id' => $user->currentTeam->id])->get();
        $transactions = BranchTransaction::whereIn('branch_id', $branches->pluck('id'))->get();
        return Inertia::render('Branches/Index', [
            'branches' => $branches,
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
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required']
        ]);

        $user = Auth::user();

        $default_config = [
            'default' => [
                'wallet_in' => 0,
                'wallet_out' => 0
            ]
        ];
        Branch::create([
            'name' => $request->name,
            'code' => Str::random(5),
            'config' => $default_config,
            'team_id' => $user->currentTeam->id
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
