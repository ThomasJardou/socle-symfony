<?php

namespace App\Domain\Blog\Repository;

use App\Domain\Blog\Entity\Article;
use App\Domain\Blog\Interface\ArticleRepositoryInterface;
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
class ArticleRepository extends AbstractRepository implements ArticleRepositoryInterface
{
    protected function getSimpleFilters(): array
    {
        return ['title'];
    }

    protected function getMultipleAssocFilters(): array
    {
        return [];
    }

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator, public $_entityName = Article::class)
    {
        parent::__construct($registry, $this->_entityName, $paginator);

    }

    public function create(Article $item): ?Article
    {
        $this->_em->persist($item);
        $this->_em->flush();
        return $item;
    }

    public function update(Article $item): ?Article
    {
        $this->_em->persist($item);
        $this->_em->flush();
        return $item;
    }

    public function delete(Article $item): ?Article
    {
        $this->_em->remove($item);
        $this->_em->flush();
        return $item;
    }

    public function read(int $id): ?Article
    {
        return $this->find($id);
    }

    public function getWithSlug(string $slug): ?Article
    {
        return $this->findOneBy(['slug'=>$slug]);
    }
}
