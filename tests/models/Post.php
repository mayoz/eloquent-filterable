<?php

use Mayoz\Database\Eloquent\Model;

class Post extends Model {

	/**
	 * Query filter abstracts.
	 *
	 * @var array
	 */
	protected $filter = [
		'StatusActiveFilter',
		'PublishedFilter'
	];

}
