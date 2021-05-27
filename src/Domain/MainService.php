<?php


namespace App\Domain;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class MainService
{
    public function __construct(public EntityManagerInterface $em, public EventDispatcherInterface $dispatcher){}

    public function paginate(Query $query, $page = 1, $limit = 10) : PaginationInterface
    {
        return $this->paginator->paginate($query, $page, $limit);
    }
}