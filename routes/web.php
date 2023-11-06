<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Service;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Ramsey\Collection\Map\AssociativeArrayMap;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',LandingController::class)->name('landing');

Route::get('/login', function () {
    Auth::logout();
    return view('pages.client.login');
})->name('login');

Route::get('/admin', function () {
    Auth::logout();
    return view('pages.admin.login');
})->name('loginadmin');

Route::get('/register',[UserController::class,'create']);
Route::post('/register',[UserController::class,'store']);

Route::post('/authenticate',[LoginController::class,'authenticate']);
Route::get('/logout',[LoginController::class,'logout']);

// ADMIN ROUTES
Route::middleware(['auth','roletype:ADMINISTRATOR'])->group(function(){
    Route::get('/admin/services',function(){
        return view('pages.admin.adminservices.index');
    });
    
    Route::get('/admin/services/create',function(){
        return view('pages.admin.adminservices.create');
    });

    Route::get('/dashboard',function(){
        return view('pages.dashboard');
    });


    //Booking Routes
    Route::get('/bookings',[BookingController::class,'index']);
    Route::get('/bookings/search',[BookingController::class,'searchBook']);
    Route::get('/bookings/{id}',[BookingController::class,'show']);
    Route::post('/bookings/accept',[BookingController::class,'acceptBook']);
    Route::post('/bookings/reschedule',[BookingController::class,'acceptReschedule']);
    Route::post('/bookings/complete',[BookingController::class,'completeBook']);
    Route::post('/bookings/cancel',[BookingController::class,'cancelBook']);
    Route::post('/bookings/decline',[BookingController::class,'declineBook']);
    Route::post('/bookings/declinereschedule',[BookingController::class,'declineReschedule']);


    //Booking Calender
    Route::get('/calendar',function (){
        $accptedBooking = Booking::where('status','pending')->orWhere('status','accepted')->get();
        $completedBooking = Booking::where('status','completed')->get();
        $bookedDates = array();
        $completedDates = array();
        $bookedIds = array();   
        $completedIds = array();   
        $notAvailDateRes = DB::table('not_available_date')->get();
        $notAvailDates = array();

        foreach($accptedBooking as $book){
            array_push($bookedDates,$book->session_date);
            $bookedIds[$book->id] = $book->session_date;
        }

        foreach ($completedBooking as $book) {
            array_push($completedDates,$book->session_date);
            $completedIds[$book->id] = $book->session_date;
        }

        foreach ($notAvailDateRes as $res) {
            array_push($notAvailDates,$res->date);
        }

        return view('pages.admin.bookingcalendar',[
            'bookedDates' => $bookedDates,
            'bookedIds' => $bookedIds,
            'completedDates' => $completedDates,
            'completedIds' => $completedIds,
            'notAvailDates' => $notAvailDates
        ]);
    });
    Route::post('/calendar/markdate',function(Request $request){
       if(DB::table('not_available_date')->where('date',$request->date)->exists()){
            DB::table('not_available_date')->where('date',$request->date)->delete();
       }else {
            DB::table('not_available_date')->insert(['date'=>$request->date]);
        }

       return redirect('/calendar');
    });

    Route::get('/bookingcalendar/{id}/show',function (Request $request){
        $book = Booking::find($request->id);

        return view('pages.admin.partialview.book',[
            'book' => $book
        ]);
    });
});


// CLIENT ROUTES
Route::middleware(['auth','roletype:CUSTOMER'])->group(function(){
    // Services Routes
    Route::get('/services',[ServiceController::class,'index']);

    // Book Routes
    Route::get('/book/create',[BookController::class,'create']);
    Route::get('/book/message',function (Request $request){
        if($request->messageType == null){
            return back();
        }

        return view('pages.client.book.bookMessage');
    });

    Route::get('/book/{id}',[BookController::class,'show']);
    Route::get('/book/{id}/reschedule',[BookController::class,'reschedule']);
    Route::post('/book/{id}/reschedule',[BookController::class,'rescheduleBook']);
    Route::post('/book/cancel',[BookController::class,'cancelBook']);
    Route::post('/book/{id}',[BookController::class,'destroy']);
    Route::post('/book',[BookController::class,'store']);
});
