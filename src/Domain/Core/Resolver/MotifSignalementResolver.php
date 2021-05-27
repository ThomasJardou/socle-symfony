<?php


namespace App\Domain\Core\Resolver;

use App\Domain\Core\Entity\MotifSignalement;
use App\Domain\Core\Query\MotifSignalementQuery;
use App\Domain\Core\Query\RoleQuery;
use App\Domain\Core\Query\TypeDemandeContactQuery;
use App\Domain\Partenaires\Query\PartenaireQuery;
use App\Domain\Publicites\Query\PubliciteQuery;
use App\Domain\Utilisateurs\Query\UtilisateurQuery;
use App\Infrastructure\Orm\Query;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class MotifSignalementResolver implements ArgumentValueResolverInterface
{

    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return $argument->getType() === MotifSignalementQuery::class;
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


        $searchQuery = MotifSignalementQuery::fromData(
            [
                'name' => $baseRequest->has('name') ? (string) $baseRequest->get('name') : null,
            ],
            [
                #todo sort
            ],
            $baseRequest->has('page') ? $baseRequest->get('page') : MotifSignalementQuery::MIN_PAGE,
            $baseRequest->has('size') ? $baseRequest->get('size'): MotifSignalementQuery::MAX_LIMIT
        );

        yield $searchQuery;
    }
}
