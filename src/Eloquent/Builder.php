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

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

/**
 * This is the Eloquent query builder class.
 *
 * @author Sercan Çakır <srcnckr@gmail.com>
 */
class Builder extends EloquentBuilder
{

    /**
     * Create a new Eloquent query builder instance.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @param  \Mayoz\Database\Eloquent\Model      $model
     * @return void
     */
    public function __construct(QueryBuilder $query, Model $model)
    {
        parent::__construct($query);

        parent::setModel($model);

        $this->model->applyFilter($this, 'before');
    }


}
