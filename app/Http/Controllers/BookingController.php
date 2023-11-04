<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request){
        if($request->status == null)
            return back();

        //If search
        if($request->search){
            $booking = Booking::where('id',$request->search)->get();
            return view('pages.admin.bookinglist',[
                'bookings' => $booking
            ]);
        } 

        
        switch($request->status)
        {
            case 'pending':
                $bookings = Booking::where('status','pending')->get();
                break;
            case 'accepted':
                $bookings = Booking::join('accepted_bookings','bookings.id','=','accepted_bookings.booking_id')->where('status','accepted')->orderBy('session_date','asc')->get();
                break;
            case 'rescheduled':
                $bookings = Booking::join('rescheduled_bookings','bookings.id','=','rescheduled_bookings.booking_id')->where('status','rescheduled')->get();
                break;
            case 'completed':
                $bookings = Booking::where('status','completed')->get();
                break;
            default:
                $bookings = Booking::where('status','pending')->get();
                
        }

        return view('pages.admin.bookinglist',[
            'bookings' => $bookings
        ]);
    }

    public function searchBook(Request $request){
        $book = Booking::where('id',$request->search)->first();
        if($book == null){
            return redirect("/bookings?status=null&search=null");
        }
        return redirect("/bookings?status={$book->status}&search={$book->id}");
    }

    
    public function acceptBook(Request $request){
        $booking = Booking::where('id',$request->bookingId)->first();
        $booking->accept($request->paymentAmount,$request->method,$request->message);

        return redirect('/bookings');
    }

    public function acceptReschedule(Request $request){
        $booking = Booking::where('id',$request->bookingId)->first();
        $booking->acceptReschedule($request->message);

        return redirect('/bookings?status=rescheduled');
    }

    public function completeBook(Request $request){
        $booking = Booking::where('id',$request->bookingId)->first();
        $booking->complete();
        
        return redirect('/bookings?status=accepted');
    }

    public function cancelBook(Request $request){
        $booking = Booking::where('id',$request->bookingId)->first();
        $booking->cancel($request->message);
        
        return redirect('/bookings?status=accepted');
    }

    public function declineBook(Request $request){
        $booking = Booking::where('id',$request->bookingId)->first();
        $booking->decline($request->message);
        
        return redirect('/bookings?status=pending');
    }

    public function declineReschedule(Request $request){
        $booking = Booking::where('id',$request->bookingId)->first();
        $booking->declineReschedule($request->message);
        
        return redirect('/bookings?status=rescheduled');
    }
}
