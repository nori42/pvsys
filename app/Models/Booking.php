<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Booking extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    public function user():BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function accept($payment,$method, $message = null){
        $this->status = 'accepted';
        $this->payment_method = $method;
        $this->payment_amount = $payment;

        DB::table('accepted_bookings')->insert([
            'booking_id' => $this->id,
            'user_id' => $this->user_id,
            'date_accepted' => date('Y-m-d')
        ]);

        if($message){
            DB::table('status_messages')
            ->updateOrInsert(
                ['booking_id' => $this->id],
                ['message' => $message]
            );
        }

        return $this->save();
    }

    public function reschedule($date,$message = null){
        $this->status = 'rescheduled';

        if($message){
            DB::table('status_messages')
            ->updateOrInsert(
                ['booking_id' => $this->id],
                ['message' => $message]
            );
        }

        DB::table('accepted_bookings')->where('booking_id',$this->id)->delete();

        DB::table('rescheduled_bookings')->insert([
            'booking_id' => $this->id,
            'user_id' => $this->user_id,
            'original_session_date' => $this->session_date,
            'rescheduled_session_date' => $date
        ]);

        return $this->save();
    }

    public function acceptReschedule($message = null){

        $this->status ='accepted';
        $this->session_date = DB::table('rescheduled_bookings')->where('booking_id',$this->id)->value('rescheduled_session_date');

        DB::table('rescheduled_bookings')->where('booking_id',$this->id)->delete();

        if($message){
            DB::table('status_messages')
            ->updateOrInsert(
                ['booking_id' => $this->id],
                ['message' => $message]
            );
        }

        DB::table('accepted_bookings')->insert([
            'booking_id' =>  $this->id,
            'user_id' => $this->user_id,
            'date_accepted' => date('Y-m-d')
        ]);

        return $this->save();
    }

    public function complete(){
        $this->status = "completed";
        return $this->save();
    }

    public function cancel($message = null){
        $this->status = "cancelled";

        DB::table('accepted_bookings')->where('booking_id',$this->id)->delete();
        DB::table('rescheduled_bookings')->where('booking_id',$this->id)->delete();
        
        if($message){
            DB::table('status_messages')
            ->updateOrInsert(
                ['booking_id' => $this->id],
                ['message' => $message]
            );
        }

        return $this->save();
    }

    public function decline($message = null){
        $this->status = "declined";

        if($message){
            DB::table('status_messages')
            ->updateOrInsert(
                ['booking_id' => $this->id],
                ['message' => $message]
            );
        }

        return $this->save();
    }

    public function declineReschedule($message = null){
        $this->status = "accepted";

        DB::table('rescheduled_bookings')->where('booking_id',$this->id)->delete();

        DB::table('accepted_bookings')->insert([
            'booking_id' => $this->id,
            'user_id' => $this->user_id,
            'date_accepted' => date('Y-m-d')
        ]);

        if($message){
            DB::table('status_messages')
            ->updateOrInsert(
                ['booking_id' => $this->id],
                ['message' => '(Reschedule Declined) '.$message]
            );
        }

        return $this->save();
    }


}
