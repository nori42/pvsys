<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    //
    public function index(Request $request){

        $month = $request->month == null ? now()->month : $request->month; 

        $receiveThisMonth = DB::table('payments')
        ->whereMonth('date_of_payment',$month)
        ->whereYear('date_of_payment', now()->year)
        ->sum('amount');

        $dueTotal = DB::table('bookings')
        ->where('status','accepted')
        ->sum('payment_balance');

        $topServices = Booking::select('session_type', DB::raw('COUNT(session_type) as count'))
                    ->whereNot('status','pending')
                    ->whereMonth('session_date',$month)
                    ->whereYear('session_date',now()->year)
                    ->groupBy('session_type')
                    ->orderByDesc('count')
                    ->limit(5)
                    ->get();
        $sessionCounts = [
                'corporate_events' => [
                    Utilities::getBookingSessionCount('Conferences',$month),
                    Utilities::getBookingSessionCount('Corporate Parties',$month),
                    Utilities::getBookingSessionCount('Product Launches',$month),
                    Utilities::getBookingSessionCount('Seminars',$month),
                    Utilities::getBookingSessionCount('Team-Building Activites',$month)
                ],
                'commercial_shoots' => [
                    Utilities::getBookingSessionCount('Advertising Campaigns',$month),
                    Utilities::getBookingSessionCount('Funshoots',$month),
                ],
                'portraits' => [
                    Utilities::getBookingSessionCount('Family Portraits',$month),
                    Utilities::getBookingSessionCount('Senior Portraits',$month),
                    Utilities::getBookingSessionCount('Professional Headshots',$month),
                    Utilities::getBookingSessionCount('Lifestyle Photography',$month),
                ],
                'social_events' => [
                    Utilities::getBookingSessionCount('Anniversaries',$month),
                    Utilities::getBookingSessionCount('Baby Showers',$month),
                    Utilities::getBookingSessionCount('Birthdays',$month),
                    Utilities::getBookingSessionCount('Christineng',$month),
                    Utilities::getBookingSessionCount('Graduations',$month),
                ],
                'weddings' => [
                    Utilities::getBookingSessionCount('Bridal Showers',$month),
                    Utilities::getBookingSessionCount('Ceremonies',$month),
                    Utilities::getBookingSessionCount('Engagement Parties',$month),
                    Utilities::getBookingSessionCount('Reception',$month),
                    Utilities::getBookingSessionCount('Ultimate Wedding',$month),
                ]
            ];

        return view('pages.admin.reportsanalytics',[
            'receiveThisMonth' => $receiveThisMonth,
            'dueTotal' => $dueTotal,
            'topServices' => $topServices,
            'sessionCounts' => $sessionCounts
        ]);
    }
}
