# Eloquent Filterable

With this package, you can optimize query clauses calling before or after the filter. You can manage your queries from a single interface.

## Installation

[PHP](https://php.net/) 5.5.9+ or [HHVM](http://hhvm.com/), and [Composer](https://getcomposer.org/) are required.

To get the latest version of Eloquent Filterable, simply add the following line to the require block of your `composer.json` file:

```php
"require": {
    "mayoz/eloquent-filterable": "~2.0"
}
```

You'll then need to run `composer install` or `composer update` to download it and have the autoloader updated. Or use to shortcut installed through terminal:

```bash
composer require mayoz/eloquent-filterable ~2.0
```

## Usage

1. Create your query filters.
2. Create your Eloquent models.
3. Define `Filterable` trait and use the query filters in the Eloquent model.

### Create Filters

All filters should be extend `Mayoz\Filter\Filter` abstract class. Thus, can be used `before` and `after` methods in your filters.

#### The Before Method

The `before` method responsible to position the **head** of the WHERE clause of the query. For example; we need `published = 1` of query WHERE clause. However, this clause would like to work on before the other clauses.

```php
<?php namespace App\Filters;

use Mayoz\Filter\Filter;

class PublishedFilter extends Filter
{
	/**
	 * The first executable filter clause.
	 *
	 * @param  mixed  $query
	 * @return void
	 */
	public static function before($query)
	{
		$query->where('published', '=', 1);
	}
}
```

#### The After Method

The `after` method responsible to position the **end** of the WHERE clause of the query. For example, if need `status = 'active'` of query WHERE clause. However, this clause would like to work on after the other clauses.

```php
<?php namespace App\Filters;

use Mayoz\Filter\Filter;

class StatusActiveFilter extends Filter
{
	/**
	 * The last executable filter clause.
	 *
	 * @param  mixed  $query
	 * @return void
	 */
	public static function after($query)
	{
		$query->where('status', '=', 'active');
	}
}
```

### Create Model

Create your model file. If you want to manage queries add the `Filterable` trait your model file. And than, assign the all associative filters to `$filters` variable. Consider the following example:

```php
<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Mayoz\Filter\Filterable;

class Post extends Model
{
    use Filterable;

	/**
	 * The attributes that should be filter.
	 *
	 * @var array
	 */
	protected $filters = [
		'App\Filters\StatusActiveFilter',
		'App\Filters\PublishedFilter'
	];

	// other things...
}
```

> **Important:** The order of the filter is important when adding (if need multiple before or after filters) query clause. The before filters are added the head of the clause according to the reference sequence. Likewise, the after filters.

### Debug

Now the `Post` model is ready to use. You ready? Okay, we're testing the query. Don't forget to enable the [query logging](http://laravel.com/docs/5.1/database#listening-for-query-events) for examine the model queries.

```php
$model = \App\Post::where('views', '>', 100)->get();
```

Query logging output:

```sql
SELECT *
FROM   `posts`
WHERE  `published` = 1     # added by automatic filter.
  AND  `views` > 100       # user defined where clause
  AND  `status` = 'active' # added by automatic filter.
```

## Why Use?

For example, you might want to show only the approved text of the visitors on the site. However, administrators can see them all. Create a new extended filter:

```php
<?php namespace App\Filters;

use Auth;
use Mayoz\Filter\Filter;

class StatusActiveFilter extends Filter
{
	/**
	 * The last executable filter clause.
	 *
	 * @param  mixed  $query
	 * @return void
	 */
	public static function after($query)
	{
		# assume, the `users` table has `role` field.
		if (array_get(Auth::user(), 'role') != 'administrator')
		{
			$query->where('status', '=', 'active');
		}
	}
}
```

Hocus, pocus! Visitors will display only the active posts. But administrator display all. Ok?

# Contributing

Love innovation and simplicity. Please use issues all errors or suggestions reporting. Follow the steps for contributing:

1. Fork the repo.
2. Follow the [Laravel Coding Style](http://laravel.com/docs/master/contributions#coding-style).
3. If necessary, check your changes with unittest.
4. Commit all changes.
5. Push your commit and create a new PR.
6. Wait for merge the PR.

# Unit Test

Please create your tests and check before PR. Use the command:

```bash
$ phpunit
```

# License

Eloquent Filterable is licensed under [The MIT License (MIT)](https://github.com/mayoz/eloquent-filterable/blob/master/LICENSE).
