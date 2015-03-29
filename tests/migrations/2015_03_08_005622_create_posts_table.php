<?php

use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function($table)
		{
			$table->increments('id');
			$table->string('title');
			$table->integer('views')->default(0);
			$table->integer('published');
			$table->string('status');
		});

		DB::table('posts')->insert([
			'title'     => 'Foo',
			'views'     => 10,
			'published' => 0,
			'status'    => 'active'
		]);

		DB::table('posts')->insert([
			'title'     => 'Bar',
			'views'     => 10,
			'published' => 1,
			'status'    => 'active'
		]);

		DB::table('posts')->insert([
			'title'     => 'FooBar',
			'views'     => 20,
			'published' => 1,
			'status'    => 'active'
		]);

		DB::table('posts')->insert([
			'title'     => 'Baz',
			'views'     => 10,
			'published' => 1,
			'status'    => 'passive'
		]);

		DB::table('posts')->insert([
			'title'     => 'FooBaz',
			'views'     => 5,
			'published' => 1,
			'status'    => 'active'
		]);

		DB::table('posts')->insert([
			'title'     => 'Qux',
			'views'     => 5,
			'published' => 1,
			'status'    => 'passive'
		]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('posts');
	}

}
