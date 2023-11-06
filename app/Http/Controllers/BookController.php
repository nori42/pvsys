<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class BookController extends Controller
{
    //
    public function create(Request $request){

        // Check if there is a current pending or cancelled booking
        $books = Booking::where(function ($query) {
            $query->where('status', 'pending')
                  ->orWhere('status', 'declined')
                  ->orWhere('status', 'cancelled');
        })->where('user_id',auth()->user()->id)->get();

        if($books->count() != 0){
            foreach ($books as $book) {
                $book->truncate();
            }
        }

        if($request->session == null)
        return back();

        $accptedBooking = Booking::where('status','pending')->orWhere('status','accepted')->get();
        $notAvailDateRes = DB::table('not_available_date')->get();
        $notAvailDates = array();
        $bookedDates = array();

        foreach($accptedBooking as $book){
            array_push($bookedDates,$book->session_date);
        }

        foreach ($notAvailDateRes as $res) {
            array_push($notAvailDates,$res->date);
        }

        return view('pages.client.book.create',[
            'service' => $request->session,
            'bookedDates' => $bookedDates,
            'notAvailDates' => $notAvailDates
        ]);
    }
    
    public function show(Request $request){
        $book = Booking::join('status_messages', 'bookings.id', '=', 'status_messages.booking_id')
        ->where('status','!=','completed')
        ->where('user_id',$request->id)
        ->get()
        ->first();

        return view('pages.client.book.show',[
            'book' => $book
        ]);
    }

    public function store(Request $request){
        // IncrementCouter
        if(DB::table('insertion_counts')->where('table_name', 'bookings')->exists()){
            DB::table('insertion_counts')->where('table_name','bookings')->increment('count',1);
        } else {
            DB::table('insertion_counts')->insert([
                'table_name' => 'bookings',
                'count' => 1
            ]);
        }

        define('defaultStatus',"pending");
        
        $inputs = $request->collect();
        $booking = new Booking();
        $uniqueId =  DB::table('insertion_counts')->where('table_name','bookings')->value('count');
        $bookingDateId = date('mY');
        $bookingId = "{$bookingDateId}{$inputs['userId']}{$uniqueId}";
        $booking->id = $bookingId;
        $booking->session_category = Utilities::getCategory(($inputs['sessionType']));
        $booking->session_type = ucwords($inputs['session']);
        $booking->session_date = $inputs['datePicked'];
        $booking->start_time = $inputs['startTime'];
        $booking->end_time = $inputs['endTime'];
        $booking->payment_method = "Not Paid";
        $booking->event_location = $inputs['eventLocation'];
        $booking->status = defaultStatus; 

        if($request->isPhoto != null && $request->isVideo != null){
            $booking->service_type = $inputs['isPhoto'].' and '.$inputs['isVideo'];
        }else if($request->isPhoto){
            $booking->service_type = $inputs['isPhoto'];
        }else{
            $booking->service_type = $inputs['isVideo'];
        }

        $booking->booked_date = date('Y-m-d');
        $booking->more_details = $inputs['moreDetails'];
        $booking->user_id = $inputs['userId'];
        $booking->save();

        DB::table('status_messages')->insert(
                ['booking_id' => $bookingId],
                ['message' => null]
            );


        return redirect('book/message?messageType=submit');
    }

    public function reschedule(Request $request){
        $book = Booking::find($request->id);

        $accptedBooking = Booking::whereOr('status','pending')->whereOr('status','accepted')->get();
        $bookedDates = array();

        foreach($accptedBooking as $book){
            array_push($bookedDates,$book->session_date);
        }

        return view('pages.client.book.reschedule',[
            'book' => $book,
            'bookedDates' => $bookedDates
        ]);
    }

    public function rescheduleBook(Request $request){
        $booking = Booking::where('id',$request->id)->first();
        $booking->reschedule($request->datePicked);
        
        return redirect('book/message?messageType=rescheduled');
    }

    public function cancelBook(Request $request){
        $booking = Booking::where('id',$request->bookingId)->first();
        $booking->truncate();
        
        return redirect('book/message?messageType=cancelled');

    }
}
