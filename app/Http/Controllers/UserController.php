<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $users = $user->currentTeam->allUsers();
        if ($user->super_admin) {
            $admin = true;
        }else {
            $admin = $user->hasTeamRole($user->currentTeam, 'admin');
        }
        
        return Inertia::render('Users/Index', [
            'users' => $users,
            'admin_user' => $admin
        ]);
    }
}
