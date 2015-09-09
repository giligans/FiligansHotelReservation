<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bookings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->boolean('status');
			$table->timestamp('cancelled_at');
			$table->text('cancelled_remarks');
			$table->string('firstname');
			$table->string('lastname');
			$table->text('address');
			$table->string('contact_number');
			$table->string('email_address');
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
		Schema::table('bookings', function(Blueprint $table)
		{
			//
		});
	}

}
