<?php

use Mayoz\Database\Filter\Filter;

class PublishedFilter extends Filter
{
    /**
     * The last executable filter clause.
     *
     * @param  mixed  $query
     * @return void
     */
    public function before($query)
    {
        $query->where('published', '=', 1);
    }
}
