<?php declare(strict_types=1);

namespace App\Http\Admin\Controller;

use App\Http\Controller\MainController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Domain\Utilisateurs\Entity\Utilisateur;

/**
 * @IsGranted(Utilisateur::ROLE_ADMINISTRATEUR)
 */
#[Route('/admin', name: 'admin-')]
class AdminController extends MainController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }
}