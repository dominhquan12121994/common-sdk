<?php

namespace Common\Repositories\Filters;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class AbstractFilter
 * @package App\Repositories\Filters
 */
abstract class AbstractFilter
{
    protected $builder;

    protected $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public static function new($payload)
    {
        return new static($payload);
    }

    public function apply($builder)
    {
        $this->builder = $builder;
        foreach ($this->payload as $key => $value) {
            $methodName = Str::camel($key);
            if (method_exists($this, $methodName)) {
                call_user_func_array([$this, $methodName], [$value]);
            }
        }
        return $this->builder;
    }
}
