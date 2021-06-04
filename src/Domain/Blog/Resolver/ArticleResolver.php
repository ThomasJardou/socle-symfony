<?php


namespace App\Domain\Blog\Resolver;


use App\Domain\Blog\Query\ArticleQuery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class ArticleResolver implements ArgumentValueResolverInterface
{

    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return $argument->getType() === ArticleQuery::class;
    }

    /**
     * @param Request $request
     * @param ArgumentMetadata $argument
     * @return \Generator|iterable
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        if ($request->isMethod('post')) {
            $baseRequest = $request->request;
        } else {
            $baseRequest = $request->query;
        }


        $searchQuery = ArticleQuery::fromData(
            [
                'title' => $baseRequest->has('title') ? (string) $baseRequest->get('title') : null,
            ],
            [
                #todo sort
            ],
            $baseRequest->has('page') ? $baseRequest->get('page') : ArticleQuery::MIN_PAGE,
            $baseRequest->has('size') ? $baseRequest->get('size'): ArticleQuery::MAX_LIMIT
        );

        yield $searchQuery;
    }
}
