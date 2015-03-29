<?php

/*
 * This file is part of Eloquent Filterable.
 *
 * (c) Sercan Çakır <srcnckr@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mayoz\Filter;

/**
 * Filter trait.
 *
 * @author Sercan Çakır <srcnckr@gmail.com>
 */
trait Filterable
{
    /**
     * Get a new query builder for the model's table.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function newQuery()
    {
        $query = parent::newQuery();

        $this->filterQuery($query, 'before');

        return $query;
    }

    /**
     * Get a new query builder instance for the connection.
     *
     * @return \Mayoz\Filter\QueryBuilder
     */
    protected function newBaseQueryBuilder()
    {
        $conn = $this->getConnection();

        $grammar = $conn->getQueryGrammar();

        $builder = new QueryBuilder($conn, $grammar, $conn->getPostProcessor());

        $builder->setModel($this);

        return $builder;
    }

    /**
     * Filter handler.
     *
     * @param  mixed   $query
     * @param  string  $schedule
     * @return void
     */
    public function filterQuery($query, $schedule = 'before')
    {
        if (property_exists($this, 'filters'))
        {
            foreach($this->filters as $filter)
            {
                if (is_callable([$filter, $schedule]))
                {
                    call_user_func([new $filter, $schedule], $query);
                }
            }
        }
    }
}
