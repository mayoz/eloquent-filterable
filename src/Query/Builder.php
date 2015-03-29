<?php

/*
 * This file is part of Eloquent Filterable.
 *
 * (c) Sercan Çakır <srcnckr@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mayoz\Database\Query;

use Illuminate\Database\Query\Builder as QueryBuilder;
use Mayoz\Database\Eloquent\Model;

/**
 * This is the query builder class.
 *
 * @author Sercan Çakır <srcnckr@gmail.com>
 */
class Builder extends QueryBuilder {

    /**
     * The model implemention.
     */
    public $model;

    /**
     * Execute the query as a "select" statement.
     *
     * @param  array  $columns
     * @return array|static[]
     */
    public function get($columns = array('*'))
    {
        if ($this->model instanceof Model)
        {
            $this->model->applyFilter($this, 'after');
        }

        return parent::get($columns);
    }

}
