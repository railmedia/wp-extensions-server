<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Extension;
use App\Models\User;

class DashboardController extends Controller
{

    public function dashboard() {

        $extensions = Extension::orderBy('created_at', 'desc')->take(10)->get();
        $users      = User::orderBy('created_at', 'desc')->take(10)->get();

        return view('dashboard')
            ->with( 'extensions', $extensions )
            ->with( 'users', $users );

    }

}