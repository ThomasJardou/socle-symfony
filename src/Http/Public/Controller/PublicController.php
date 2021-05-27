<?php declare(strict_types=1);

namespace App\Http\Public\Controller;

use App\Domain\Annonces\AnnoncesService;
use App\Domain\Annonces\Query\AnnonceQuery;
use App\Domain\Annonces\Query\CategorieQuery;
use App\Domain\MainService;
use App\Http\Controller\MainController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'public-')]
class PublicController extends MainController
{
    public function __construct(public MainService $mainService)
    {}

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('public/index.html.twig', []);
    }
}