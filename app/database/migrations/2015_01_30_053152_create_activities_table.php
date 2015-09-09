<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('activies', function(Blueprint $table)
		{
			$table->increments('id');
			$table->boolean('activity');
			$table->text('LOGS');
			$table->integer('actor');
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
		Schema::table('activies', function(Blueprint $table)
		{
			//
		});
	}

}
