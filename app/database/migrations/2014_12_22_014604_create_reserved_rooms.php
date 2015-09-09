<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservedRooms extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reserved_rooms', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('room_id');
			$table->timestamp('check_in');
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
		Schema::table('reserved_rooms', function(Blueprint $table)
		{
			//
		});
	}

}
