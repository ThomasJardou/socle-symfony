<?php

namespace App\Domain\Core\Repository;

use App\Domain\Core\Entity\TypeDemandeContact;
use App\Domain\Core\Interface\TypeDemandeContactRepositoryInterface;
use App\Domain\Partenaires\Entity\Partenaire;
use App\Domain\Partenaires\Interface\PartenaireRepositoryInterface;
use App\Domain\Publicites\Entity\Publicite;
use App\Domain\Publicites\Interface\PubliciteRepositoryInterface;
use App\Domain\Utilisateurs\Entity\Utilisateur;
use App\Infrastructure\Orm\AbstractRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Partenaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Partenaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Partenaire[]    findAll()
 * @method Partenaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeDemandeContactRepository extends AbstractRepository implements  TypeDemandeContactRepositoryInterface
{
    protected function getSimpleFilters(): array
    {
        return ['name'];
    }

    protected function getMultipleAssocFilters(): array
    {
        return [];
    }

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator, public $_entityName = TypeDemandeContact::class)
    {
        parent::__construct($registry, $this->_entityName, $paginator);
    }

    public function create(TypeDemandeContact $item): ?TypeDemandeContact
    {
        $this->_em->persist($item);
        $this->_em->flush();
        return $item;
    }

    public function update(TypeDemandeContact $item): ?TypeDemandeContact
    {
        $this->_em->persist($item);
        $this->_em->flush();
        return $item;
    }

    public function delete(TypeDemandeContact $item): ?TypeDemandeContact
    {
        $this->_em->remove($item);
        $this->_em->flush();
        return $item;
    }

    public function read(int $id): ?TypeDemandeContact
    {
        return  $this->find($id);
    }
}
