<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->date('date');
            $table->string('time');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone_number');
            $table->string('user_id')->default(null);
            $table->integer('wetsuits_count')->default(0);
            $table->integer('rental_wakeboards_count')->default(0);
            $table->integer('payment_status');
            $table->integer('price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
