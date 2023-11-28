<?php

use App\Http\Controllers\AboutMeController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FeaturedWorkController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Service;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use App\Models\Booking;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
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

    Route::get('/reports',[ReportController::class,'index'])->name('reports');

    //Booking Routes
    Route::get('/bookings',[BookingController::class,'index'])->name('bookings');
    Route::get('/bookings/search',[BookingController::class,'searchBook'])->name('bookings');
    Route::get('/bookings/{id}',[BookingController::class,'show']);
    Route::post('/bookings/accept',[BookingController::class,'acceptBook']);
    Route::post('/bookings/reschedule',[BookingController::class,'acceptReschedule']);
    Route::post('/bookings/complete',[BookingController::class,'completeBook']);
    Route::post('/bookings/cancel',[BookingController::class,'cancelBook']);
    Route::post('/bookings/decline',[BookingController::class,'declineBook']);
    Route::post('/bookings/declinereschedule',[BookingController::class,'declineReschedule']);
    Route::post('/bookings/addpayment',[BookingController::class,'addpayment']);


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

        // foreach($accptedBooking->groupBy('session_date') as $date => $bookdatesArr){
        //     if(count($bookdatesArr) == 3)
        //     array_push($bookedDates,$date);
        // }

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
            'notAvailDates' => $notAvailDates,
            'notAvailDateMssg' => $notAvailDateRes
        ]);
    })->name('calendar');
    Route::post('/calendar/markdate',function(Request $request){
       if(DB::table('not_available_date')->where('date',$request->date)->exists()){
            DB::table('not_available_date')->where('date',$request->date)->delete();
       }else {
            DB::table('not_available_date')->insert(['date'=>$request->date,'message'=>$request->message]);
        }

       return redirect('/calendar');
    });

    Route::get('/bookingcalendar/{date}/show',function (Request $request){
        $bookings = Booking::where('session_date',$request->date)->get();

        return view('pages.admin.partialview.book',[
            'bookings' => $bookings
        ]);
    });

    // Portfolio
    Route::get('/portfolio/aboutme',[AboutMeController::class,'index'])->name('portfolio');
    Route::post('/portfolio/aboutme',[AboutMeController::class,'updateAboutMe'])->name('portfolio');
    Route::get('/portfolio/featuredwork',[FeaturedWorkController::class,'index'])->name('portfolio');
    Route::post('/portfolio/featuredwork/photo',[FeaturedWorkController::class,'uploadimage'])->name('portfolio');
});

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/services');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/email/verify', function () {
    return view('pages.client.verifyemail');
})->middleware('auth')->name('verification.notice');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// CLIENT ROUTES
Route::middleware(['auth','verified','roletype:CUSTOMER'])->group(function(){

    // Services Routes
    Route::get('/services',[ServiceController::class,'index']);


    //Policy Routes
    Route::get('/policy/reschedule',function(){
        return view('pages.client.book.reschedulepolicy');
    });
    Route::get('/policy/cancellation',function(){
        return view('pages.client.book.cancellationpolicy');
    });

    // Book Routes
    Route::get('/book/create',[BookController::class,'create']);
    Route::get('/book/message',function (Request $request){
        if($request->messageType == null){
            return back();
        }

        return view('pages.client.book.bookMessage');
    });
    
    Route::get('/mybook/{id}',[BookController::class,'index']);
    Route::get('/book/{id}/reschedule',[BookController::class,'reschedule']);
    Route::post('/book/{id}/reschedule',[BookController::class,'rescheduleBook']);
    Route::post('/book/cancel',[BookController::class,'cancelBook']);
    Route::post('/book/{id}/delete',[BookController::class,'destroy']);
    Route::post('/book',[BookController::class,'store']);

});
