<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;


class ServiceController extends Controller
{
    public function index(Request $request){

        $bookNew = false;

        $books = Booking::where(function ($query) {
            $query->Where('status', '=', 'accepted')
                  ->orWhere('status', '=', 'rescheduled');
        })
        ->where('user_id',auth()->user()->id)
        ->get();

        if($request->bookNew == "true"){
            foreach ($books as $book) {
                if($book->status == "pending")
                    $book->delete();
            }
            $bookNew = true;
        }

        $userHasBooking = $books->count() != 0;
        $hasPending =  Booking::where('status','pending')
        ->where('user_id',auth()->user()->id)
        ->first() != null;

        return view('pages.client.services',[
            'userHasBooking' => $userHasBooking,
            'hasPending' => $hasPending,
            'bookNew' => $bookNew,
            'services' => Utilities::getServices(),
            'albums' => Utilities::getAlbumPhoto()
        ]);
    }
}
