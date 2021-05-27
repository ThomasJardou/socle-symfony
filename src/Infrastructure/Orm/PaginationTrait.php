<?php

namespace App\Infrastructure\Orm;


/**
 * Trait PaginationTrait
 */
trait PaginationTrait
{
    /**
     * @var int
     */
    protected $page = 1;

    /**
     * @var int
     */
    protected $size = 20;

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

}
