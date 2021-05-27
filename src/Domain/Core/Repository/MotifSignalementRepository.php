<?php

namespace App\Domain\Core\Repository;

use App\Domain\Core\Entity\MotifSignalement;
use App\Domain\Core\Interface\MotifSignalementRepositoryInterface;
use App\Domain\Partenaires\Entity\Partenaire;
use App\Infrastructure\Orm\AbstractRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class MotifSignalementRepository
 * @package App\Domain\Core\Repository
 */
class MotifSignalementRepository extends AbstractRepository implements  MotifSignalementRepositoryInterface
{
    protected function getSimpleFilters(): array
    {
        return ['name'];
    }

    protected function getMultipleAssocFilters(): array
    {
        return [];
    }

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator, public $_entityName = MotifSignalement::class)
    {
        parent::__construct($registry, $this->_entityName, $paginator);
    }

    public function create(MotifSignalement $item): ?MotifSignalement
    {
        $this->_em->persist($item);
        $this->_em->flush();
        return $item;
    }

    public function update(MotifSignalement $item): ?MotifSignalement
    {
        $this->_em->persist($item);
        $this->_em->flush();
        return $item;
    }

    public function delete(MotifSignalement $item): ?MotifSignalement
    {
        $this->_em->remove($item);
        $this->_em->flush();
        return $item;
    }

    public function read(int $id): ?MotifSignalement
    {
        return  $this->find($id);
    }
}
