<?php

namespace App\Filters;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Contracts\Database\Query\Builder;

abstract class BaseFilter
{
    public function handle($request, Closure $next)
    {
        $process = $next($request);
        if (
            ! request()->has($this->filterName())
            || request($this->filterName()) == ''
        ) {
            return $process;
        }

        return $this->applyFilter($process);
    }

    abstract protected function applyFilter(Builder $process);

    protected function filterName(): string
    {
        return Str::camel(class_basename($this));
    }
}
