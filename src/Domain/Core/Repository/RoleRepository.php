<?php

namespace App\Domain\Core\Repository;

use App\Domain\Annonces\Entity\Annonce;
use App\Domain\Annonces\Interface\AnnonceRepositoryInterface;
use App\Domain\Core\Entity\Role;
use App\Domain\Core\Interface\RoleRepositoryInterface;
use App\Infrastructure\Orm\AbstractRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Role|null find($id, $lockMode = null, $lockVersion = null)
 * @method Role|null findOneBy(array $criteria, array $orderBy = null)
 * @method Role[]    findAll()
 * @method Role[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoleRepository extends AbstractRepository implements RoleRepositoryInterface
{
    protected function getSimpleFilters(): array
    {
        return ['name', 'slug'];
    }

    protected function getMultipleAssocFilters(): array
    {
        return [];
    }

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator, public $_entityName = Role::class)
    {
        parent::__construct($registry, $this->_entityName, $paginator);

    }

    public function create(Role $item): ?Role
    {
        $this->_em->persist($item);
        $this->_em->flush();
        return $item;
    }

    public function update(Role $item): ?Role
    {
        $this->_em->persist($item);
        $this->_em->flush();
        return $item;
    }

    public function delete(Role $item): ?Role
    {
        $this->_em->remove($item);
        $this->_em->flush();
        return $item;
    }

    public function read(int $id): ?Role
    {
        return $this->find($id);
    }

    public function getWithSlug(string $slug): ?Role
    {
        return $this->findOneBy(['slug'=>$slug]);
    }
}
