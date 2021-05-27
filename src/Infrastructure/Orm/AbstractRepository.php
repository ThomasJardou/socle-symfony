<?php


namespace App\Infrastructure\Orm;


use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

abstract class AbstractRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, string $entityClass, public PaginatorInterface $paginator)
    {
        parent::__construct($registry, $entityClass);
    }

    protected function getSimpleFilters(){return [];}

    protected function getMultipleAssocFilters(){return [];}

    public function list(Query $listQuery)
    {
        $simpleFilters = $this->getSimpleFilters();
        $multipleAssocFilters = $this->getMultipleAssocFilters();

        $query = $this->createQueryBuilder('e');

        foreach ($listQuery->getFilters() as $key => $filter) {
            if (empty($filter) && $filter !== false) {
                continue;
            }

            // Simple filtres applicables (voir méthode getSimpleFilters)
            if (\in_array($key, $simpleFilters, true)) {
                if (\is_iterable($filter)) {
                    $query = $query->andWhere(sprintf('e.%s IN (:%s)', $key, $key))
                        ->setParameter($key, $filter);
                } else {
                    $query = $query->andWhere(sprintf('e.%s LIKE :%s', $key, $key))
                        ->setParameter($key, '%'.$filter.'%');
                }
            }

            // Multiples filtres applicables (voir méthode getMultipleAssocFilters)
            if (\in_array($key, $multipleAssocFilters, true)) {
                if (!is_null($filter)){
                    $alias = substr($key, 0, 2);
                    $query = $query
                        ->leftJoin(sprintf('e.%s', $key), $alias)
                        ->andWhere(sprintf('%s.id IN (:%s)', $alias, $alias))
                        ->setParameter($alias, $filter);
                }
            }
        }
        if (!empty($listQuery->getSort())) {
            foreach ($listQuery->getSort() as $field => $order) {
                $query = $query->addOrderBy((string) $field, $order);
            }
        }

        return $this->paginator->paginate($query, $listQuery->getPage(), $listQuery->getSize());
    }
}