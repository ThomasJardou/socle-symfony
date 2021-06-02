<?php declare(strict_types=1);

namespace App\Domain\Article;

use App\Domain\MainService;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class ArticleService extends MainService
{
    public function __construct(public EntityManagerInterface $em, public EventDispatcherInterface $dispatcher, private SerializerInterface $serializer,  public PaginatorInterface $paginator){}

}