<?php

use App\Models\Booking;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rescheduled_bookings', function (Blueprint $table) {
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Booking::class);
            $table->date('rescheduled_session_date');
            $table->date('rescheduled_start_time');
            $table->date('rescheduled_end_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rescheduled_booking');
    }
};
