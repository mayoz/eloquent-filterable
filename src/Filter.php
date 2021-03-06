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
 * Filter.
 *
 * @author Sercan Çakır <srcnckr@gmail.com>
 */
abstract class Filter implements FilterInterface
{
    /**
     * The first executable filter clause.
     *
     * @param  mixed  $query
     * @return void
     */
    public function before($query)
    {
        // nothing
    }

    /**
     * The last executable filter clause.
     *
     * @param  mixed  $query
     * @return void
     */
    public function after($query)
    {
        // nothing
    }
}
