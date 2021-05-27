<?php


namespace App\Domain\Utilisateurs\Resolver;

use App\Domain\Utilisateurs\Query\UtilisateurQuery;
use App\Infrastructure\Orm\Query;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class UtilisateurResolver implements ArgumentValueResolverInterface
{

    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return $argument->getType() === UtilisateurQuery::class;
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


        $searchQuery = UtilisateurQuery::fromData(
            [
                'email' => $baseRequest->has('email') ? (string) $baseRequest->get('email') : null,
                'pseudo' => $baseRequest->has('pseudo') ? (string) $baseRequest->get('pseudo') : null,
                'last_name' => $baseRequest->has('id') ? (string) $baseRequest->get('last_name') : null,
                'first_name' => $baseRequest->has('id') ? (string) $baseRequest->get('first_name') : null,
                'roles' => $baseRequest->has('role') ? (int) $baseRequest->get('role') : null,
            ],
            [
                #todo sort
            ],
            $baseRequest->has('page') ?(bool) $baseRequest->get('page') : UtilisateurQuery::MIN_PAGE,
            $baseRequest->has('size') ? (bool) $baseRequest->get('size'): UtilisateurQuery::MAX_LIMIT
        );

        yield $searchQuery;
    }
}
