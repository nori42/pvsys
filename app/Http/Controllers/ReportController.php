<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    //
    public function index(){
        $receiveThisMonth = DB::table('payments')
        ->whereMonth('date_of_payment',now()->month)
        ->whereYear('date_of_payment', now()->year)
        ->sum('amount');

        $dueTotal = DB::table('bookings')
        ->where('status','accepted')
        ->sum('payment_balance');

        return view('pages.admin.reportsanalytics',[
            'receiveThisMonth' => $receiveThisMonth,
            'dueTotal' => $dueTotal
        ]);
    }
}
