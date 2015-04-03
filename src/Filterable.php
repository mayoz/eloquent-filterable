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

use Exception;

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
     * @throws \Exception
     */
    public function filterQuery($query, $schedule = 'before')
    {
        if (property_exists($this, 'filters'))
        {
            array_map(function($filter) use ($query, $schedule)
            {
                $instance = new $filter;

                // All filters must be implements the FilterableInterface.
                // Trust me, this is necessary for the future version capabilities.
                if ( ! $instance instanceof FilterInterface)
                {
                    throw new Exception("The filter must be implement `Mayoz\Filter\FilterInterface`!");
                }

                // The filter should have of before or after (or both) methods.
                // Let's check, do meet the requested method of control?
                if ( ! method_exists($instance, $schedule))
                {
                    throw new Exception("The `{$schedule}` method not found in `{$filter}`!");
                }

                call_user_func([$instance, $schedule], $query);
            }, $this->filters);
        }
    }
}
