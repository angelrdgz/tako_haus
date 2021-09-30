<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Account;
class DashboardController extends Controller
{
    public function index(){
        $dayTotal = Account::whereDate('created_at', Carbon::today())->sum('total');
        return view('dashboard.index', ["dayTotal"=>$dayTotal]);
    }
}
