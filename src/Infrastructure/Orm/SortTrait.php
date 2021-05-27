<?php

namespace App\Infrastructure\Orm;


/**
 * Trait SortTrait
 * @package App\Query
 */
trait SortTrait
{
    /**
     * @var array|null
     */
    protected $sort;

    /**
     * @return array|null
     */
    public function getSort(): ?array
    {
        return $this->sort;
    }
}
