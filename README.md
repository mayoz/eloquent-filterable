# Eloquent Filterable

With this package, you can optimize query clauses calling before or after the filter. You can manage your queries from a single interface.

## Installation

[PHP](https://php.net/) 5.4+ or [HHVM](http://hhvm.com/) 3.3+, and [Composer](https://getcomposer.org/) are required.

To get the latest version of Eloquent Filterable, simply add the following line to the require block of your `composer.json` file:

```php
"require": {
    "mayoz/eloquent-filterable": "~1.0"
}
```

You'll then need to run `composer install` or `composer update` to download it and have the autoloader updated.

or use to shortcut installed through terminal:

```bash
composer require mayoz/eloquent-filterable ~1.0
```

Once Eloquent Filterable is installed, you need to replace the Eloquent aliases. Open up config/app.php and find the `Eloquent` alias. Edit as following:

```php
'aliases' => [
    ...
    'Eloquent' => 'Mayoz\Database\Eloquent\Model',
    ...
];
```

## Usage

1. Create your query filters.
2. Create your Eloquent models.
3. Use the query filters in the Eloquent model.

### Create Filters

All filters must be extend `Mayoz\Database\Filter\Filter` abstract class. Thus, can be used `before` and `after` methods in your filters.

#### The Before Method

The `before` method responsible to position the **head** of the WHERE clause of the query. For example; we need `published = 1` of query WHERE clause. However, this clause would like to work on before the other clauses.

```php
<?php namespace App\Filters;

use Mayoz\Database\Filter\Filter;

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

use Mayoz\Database\Filter\Filter;

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

Your models must be extended `Mayoz\Database\Eloquent\Model` abstract class. Assign the filters to `$filter` variable. Consider the following example:

```php
<?php namespace App;

use Mayoz\Database\Eloquent\Model;

class Post extends Model {

	/**
	 * Default query filters.
	 *
	 * @var array
	 */
	protected $filter = [
		'App\Filters\StatusActiveFilter',
		'App\Filters\PublishedFilter'
	];

	// other things...

}
```

>> **Important:** The order of the filter is important when adding (if need multiple before or after filters) query clause. The before filters are added the head of the clause according to the reference sequence. Likewise, the after filters.

### Debug

Now the `Post` model is ready to use. You ready? Okay, we're testing the query. Don't forget to enable the [query logging](http://laravel.com/docs/5.0/database#query-logging) for examine the model queries.

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