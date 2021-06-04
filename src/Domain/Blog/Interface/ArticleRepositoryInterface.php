<?php


namespace App\Domain\Blog\Interface;
use App\Domain\Annonces\Entity\Annonce;
use App\Domain\Blog\Entity\Article;
use App\Domain\Core\Entity\Role;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

interface ArticleRepositoryInterface
{
    public function create(Article $item): ?Article;
    public function update(Article $item): ?Article;
    public function delete(Article $item): ?Article;
    public function read(int $id): ?Article;

    public function getWithSlug(string $slug): ?Article;
}