<?php

use Orchestra\Testbench\TestCase;

class EloquentFilterTest extends TestCase {

	/**
	 * Setup the test environment.
	 */
	public function setUp()
	{
		parent::setUp();

		// Create an artisan object for calling migrations
		$artisan = $this->app->make('Illuminate\Contracts\Console\Kernel');

		// Call migrations specific to our tests, e.g. to seed the db
		$artisan->call('migrate', array(
			'--database' => 'testbench',
			'--path'     => '../tests/migrations',
		));
	}

	/**
	 * Define environment setup.
	 *
	 * @param  Illuminate\Foundation\Application    $app
	 * @return void
	 */
	protected function getEnvironmentSetUp($app)
	{
		$app['path.base'] = __DIR__ . '/../src';

		$app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        DB::connection()->enableQueryLog();
	}

	public function testAll()
	{
		$post  = Post::all();
		$debug = last(DB::getQueryLog());

		$this->assertCount(3, $post);
		$this->assertEquals('select * from "posts" where "published" = ? and "status" = ?', $debug['query']);
	}

	public function testGet()
	{
		$post  = Post::where('views', '>=', 10)->get();
		$debug = last(DB::getQueryLog());

		$this->assertCount(2, $post);
		$this->assertEquals('select * from "posts" where "published" = ? and "views" >= ? and "status" = ?', $debug['query']);
	}

	public function testFirst()
	{
		$post  = Post::first();
		$debug = last(DB::getQueryLog());

		$this->assertEquals('Bar', $post->title);
		$this->assertEquals('select * from "posts" where "published" = ? and "status" = ? limit 1', $debug['query']);
	}

	public function testFirstWithClause()
	{
		$post  = Post::where('views', '>', 10)->first();
		$debug = last(DB::getQueryLog());

		$this->assertEquals('FooBar', $post->title);
		$this->assertEquals('select * from "posts" where "published" = ? and "views" > ? and "status" = ? limit 1', $debug['query']);
	}

	public function testAggregate()
	{
		$count = Post::count();
		$debug = last(DB::getQueryLog());

		$this->assertEquals(3, $count);
		$this->assertEquals('select count(*) as aggregate from "posts" where "published" = ? and "status" = ?', $debug['query']);
	}

	public function testAggregateWithClause()
	{
		$count = Post::where('views', '>=', 10)->count();
		$debug = last(DB::getQueryLog());

		$this->assertEquals(2, $count);
		$this->assertEquals('select count(*) as aggregate from "posts" where "published" = ? and "views" >= ? and "status" = ?', $debug['query']);
	}

	public function testExists()
	{
		$exists = Post::where('views', '>=', 10)->exists();
		$debug  = last(DB::getQueryLog());

		$this->assertTrue($exists);
		$this->assertEquals('select count(*) as aggregate from "posts" where "published" = ? and "views" >= ? and "status" = ? limit 1', $debug['query']);
	}

	public function testLists()
	{
		$lists = Post::where('views', '>=', 10)->lists('id', 'title');
		$debug = last(DB::getQueryLog());

		$this->assertEquals(['Bar' => 2, 'FooBar' => 3], $lists);
		$this->assertEquals('select "id", "title" from "posts" where "published" = ? and "views" >= ? and "status" = ?', $debug['query']);
	}

}
