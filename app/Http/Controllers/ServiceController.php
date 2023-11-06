<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;


class ServiceController extends Controller
{
    public function index(Request $request){
        $serviceCategory = [
            'corporate_events' => ['CONFERENCES', 'CORPORATE PARTIES', 'PRODUCT LAUNCHES', 'SEMINARS', 'TEAM BUILDING ACTIVITIES'],
            'commercial_shoots' => ['ADVERTISING CAMPAIGNS', 'FASHION SHOOTS'],
            'portraits' => ['FAMILY PORTRAITS', 'LIFESTYLE PHOTOGRAPHY', 'PROFESSIONAL HEADSHOTS', 'SENIOR PORTRAITS'],
            'social_events' => ['ANNIVERSARIES', 'BABY SHOWER','CHRISTENING','BIRTHDAYS', 'GRADUATION'],
            'weddings' => ['BRIDAL SHOWERS', 'CEREMONIES', 'ENGAGEMENT PARTIES', 'RECEPTION','PRENUP','ULTIMATE WEDDING EXPERIENCE'],
        ];

        $serviceArr = array();

        $bookNew = false;


        $books = Booking::where(function ($query) {
            $query->Where('status', '=', 'accepted')
                  ->orWhere('status', '=', 'rescheduled');
        })
        ->where('user_id',auth()->user()->id)
        ->get();

        foreach ($serviceCategory as $category => $services) {
            foreach ($services as $service) {
                array_push($serviceArr, new Service($service,$category,str_replace(' ','_',$service)));
            }
        }

        if($request->bookNew == "true"){
            foreach ($books as $book) {
                if($book->status == "pending")
                    $book->delete();
            }
            $bookNew = true;
        }

        $services = collect($serviceArr);

        $userHasBooking = $books->count() != 0;
        $hasPending =  Booking::where('status','pending')
        ->where('user_id',auth()->user()->id)
        ->first() != null;

        return view('pages.client.services',[
            'userHasBooking' => $userHasBooking,
            'hasPending' => $hasPending,
            'bookNew' => $bookNew,
            'services' => $services->groupBy('type')
        ]);
    }
}
