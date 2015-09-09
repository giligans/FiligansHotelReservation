<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('rooms', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('short_desc');
			$table->text('full_desc');
			$table->integer('max_adults');
			$table->integer('max_children');
			$table->integer('beds');
			$table->integer('bathrooms');
			$table->decimal('area', 5, 2);
			$table->decimal('price', 5, 2);
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
		Schema::table('rooms', function(Blueprint $table)
		{
			//
		});
	}

}
