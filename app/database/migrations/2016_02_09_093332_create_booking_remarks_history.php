<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingRemarksHistory extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('booking_remarks_history', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('booking_id');
			$table->double('deduction');
			$table->double('additional');
			$table->text('remarks');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('booking_remarks_history', function(Blueprint $table)
		{
			//
		});
	}

}
