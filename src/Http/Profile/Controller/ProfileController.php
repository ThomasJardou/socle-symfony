<?php declare(strict_types=1);

namespace App\Http\Profile\Controller;

use App\Http\Controller\MainController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profile', name: 'profile-')]
class ProfileController extends MainController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('profile/index.html.twig', []);
    }
}