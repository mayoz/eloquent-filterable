<?php

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
		'StatusActiveFilter',
		'PublishedFilter'
	];
}
