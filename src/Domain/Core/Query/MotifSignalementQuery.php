<?php


namespace App\Domain\Core\Query;

use App\Infrastructure\Orm\PaginationTrait;
use App\Infrastructure\Orm\Query;
use App\Infrastructure\Orm\SortTrait;

class MotifSignalementQuery extends Query{
    use PaginationTrait;
    use SortTrait;

    const MIN_PAGE = 1;
    const MAX_LIMIT = 20;
    private $filters = [];

    public function toArray(){
        $res = [];

        foreach (get_object_vars($this) as $key => $values){
            if( !is_null($values) ){
                $res[$key] = $values;
            }
        }

        return $res;
    }


    public static function fromData(?array $filters = [], ?array $sort = [], ?int $page = self::MIN_PAGE, ?int $size = self::MAX_LIMIT)
    {
        $self = new self();
        $self->filters = $filters;
        $self->sort = $sort;
        $self->page = $page;
        $self->size = $size;
        return $self;
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return $this->filters;
    }
}