<?php

namespace App\Filters\Product;

use App\Filters\BaseFilter;
use Illuminate\Contracts\Database\Query\Builder;

class PriceLessThan extends BaseFilter
{
    public function applyFilter(Builder $builder)
    {
        return $builder->where(function (Builder $query) {
            $query->where('price', '<', request($this->filterName()));
        });
    }
}
