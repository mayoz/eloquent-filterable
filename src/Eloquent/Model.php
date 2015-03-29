<?php

/*
 * This file is part of Eloquent Filterable.
 *
 * (c) Sercan Çakır <srcnckr@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mayoz\Database\Eloquent;

use Illuminate\Database\Eloquent\Model as IlluminateModel;
use Mayoz\Database\Filter\Filterable;
use Mayoz\Database\Query\Builder as QueryBuilder;

/**
 * This is the Eloquent model class.
 *
 * @author Sercan Çakır <srcnckr@gmail.com>
 */
abstract class Model extends IlluminateModel
{
    use Filterable;

    /**
     * Default query filters.
     *
     * @var array
     */
    protected $filter = [];

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Mayoz\Database\Query\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function newEloquentBuilder($query)
    {
        return new Builder($query, $this);
    }

    /**
     * Get a new query builder instance for the connection.
     *
     * @return \Mayoz\Database\Query\Builder
     */
    protected function newBaseQueryBuilder()
    {
        $conn = $this->getConnection();

        $grammar = $conn->getQueryGrammar();

        $builder = new QueryBuilder($conn, $grammar, $conn->getPostProcessor());

        $builder->model = $this;

        return $builder;
    }

}
