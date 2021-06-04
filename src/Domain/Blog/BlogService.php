<?php declare(strict_types=1);

namespace App\Domain\Blog;

use App\Domain\Blog\Entity\Article;
use App\Domain\Blog\Query\ArticleQuery;
use App\Domain\Blog\Repository\ArticleRepository;
use App\Domain\Blog\Validator\ArticleValidator;
use App\Domain\MainService;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class BlogService extends MainService
{
    public function __construct(public EntityManagerInterface $em, public EventDispatcherInterface $dispatcher, private SerializerInterface $serializer,  public PaginatorInterface $paginator,
    public ArticleRepository $articleRepository){}

    public function createArticle(array $data): ?Article
    {
        ArticleValidator::create($data);
        return $this->articleRepository->create($this->serializer->fromArray(
            $data,
            Article::class
        ));
    }

    public function updateArticle(Article $item, array $data): ?Article
    {
        ArticleValidator::update($data);

        return $this->articleRepository->update($this->serializer->fromArray(
            array_merge($this->serializer->toArray($item), $data),
            Article::class
        ));
    }

    public function deleteArticle(Article $item): ?Article
    {
        return $this->articleRepository->delete($item);
    }

    public function readArticle(int $id): ?Article
    {
        return $this->articleRepository->read($id);
    }

    public function listArticle(ArticleQuery $query)
    {
        return $this->articleRepository->list($query);
    }
}