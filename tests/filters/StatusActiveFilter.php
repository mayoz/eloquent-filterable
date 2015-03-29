<?php

use Mayoz\Filter\Filter;

class StatusActiveFilter extends Filter
{
    /**
     * The first executable filter clause.
     *
     * @param  mixed  $query
     * @return void
     */
    public function after($query)
    {
        $query->where('status', '=', 'active');
    }
}
