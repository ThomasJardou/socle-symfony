<?php

namespace App\Domain\Utilisateurs\Repository;


use App\Domain\Utilisateurs\Interface\UtilisateurRepositoryInterface;
use App\Domain\Utilisateurs\Entity\Utilisateur;
use App\Infrastructure\Orm\AbstractRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method Utilisateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Utilisateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Utilisateur[]    findAll()
 * @method Utilisateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UtilisateurRepository extends AbstractRepository implements PasswordUpgraderInterface, UtilisateurRepositoryInterface
{
    protected function getSimpleFilters(): array
    {
        return ['email', 'pseudo', 'first_name', 'last_name'];
    }

    protected function getMultipleAssocFilters(): array
    {
        return ['roles'];
    }

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator, public $_entityName = Utilisateur::class)
    {
        parent::__construct($registry, $this->_entityName, $paginator);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     * @param UserInterface $user
     * @param string $newEncodedPassword
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof Utilisateur) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function create(Utilisateur $item): ?Utilisateur
    {

        $this->_em->persist($item);
        $this->_em->flush();
        return $item;
    }

    public function update(Utilisateur $item): ?Utilisateur
    {
        $this->_em->persist($item);
        $this->_em->flush();
        return $item;
    }

    public function delete(Utilisateur $item): ?Utilisateur
    {
        $this->_em->remove($item);
        $this->_em->flush();
        return $item;
    }

    public function read(int $id): ?Utilisateur
    {
        return $this->find($id);
    }
}
