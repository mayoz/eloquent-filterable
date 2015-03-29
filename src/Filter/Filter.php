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

/**
 * This is the query filter class.
 *
 * @author Sercan Çakır <srcnckr@gmail.com>
 */
abstract class Filter
{
    /**
     * The first executable filter clause.
     *
     * @param  mixed  $query
     * @return void
     */
    public function before($query){}

    /**
     * The last executable filter clause.
     *
     * @param  mixed  $query
     * @return void
     */
    public function after($query){}
}
