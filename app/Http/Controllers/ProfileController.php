<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    
    public function index()
    {
        $user = Auth::user();

        return view('profile.index', compact('user'));
    }

    //preparado para implementar profile.edit
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }
}