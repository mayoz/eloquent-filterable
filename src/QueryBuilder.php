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

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Query builder.
 *
 * @author Sercan Çakır <srcnckr@gmail.com>
 */
class QueryBuilder extends Builder
{
    /**
     * The model being queried.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Set a model instance for the model being queried.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return static
     */
    public function setModel(Model $model)
    {
        $this->model = $model;

        return $this;
    }

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
            $this->model->filterQuery($this, 'after');
        }

        return parent::get($columns);
    }
}
