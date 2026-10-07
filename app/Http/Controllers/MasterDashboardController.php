<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterDashboardController extends Controller
{
    public function index()
    {
        return view('master.dashboard');
    }
}