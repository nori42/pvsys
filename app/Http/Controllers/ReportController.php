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

        $topServices = Booking::select('session_type', DB::raw('COUNT(session_type) as count'))
                    ->whereNot('status','pending')
                    ->groupBy('session_type')
                    ->orderByDesc('count')
                    ->limit(5)
                    ->get();
        $sessionCounts = [
                'corporate_events' => [
                    Utilities::getBookingSessionCount('Conferences'),
                    Utilities::getBookingSessionCount('Corporate Parties'),
                    Utilities::getBookingSessionCount('Product Launches'),
                    Utilities::getBookingSessionCount('Seminars'),
                    Utilities::getBookingSessionCount('Team-Building Activites')
                ],
                'commercial_shoots' => [
                    Utilities::getBookingSessionCount('Advertising Campaigns'),
                    Utilities::getBookingSessionCount('Funshoots'),
                ],
                'portraits' => [
                    Utilities::getBookingSessionCount('Family Portraits'),
                    Utilities::getBookingSessionCount('Senior Portraits'),
                    Utilities::getBookingSessionCount('Professional Headshots'),
                    Utilities::getBookingSessionCount('Lifestyle Photography'),
                ],
                'social_events' => [
                    Utilities::getBookingSessionCount('Anniversaries'),
                    Utilities::getBookingSessionCount('Baby Showers'),
                    Utilities::getBookingSessionCount('Birthdays'),
                    Utilities::getBookingSessionCount('Christineng'),
                    Utilities::getBookingSessionCount('Graduations'),
                ],
                'weddings' => [
                    Utilities::getBookingSessionCount('Bridal Showers'),
                    Utilities::getBookingSessionCount('Ceremonies'),
                    Utilities::getBookingSessionCount('Engagement Parties'),
                    Utilities::getBookingSessionCount('Reception'),
                    Utilities::getBookingSessionCount('Ultimate Wedding'),
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
