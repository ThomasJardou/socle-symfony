<?php


namespace App\Domain\Core\Resolver;


use App\Domain\Annonces\Query\AnnonceQuery;
use App\Domain\Core\Entity\Role;
use App\Domain\Core\Query\RoleQuery;
use App\Infrastructure\Orm\Query;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class RoleResolver implements ArgumentValueResolverInterface
{

    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return $argument->getType() === RoleQuery::class;
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


        $searchQuery = RoleQuery::fromData(
            [
                'name' => $baseRequest->has('name') ? (string) $baseRequest->get('name') : null,
                'slug' => $baseRequest->has('slug') ? (string) $baseRequest->get('slug') : null,
            ],
            [
                #todo sort
            ],
            $baseRequest->has('page') ? $baseRequest->get('page') : RoleQuery::MIN_PAGE,
            $baseRequest->has('size') ? $baseRequest->get('size'): RoleQuery::MAX_LIMIT
        );

        yield $searchQuery;
    }
}
