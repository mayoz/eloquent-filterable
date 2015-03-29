<?php

/*
 * This file is part of Eloquent Filterable.
 *
 * (c) Sercan Çakır <srcnckr@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mayoz\Database\Filter;

use Illuminate\Database\Eloquent\Builder;

/**
 * This is the query filtereable trait.
 *
 * @author Sercan Çakır <srcnckr@gmail.com>
 */
trait Filterable
{
    /**
     * Filter handler.
     *
     * @param  \Mayoz\Database\Eloquent\Builder  $query
     * @param  string  $schedule
     * @return void
     */
    public function applyFilter($query, $schedule = 'before')
    {
        foreach($this->getFilter() as $filter)
        {
            if (is_callable([$filter, $schedule]))
            {
                call_user_func([new $filter, $schedule], $query);
            }
        }
    }

    /**
     * Push a new query filter.
     *
     * @param  string  $abstract
     * @return $this
     */
    public function pushFilter($abstract)
    {
        $this->filter[] = $abstract;

        return $this;
    }

    /**
     * Get all query filters.
     *
     * @return array
     */
    public function getFilter()
    {
        return $this->filter;
    }
}
