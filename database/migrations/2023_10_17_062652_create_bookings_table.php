<?php

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
        Schema::create('bookings', function (Blueprint $table) {
            $table->string('id');
            $table->string('session_category');
            $table->string('session_type');
            $table->date('session_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('event_location');
            $table->string('service_type');
            $table->string('payment_method')->nullable();
            $table->string('payment_amount')->nullable();
            $table->date('booked_date');
            $table->text('more_details')->nullable();
            $table->enum('status',['pending','accepted','declined','rescheduled','completed','cancelled','declined']);
            $table->foreignIdFor(User::class,'user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};
